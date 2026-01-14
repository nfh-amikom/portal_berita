<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Admin Author',
            'email' => 'author@author.com',
            'password' => bcrypt('password'),
            'role' => 'admin', // Assign admin role
        ]);

        // Create some dummy users with 'user' role
        User::create([
            'name' => 'Regular User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Regular User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $categories = ['Technology', 'Sports', 'Politics', 'Entertainment', 'Science'];
        $categoryModels = [];
        foreach ($categories as $category) {
            $categoryModels[] = Category::create(['name' => $category]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $title = 'Judul Berita ' . $i;
            $content = 'Ini adalah isi dari berita ke ' . $i . '. Berita ini dibuat oleh seeder. ' . Str::random(500);

            // Create a dummy image
            $imageName = 'news_image_' . $i . '.jpg';
            Storage::disk('public')->put($imageName, file_get_contents('https://picsum.photos/800/600?' . $i));

            News::create([
                'title' => $title,
                'content' => $content,
                'user_id' => $adminUser->id, // Assign news to the admin user
                'category_id' => $categoryModels[array_rand($categoryModels)]->id,
                'image' => $imageName,
                'slug' => Str::slug($title),
                'views' => random_int(0, 100), // Initialize views to random values
            ]);
        }
    }
}
