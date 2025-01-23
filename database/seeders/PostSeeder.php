<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $judul = [

            'Pentingnya Nonton Timnas Indonesia',
            'Pentingnya Menjaga Pola Makan',
            'Cara melakukan dribbling bola dengan baik',
            'Pengertian scaling horizontal dan vertical',
            'Tujuan melakukan unit test pada saat testing'
        ];



        foreach ($judul as $j) {
            $slug = Str::slug($j);
            $slugOri = $slug;
            $counter = 1;
            while (Post::where('slug', $slug)->exists()) {
                $counter++;
                $slug = $slugOri . '-' . $counter;
            }


            Post::create([
                'title' => $j,
                'slug' => $slug,
                'description' => 'Desciption for ' . $j,
                'content' => 'Content for ' . $j,
                'status' => 'publish',
                'user_id' => 1
            ]);
        }
    }
}
