<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@email.net',
                'password' => bcrypt('password'),
                'role_id' => 1
            ],
            [
                'name' => 'Иван',
                'email' => 'student@email.net',
                'password' => bcrypt('password'),
                'role_id' => 2
            ],
            [
                'name' => 'Любовь',
                'email' => 'teacher@email.net',
                'password' => bcrypt('password'),
                'role_id' => 3
            ]
        ]);
    }
}
