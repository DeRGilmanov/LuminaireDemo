<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YourModel; // Убедитесь, что модель подключена
use willvincent\Feeds\Facades\Feeds; // Убедитесь, что пакет Feeds установлен и подключен
use Illuminate\Support\Facades\Response; // Импортируем класс Response

class RssController extends Controller
{
    public function feed()
    {
        $data = \App\Models\Order::all(); // Получите нужные данные для ленты/////////////////////////////////////////////////////////////////////////////НЕ РАБОТАЕТ У МЕНЯ ЭТО

        $rss = '<?xml version="1.0" encoding="UTF-8" ?>';
        $rss .= '<rss version="2.0">';
        $rss .= '<channel>';
        $rss .= '<title>Your RSS Feed Title</title>';
        $rss .= '<link>' . url('/rss') . '</link>';
        $rss .= '<description>Description of your RSS Feed</description>';

        foreach ($data as $item) {
            $rss .= '<item>';
            $rss .= '<title>' . e($item->title) . '</title>';
            $rss .= '<link>' . route('item.show', $item->id) . '</link>';
            $rss .= '<description>' . e($item->description) . '</description>';
            $rss .= '<pubDate>' . $item->created_at->toRssString() . '</pubDate>';
            $rss .= '</item>';
        }

        $rss .= '</channel>';
        $rss .= '</rss>';

        return Response::make($rss, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
