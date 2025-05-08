<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = [
            ['name'=>'Январь'],
            ['name'=>'Февраль'],
            ['name'=>'Март'],
            ['name'=>'Апрель'],
            ['name'=>'Май'],
            ['name'=>'Июнь'],
            ['name'=>'Июль'],
            ['name'=>'Август'],
            ['name'=>'Сентябрь'],
            ['name'=>'Октябрь'],
            ['name'=>'Ноябрь'],
            ['name'=>'Декабрь']
        ];
        DB::table('month_names')->insert($months);
    }
}
