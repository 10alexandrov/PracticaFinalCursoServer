<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LugareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = ['A', 'B', 'C', 'D'];  // Названия таблиц
        $rows = 3;  // Количество строк в каждой таблице
        $cols = 10; // Количество колонок в каждой таблице
        $counter = 1;  // Счетчик для ID ячейки

        foreach ($tables as $table) {
            for ($row = 1; $row <= $rows; $row++) {
                for ($col = 1; $col <= $cols; $col++) {
                    // Вставляем данные для каждой ячейки
                    DB::table('lugares')->insert([
                        'lugar_estanteria' => $table,
                        'lugar_planta' => $row,
                        'lugar_column' => $col,
                        'lugar_producto' => 0,
                        'lugar_llenado' => 0,
                    ]);
                    $counter++;  // Увеличиваем счетчик для следующей ячейки
                }
            }
        }
    }

}
