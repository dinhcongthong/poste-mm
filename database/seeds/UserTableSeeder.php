<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return DB::table('users')->insert([
            [
                'first_name' => 'Nguyen Van',
                'last_name' => 'Nhan',
                'kata_first_name' => 'Nguyen Van',
                'kata_last_name' => 'Nhan',
                'email' => 'nvnhan@poste-vn.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('1995Nguyenvannhan@0810'),
                'type_id' => 1,
                'gender_id' => 1,
                'birthday' => '1995-10-08',
                'occupation_id' => 1,
                'phone' => '079-983-3537',
                'secret_question_id' => 1,
                'answer' => bcrypt('answer'),
                'is_news_letter' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'first_name' => 'Yuka',
                'last_name' => 'Mori',
                'kata_first_name' => 'Yuka',
                'kata_last_name' => 'Mori',
                'email' => 'yuka@poste-vn.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('ruru0811'),
                'type_id' => 1,
                'gender_id' => 1,
                'birthday' => '1995-10-08',
                'occupation_id' => 1,
                'phone' => '079-983-3537',
                'secret_question_id' => 1,
                'answer' => bcrypt('answer'),
                'is_news_letter' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null
            ]
        ]);
    }
}
