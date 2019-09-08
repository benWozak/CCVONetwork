<?php

use Illuminate\Database\Seeder;

class SubsectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Other subsector
        DB::table('subsectors')->insert([
            ['name' => 'Other'],
        ]);
    }
}
