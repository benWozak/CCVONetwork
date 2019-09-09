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
		 ['name' => 'Arts and Culture'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Business'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Business, Professional Associations, and Unions'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Development'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Education and Research'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Environment and Animal Welfare'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Faith and Religion'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Fundraising and Volunteerism'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Government'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Health'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Housing'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Individual'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'International'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Law, Advocacy, and Politics'], 
	]);


        DB::table('subsectors')->insert([
            ['name' => 'Other'],
        ]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Social Services'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Sports and Recreation'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['name' => 'Student'], 
	]);


	DB::table('subsectors')->insert([ 
		 ['id' => 99, 'name' => 'Unknown'], 
	 ]);
    }
}



