<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('student')->insert([
            'num' => 814814814,
            'passwd' =>  substr_replace(md5('123456'),'a8c1m4',5,0),
            'name' => '管理员',
            'create_time' => '1970-01-01',
            'class' => '牡丹江师范学院',
            'role' => 3
        ]);
    }
}
