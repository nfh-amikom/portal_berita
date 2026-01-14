<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsViewLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsViewLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsArticles = News::all();

        if ($newsArticles->isEmpty()) {
            echo "No news articles found. Please seed news first.\n";
            return;
        }

        // Generate between 500 and 1000 random view logs
        $numberOfViews = rand(500, 1000);

        for ($i = 0; $i < $numberOfViews; $i++) {
            $randomNews = $newsArticles->random();
            $randomDaysAgo = rand(0, 6); // Views within the last 7 days (0 to 6 days ago)
            $randomHours = rand(0, 23);
            $randomMinutes = rand(0, 59);
            $randomSeconds = rand(0, 59);

            $viewedAt = Carbon::now()
                            ->subDays($randomDaysAgo)
                            ->setTime($randomHours, $randomMinutes, $randomSeconds);

            NewsViewLog::create([
                'news_id' => $randomNews->id,
                'viewed_at' => $viewedAt,
            ]);

            // Also increment the news article's total views for the top 5 chart
            $randomNews->increment('views');
        }
    }
}
