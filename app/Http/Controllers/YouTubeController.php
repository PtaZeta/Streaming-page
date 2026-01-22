<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    public function index()
    {
        $channelId = 'UC5moHayN-W3hen-V0iluAUQ';
        $rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id={$channelId}";

        try {
            $xml = simplexml_load_file($rssUrl, 'SimpleXMLElement', LIBXML_NOCDATA);
            if (!$xml) {
                throw new \Exception("No se pudo cargar el RSS");
            }

            $data = json_decode(json_encode($xml), true);
            $entries = $data['entry'] ?? [];

            // Tomar solo los últimos 7 vídeos
            $videos = array_slice($entries, 0, 3);
        } catch (\Exception $e) {
            $videos = [];
            // Para depurar si falla
            dd("Error cargando RSS de YouTube: ".$e->getMessage());
        }

        return view('welcome', compact('videos'));
    }
}
