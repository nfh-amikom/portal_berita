<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News; // Import the News model
use App\Models\NewsViewLog; // Import the NewsViewLog model
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB; // Import DB facade

class DashboardController extends Controller
{
    public function index()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        $topNewsLast7Days = NewsViewLog::select('news_id', DB::raw('count(*) as views_count'))
                                    ->where('viewed_at', '>=', $sevenDaysAgo)
                                    ->groupBy('news_id')
                                    ->orderBy('views_count', 'desc')
                                    ->with('news') // Eager load the news article
                                    ->take(5)
                                    ->get();

        $chartLabels = $topNewsLast7Days->pluck('news.title')->toArray();
        $chartData = $topNewsLast7Days->pluck('views_count')->toArray();
        
        $dailyViewsLabels = [];
        $dailyViewsData = [];

        // Fetch daily views for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyViewsLabels[] = $date->format('D d M'); // e.g., "Mon 13 Jan"

            $views = NewsViewLog::whereDate('viewed_at', $date->toDateString())
                                ->count();
            $dailyViewsData[] = $views;
        }

       return view('admin.dashboard.index', compact(
            'chartLabels', 
            'chartData', 
            'dailyViewsLabels', 
            'dailyViewsData'
        ));
    }
}
