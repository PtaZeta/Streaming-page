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

            if (!$userResponse->successful() || empty($userResponse->json()['data'])) {
                return [];
            }

            $userId = $userResponse->json()['data'][0]['id'];

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

            if ($response->successful()) {
                $clips = $response->json()['data'] ?? [];
                
                Cache::put($cacheKey, [
                    'data' => $clips,
                    'timestamp' => now()
                ], now()->addMinutes(10));
                
                return $clips;
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching Twitch clips: ' . $e->getMessage());
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

            if (!$userResponse->successful() || empty($userResponse->json()['data'])) {
                return [];
            }

            $userId = $userResponse->json()['data'][0]['id'];

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

            if ($response->successful()) {
                $vods = $response->json()['data'] ?? [];
                
                Cache::put($cacheKey, [
                    'data' => $vods,
                    'timestamp' => now()
                ], now()->addMinutes(10));
                
                return $vods;
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching Twitch VODs: ' . $e->getMessage());
        }

        return [];
    }
}
