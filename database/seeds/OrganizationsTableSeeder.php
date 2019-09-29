<?php

use Illuminate\Database\Seeder;

use App\Subsector;

class OrganizationsTableSeeder extends Seeder
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

        $organizations = [];

        while (($data = fgetcsv($csv, 1000, ",")) !== FALSE) {
            $numberOfColumns = count($data);

            // skip reading first row
            if($row == 0) {
                $row++;
                continue;
            }

            for ($column = 0; $column < $numberOfColumns; $column++) {
                $dbColumn = config("app.ccvo_members_csv.columns.$column.name");

                if($dbColumn == 'subsector_id') {
                    $subsector = Subsector::where('name', $data[$column])->first();

                    if(!isset($subsector->id))
                        $subsector = Subsector::where('name', config('app.unknown_subsector.name'))->first();

                    $organizations[$row][$dbColumn] = $subsector->id;

                    continue;
                }

                $organizations[$row][$dbColumn] = $data[$column];
            }

            $row++;
        }

        fclose($csv);

        DB::table('organizations')->insert($organizations);
    }
}
