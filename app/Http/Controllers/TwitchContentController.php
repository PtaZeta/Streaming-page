<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TwitchContentController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '7d'); // 24h, 7d, 30d, all
        $clips = $this->getClips($period);
        $vods = $this->getVods();
        
        return view('contenido', compact('clips', 'vods', 'period'));
    }

    private function getClips($period = '7d')
    {
        $cacheKey = 'twitch_clips_' . $period;
        $cached = Cache::get($cacheKey);
        
        if ($cached && now()->diffInMinutes($cached['timestamp']) < 10) {
            return $cached['data'];
        }

        $twitchClientId = env('TWITCH_CLIENT_ID');
        $twitchAccessToken = env('TWITCH_ACCESS_TOKEN');
        $twitchLogin = env('TWITCH_LOGIN');

        \Log::info('Getting clips for period: ' . $period);
        \Log::info('Using login: ' . $twitchLogin);

        try {
            // Primero obtener el ID del usuario
            $userResponse = Http::timeout(5)
                ->withHeaders([
                    'Client-ID' => $twitchClientId,
                    'Authorization' => 'Bearer ' . $twitchAccessToken,
                ])
                ->get("https://api.twitch.tv/helix/users", [
                    'login' => $twitchLogin
                ]);

            \Log::info('User response status: ' . $userResponse->status());
            \Log::info('User response: ' . json_encode($userResponse->json()));

            if (!$userResponse->successful() || empty($userResponse->json()['data'])) {
                \Log::error('Failed to get user ID or empty response');
                return [];
            }

            $userId = $userResponse->json()['data'][0]['id'];
            \Log::info('Got user ID: ' . $userId);

            // Determinar fecha de inicio según el periodo
            $startedAt = null;
            switch ($period) {
                case '24h':
                    $startedAt = now()->subDay()->toIso8601String();
                    break;
                case '7d':
                    $startedAt = now()->subDays(7)->toIso8601String();
                    break;
                case '30d':
                    $startedAt = now()->subDays(30)->toIso8601String();
                    break;
                case 'all':
                default:
                    $startedAt = null; // Sin filtro de fecha
                    break;
            }

            // Obtener clips con mejores criterios
            $params = [
                'broadcaster_id' => $userId,
                'first' => 12,
            ];
            
            if ($startedAt) {
                $params['started_at'] = $startedAt;
            }

            $response = Http::timeout(5)
                ->withHeaders([
                    'Client-ID' => $twitchClientId,
                    'Authorization' => 'Bearer ' . $twitchAccessToken,
                ])
                ->get("https://api.twitch.tv/helix/clips", $params);

            \Log::info('Clips response status: ' . $response->status());
            \Log::info('Clips response: ' . json_encode($response->json()));

            if ($response->successful()) {
                $clipsData = $response->json()['data'] ?? [];
                
                \Log::info('Got ' . count($clipsData) . ' clips');

                // Validar que cada clip tenga los campos necesarios
                $clips = array_filter($clipsData, function($clip) {
                    return isset($clip['url'], $clip['thumbnail_url'], $clip['title'], 
                                 $clip['view_count'], $clip['creator_name'], $clip['created_at'], $clip['duration']);
                });
                
                \Log::info('After validation: ' . count($clips) . ' clips');

                Cache::put($cacheKey, [
                    'data' => $clips,
                    'timestamp' => now()
                ], now()->addMinutes(10));
                
                return $clips;
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching Twitch clips: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return [];
    }

    private function getVods()
    {
        $cacheKey = 'twitch_vods';
        $cached = Cache::get($cacheKey);
        
        if ($cached && now()->diffInMinutes($cached['timestamp']) < 10) {
            return $cached['data'];
        }

        $twitchClientId = env('TWITCH_CLIENT_ID');
        $twitchAccessToken = env('TWITCH_ACCESS_TOKEN');
        $twitchLogin = env('TWITCH_LOGIN');

        \Log::info('Getting VODs');

        try {
            // Primero obtener el ID del usuario
            $userResponse = Http::timeout(5)
                ->withHeaders([
                    'Client-ID' => $twitchClientId,
                    'Authorization' => 'Bearer ' . $twitchAccessToken,
                ])
                ->get("https://api.twitch.tv/helix/users", [
                    'login' => $twitchLogin
                ]);

            \Log::info('User response status for VODs: ' . $userResponse->status());

            if (!$userResponse->successful() || empty($userResponse->json()['data'])) {
                \Log::error('Failed to get user ID for VODs');
                return [];
            }

            $userId = $userResponse->json()['data'][0]['id'];
            \Log::info('Got user ID for VODs: ' . $userId);

            // Obtener VODs
            $response = Http::timeout(5)
                ->withHeaders([
                    'Client-ID' => $twitchClientId,
                    'Authorization' => 'Bearer ' . $twitchAccessToken,
                ])
                ->get("https://api.twitch.tv/helix/videos", [
                    'user_id' => $userId,
                    'first' => 12,
                    'type' => 'archive'
                ]);

            \Log::info('VODs response status: ' . $response->status());
            \Log::info('VODs response: ' . json_encode($response->json()));

            if ($response->successful()) {
                $vodsData = $response->json()['data'] ?? [];
                
                \Log::info('Got ' . count($vodsData) . ' VODs');

                // Validar que cada VOD tenga los campos necesarios
                $vods = array_filter($vodsData, function($vod) {
                    return isset($vod['url'], $vod['thumbnail_url'], $vod['title'], 
                                 $vod['view_count'], $vod['created_at']) && is_string($vod['created_at']);
                });
                
                \Log::info('After validation: ' . count($vods) . ' VODs');
                
                Cache::put($cacheKey, [
                    'data' => $vods,
                    'timestamp' => now()
                ], now()->addMinutes(10));
                
                return $vods;
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching Twitch VODs: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return [];
    }
}
