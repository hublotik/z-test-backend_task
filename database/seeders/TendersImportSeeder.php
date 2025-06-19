<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TendersImportSeeder extends Seeder
{
    public function run()
    {
        // статусы в дикт + добавление тендеров

        $file = database_path('/import/csv/test_task_data.csv');

        $statuses = ['Открыто', 'Закрыто', 'Отменено'];
        foreach ($statuses as $statusName) {
            DB::table('status_dict')->updateOrInsert(
                ['status_name' => $statusName],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        if (file_exists($file)) {
            $rows = array_map('str_getcsv', file($file));
            $headers = array_shift($rows);

            foreach ($rows as $row) {
                $data = array_combine($headers, $row);
                $statusName = $data['Статус'];

                $statusId = DB::table('status_dict')
                    ->where('status_name', $statusName)
                    ->value('id');
                    
                if(empty($statusId)){continue;}

                DB::table('tenders')->insert([
                    'remote_id' => $data['Внешний код'],
                    'number' => $data['Номер'],
                    'status_id' => $statusId,
                    'name' => $data['Название'],
                    'updated_at' => Carbon::parse($data['Дата изм.']),
                    'created_at' => now(),
                ]);
            }
        }
    }
}