<?php

use Illuminate\Database\Seeder;

class GalleryTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('params')->insert([
            [
                'news_type' => 'dailyinfo',
                'tag_type' => 'category',
                'show_on_gallery' => 0,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'news_type' => 'lifetips',
                'tag_type' => 'category',
                'show_on_gallery' => 0,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
