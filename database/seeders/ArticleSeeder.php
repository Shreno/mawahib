<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article; // Assuming the Article model exists
use App\Models\User; // Assuming the User model exists
use App\Models\Tag; // Assuming the Tag model exists
use App\Models\Category; // Assuming the Category model exists
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have users, categories, and tags already seeded
        $users = User::all(); // Fetch all users
        $creators = User::all(); // Fetch all creators (or adjust if creators are a subset of users)
        $categories = Category::pluck('id'); // Fetch all category IDs
        $tags = Tag::pluck('id'); // Fetch all tag IDs

        // Example: Seed 10 articles
        for ($i = 1; $i <= 10; $i++) {
            // Randomly pick a user and a creator
            $user = $users->random();
            $creator = $creators->random();

            // Create an article using Eloquent
            $article = Article::create([
                'user_id' => $user->id,
                'creator_id' => $creator->id,
                'main_image' => 'images/article_1.jfif', // Dummy image path
                'is_featured' => rand(0, 1),
                'slug' => Str::slug('Article Title ' . $i),
                'title' => 'عنوان المقالة ' . $i,
                'description' => 'This is the description of article ' . $i,
                'meta_description' => 'This is the meta description for article ' . $i,
                'views' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach random categories and tags
            $article->categories()->attach($categories->random(rand(1, 3))); // Attach 1-3 random categories
            $article->tags()->attach($tags->random(rand(1, 5))); // Attach 1-5 random tags
        }
    }
}
