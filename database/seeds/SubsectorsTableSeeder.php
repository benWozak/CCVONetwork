<?php

use Illuminate\Database\Seeder;

use App\Subsector;

class SubsectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvPath = base_path() . '/' . config('app.ccvo_members_csv.file_name');

        $csv = fopen($csvPath , 'r');

        $row = 0;

        $subsectorsColumnIndex = array_search(
            'subsector_id',
            array_column(
                config("app.ccvo_members_csv.columns"),
                'name'
            )
        );

        while (($data = fgetcsv($csv, 1000, ",")) !== FALSE) {

            if($row == 0) {
                $row++;
                continue;
            }

            if($data[$subsectorsColumnIndex] == '')
                continue;

            Subsector::firstOrCreate(
                ['name' => $data[$subsectorsColumnIndex]]
            );
        }

        fclose($csv);

        DB::table('subsectors')->insert(['name' => config('app.unknown_subsector.name')]);
    }
}



