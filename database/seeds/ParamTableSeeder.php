<?php

use Illuminate\Database\Seeder;

class ParamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return DB::table('params')->insert([
            [
                'news_type' => 'user',
                'tag_type' => 'gender',
                'show_on_gallery' => 0,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'news_type' => 'user',
                'tag_type' => 'occupation',
                'show_on_gallery' => 0,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'news_type' => 'user',
                'tag_type' => 'residence',
                'show_on_gallery' => 0,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'news_type' => 'user',
                'tag_type' => 'secret_question',
                'show_on_gallery' => 0,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
