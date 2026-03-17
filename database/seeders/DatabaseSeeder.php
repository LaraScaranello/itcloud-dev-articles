<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Developer;
use App\Models\Skill;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@itcloud.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(3)->create();

        $skills = Skill::factory(10)->create();

        $developers = Developer::factory(15)->create();

        foreach ($developers as $developer) {
            $developer->skills()->attach(
                $skills->random(rand(2, 4))->pluck('id')
            );
        }

        $articles = Article::factory(20)->create();

        foreach ($articles as $article) {
            $article->developers()->attach(
                $developers->random(rand(1, 3))->pluck('id')
            );
        }
    }
}
