<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'label' => 'Администратор',
            ],
            [
                'id' => 2,
                'name' => 'student',
                'label' => 'Ученик',
            ],
            [
                'id' => 3,
                'name' => 'teacher',
                'label' => 'Преподаватель',
            ]
        ]);
    }
}
