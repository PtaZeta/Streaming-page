<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class StreamStatusController extends Controller
{
    public function checkStatus()
    {
        $twitchLogin = env('TWITCH_LOGIN');
        $twitchClientId = env('TWITCH_CLIENT_ID');
        $twitchAccessToken = env('TWITCH_ACCESS_TOKEN');
        $kickChannel = env('KICK_CHANNEL');

        // Check cache first (2 seconds for faster updates)
        $cacheKey = 'stream_status_cache';
        $cached = Cache::get($cacheKey);
        if ($cached && now()->diffInSeconds($cached['timestamp']) < 2) {
            return response()->json($cached['data'], 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_UNICODE);
        }

        // Use Twitch Helix API
        $response = null;
        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'Client-ID' => $twitchClientId,
                    'Authorization' => 'Bearer ' . $twitchAccessToken,
                ])
                ->get("https://api.twitch.tv/helix/streams", [
                    'user_login' => $twitchLogin
                ]);
        } catch (\Exception $e) {
            $response = null;
        }

        $twitchData = $this->checkTwitchStatus($twitchLogin, $response);
        $kickData = $this->checkKickStatus($kickChannel);
        $override = $this->getOverrideStatus();

        // Determine if live and platform
        $twitchLive = $twitchData['live'] && !$override['offline'];
        $kickLive = $kickData['live'] && !$override['offline'];
        
        $liveData = null;
        $platform = null;
        
        if ($twitchLive) {
            $liveData = $twitchData;
            $platform = 'twitch';
        } elseif ($kickLive) {
            $liveData = $kickData;
            $platform = 'kick';
        }

        $result = [
            'twitch' => $twitchLive,
            'kick' => $kickLive,
            'isLive' => $twitchLive || $kickLive,
            'platform' => $platform,
            'streamData' => $liveData,
            'twitchData' => $twitchData,
            'kickData' => $kickData,
        ];

        // Cache for 2 seconds
        Cache::put($cacheKey, ['data' => $result, 'timestamp' => now()], 2);

        return response()->json($result, 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_UNICODE);
    }

    private function checkTwitchStatus($login, $response)
    {
        $data = [
            'live' => false,
            'title' => '',
            'viewers' => 0,
            'thumbnail' => '',
            'game' => '',
            'url' => "https://twitch.tv/{$login}"
        ];

        // Try Helix API first
        if ($response && $response->successful()) {
            try {
                $json = $response->json();
                if (isset($json['data']) && !empty($json['data'])) {
                    $stream = $json['data'][0];
                    $data['live'] = true;
                    $data['title'] = $stream['title'] ?? '';
                    $data['viewers'] = $stream['viewer_count'] ?? 0;
                    $data['game'] = $stream['game_name'] ?? 'Sin categoría';
                    
                    // Build thumbnail URL
                    if (isset($stream['thumbnail_url'])) {
                        $data['thumbnail'] = str_replace(['{width}', '{height}'], ['640', '360'], $stream['thumbnail_url']);
                    }
                    
                    return $data;
                } else {
                    // API says not live, return offline state
                    return $data;
                }
            } catch (\Exception $e) {
                // Continue to HTML fallback
            }
        }

        // Fallback to HTML scraping
        try {
            $htmlResponse = Http::timeout(3)->get("https://www.twitch.tv/{$login}");
            if ($htmlResponse->successful()) {
                $html = $htmlResponse->body();
                $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
                
                // Check if stream is live
                if (preg_match('/"isLiveBroadcast"\s*:\s*true/i', $html) || 
                    preg_match('/"isLive"\s*:\s*true/i', $html) ||
                    preg_match('/"type"\s*:\s*"LIVE"/i', $html)) {
                    $data['live'] = true;
                    
                    // Extract title from meta tag or JSON
                    if (preg_match('/<meta\s+name="description"\s+content="([^"]*)"/', $html, $m)) {
                        $data['title'] = htmlspecialchars_decode($m[1]);
                    } elseif (preg_match('/"broadcastSettings"\s*:\s*\{[^}]*"title"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                        $data['title'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                    } elseif (preg_match('/"title"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                        $data['title'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                    }
                    
                    // Extract viewers
                    if (preg_match('/"viewersCount"\s*:\s*(\d+)/i', $html, $m)) {
                        $data['viewers'] = (int)$m[1];
                    }
                    
                    // Extract game/category using JSON LD or meta tags first
                    if (preg_match('/<script\s+type="application\/ld\+json"[^>]*>([^<]+)<\/script>/', $html, $ldMatch)) {
                        try {
                            $jsonLd = json_decode($ldMatch[1], true);
                            if (isset($jsonLd['publication']['name'])) {
                                $data['game'] = $jsonLd['publication']['name'];
                            }
                        } catch (\Exception $e) {}
                    }
                    
                    // If not found, try embedded JSON patterns
                    if (empty($data['game'])) {
                        if (preg_match('/"game"\s*:\s*\{\s*"[^"]*"\s*:\s*"[^"]*"\s*,\s*"displayName"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        } elseif (preg_match('/"broadcastSettings"\s*:\s*\{[^}]*"game"\s*:\s*\{[^}]*"displayName"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        } elseif (preg_match('/"game"\s*:\s*\{[^}]*"displayName"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        } elseif (preg_match('/"game"\s*:\s*\{[^}]*"name"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        } elseif (preg_match('/"gameName"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        } elseif (preg_match('/"category"\s*:\s*\{[^}]*"name"\s*:\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                            $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                        }
                    }
                    
                    // If still empty, set default
                    if (empty($data['game'])) {
                        $data['game'] = 'Sin categoría';
                    }
                    
                    // Extract thumbnail from stream preview (prefer 640x360 for high res)
                    if (preg_match('/"thumbnailUrl"\s*:\s*\[\s*"[^"]*",\s*"[^"]*",\s*"([^"]*640x360[^"]*)"/', $html, $m)) {
                        $data['thumbnail'] = $m[1];
                    } elseif (preg_match('/"thumbnailUrl"\s*:\s*\[\s*"([^"]*)"/', $html, $m)) {
                        // Fallback to first thumbnail in array
                        $data['thumbnail'] = $m[1];
                    } elseif (preg_match('/"previewImageURL"\s*:\s*"([^"]*)"/', $html, $m)) {
                        $data['thumbnail'] = $m[1];
                    } elseif (preg_match('/<meta\s+property="og:image"\s+content="([^"]*)"/', $html, $m)) {
                        $data['thumbnail'] = $m[1];
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail
        }

        return $data;
    }

    private function checkKickStatus($channel)
    {
        $data = [
            'live' => false,
            'title' => '',
            'viewers' => 0,
            'thumbnail' => '',
            'game' => '',
            'url' => "https://kick.com/{$channel}"
        ];

        try {
            // Scrape Kick HTML page
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8',
                ])
                ->get("https://kick.com/{$channel}");
            
            if ($response->successful()) {
                $html = $response->body();
                
                // Check if stream is live by looking for common indicators
                if (preg_match('/"livestream":\s*\{/', $html) && !preg_match('/"livestream":\s*null/', $html)) {
                    $data['live'] = true;
                    
                    // Extract title
                    if (preg_match('/"session_title":\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                        $data['title'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                    }
                    
                    // Extract viewers
                    if (preg_match('/"viewer_count":\s*(\d+)/', $html, $m)) {
                        $data['viewers'] = (int)$m[1];
                    }
                    
                    // Extract category/game
                    if (preg_match('/"categories":\s*\[\s*\{\s*"[^"]*":\s*\d+,\s*"name":\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                        $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                    } elseif (preg_match('/"category":\s*\{\s*"[^"]*":\s*\d+,\s*"[^"]*":\s*"[^"]*",\s*"name":\s*"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/', $html, $m)) {
                        $data['game'] = json_decode('"' . $m[1] . '"') ?: $m[1];
                    }
                    
                    if (empty($data['game'])) {
                        $data['game'] = 'Sin categoría';
                    }
                    
                    // Extract thumbnail
                    if (preg_match('/"thumbnail":\s*\{\s*"[^"]*":\s*"[^"]*",\s*"url":\s*"([^"]*)"/', $html, $m)) {
                        $data['thumbnail'] = $m[1];
                    } elseif (preg_match('/<meta\s+property="og:image"\s+content="([^"]*)"/', $html, $m)) {
                        $data['thumbnail'] = $m[1];
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Kick Scrape Error: ' . $e->getMessage());
        }

        return $data;
    }

    public function setStatus(Request $request)
    {
        $platform = $request->input('platform');
        $offline = $request->input('offline', false);

        if (!in_array($platform, ['twitch', 'kick'])) {
            return response()->json(['error' => 'Invalid platform'], 400);
        }

        Cache::put('stream_override', [
            'platform' => $offline ? null : $platform,
            'offline' => $offline,
            'expires_at' => now()->addMinutes(15)
        ], 900);

        return response()->json(['success' => true]);
    }

    public function getOverrideStatus()
    {
        $override = Cache::get('stream_override');

        if (!$override) {
            return ['platform' => null, 'offline' => false];
        }

        if (now()->greaterThan($override['expires_at'])) {
            Cache::forget('stream_override');
            return ['platform' => null, 'offline' => false];
        }

        return $override;
    }

    public function clearOverrideStatus()
    {
        Cache::forget('stream_override');
        return response()->json(['success' => true]);
    }

    public function debugStatus()
    {
        return response()->json([
            'twitch_login' => env('TWITCH_LOGIN'),
            'kick_channel' => env('KICK_CHANNEL'),
        ]);
    }

    public function debugTwitchScrape()
    {
        $login = env('TWITCH_LOGIN');
        $response = Http::get("https://www.twitch.tv/{$login}");
        return response()->json([
            'status' => $response->status(),
            'sample' => substr($response->body(), 0, 500)
        ]);
    }

    public function debugGraphQL()
    {
        $login = env('TWITCH_LOGIN');
        $clientId = env('TWITCH_CLIENT_ID');
        $accessToken = env('TWITCH_ACCESS_TOKEN');
        
        $response = Http::withHeaders([
            'Client-ID' => $clientId,
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("https://api.twitch.tv/helix/streams", [
            'user_login' => $login
        ]);
        
        return response()->json([
            'status' => $response->status(),
            'response' => $response->json()
        ], 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function debugKick()
    {
        $channel = env('KICK_CHANNEL');
        
        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8',
                ])
                ->get("https://kick.com/{$channel}");
            
            return response()->json([
                'status' => $response->status(),
                'channel' => $channel,
                'html_sample' => substr($response->body(), 0, 2000),
                'processed' => $this->checkKickStatus($channel)
            ], 200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'channel' => $channel
            ], 500);
        }
    }
}
