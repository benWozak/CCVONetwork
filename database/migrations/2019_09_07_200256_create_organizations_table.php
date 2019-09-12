<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');

            foreach(config('app.ccvo_members_csv.columns') as $column) {
                $type = $column['type'];
                $table->$type($column['name']);
            }

            $table->boolean('is_member')->default(FALSE);
            $table->timestamps();

            $table->foreign('subsector_id')->references('id')->on('subsectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
