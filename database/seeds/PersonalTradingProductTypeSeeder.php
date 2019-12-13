<?php

use Illuminate\Database\Seeder;

class PersonalTradingProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'CD・DVD',
                'slug' => str_slug('CD・DVD', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PC関係',
                'slug' => str_slug('PC関係', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'スポーツ用品',
                'slug' => str_slug('スポーツ用品', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'その他',
                'slug' => str_slug('その他', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'ベビー用品',
                'slug' => str_slug('ベビー用品', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '家具',
                'slug' => str_slug('家具', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '本・雑誌',
                'slug' => str_slug('本・雑誌', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '楽器',
                'slug' => str_slug('楽器', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '生活用品',
                'slug' => str_slug('生活用品', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '電化製品',
                'slug' => str_slug('電化製品', '-'),
                'tag' => 15,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
