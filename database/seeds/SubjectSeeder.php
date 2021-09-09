<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subjects')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('subjects')->insert([
            ['name' => 'Русский язык'],
            ['name' => 'Английский язык'],
            ['name' => 'Немецкий язык'],
            ['name' => 'Французский язык'],
            ['name' => 'Итальянский язык'],
            ['name' => 'Испанский язык'],
            ['name' => 'Китайский язык'],
            ['name' => 'Японский язык'],
            ['name' => 'Русский язык как иностранный'],
            ['name' => 'Математика'],
            ['name' => 'Физика'],
            ['name' => 'Информатика/программирование'],
            ['name' => 'Химия'],
            ['name' => 'Биология'],
            ['name' => 'История'],
            ['name' => 'Обществознание'],
            ['name' => 'Литература'],
            ['name' => 'География'],
            ['name' => 'Экономика'],
            ['name' => 'Занятия с дошкольниками'],
            ['name' => 'Начальные классы'],
            ['name' => 'Логопед'],
            ['name' => 'ИЗО'],
            ['name' => 'Музыка'],
            ['name' => 'Другой'],
            ['name' => 'Редкие иностранные языки'],
            ['name' => 'Спорт'],
        ]);
    }
}
