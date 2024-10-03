<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        $this->call([
            TagSeeder::class,
            UsersSeeder::class,
            ContentSeeder::class,
            SettingsSeeder::class,
            PagesSeeder::class,
            MenusSeeder::class,
            PermissionsSeeder::class,
            AttachSuperAdminPermissions::class,
            // ArticleSeeder::class,
        ]);
    }
}

