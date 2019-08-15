<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'hzy',
            'email'=>'1221@163.com',
            'password'=>bcrypt('111qqq'),
        ]);
    }
}
