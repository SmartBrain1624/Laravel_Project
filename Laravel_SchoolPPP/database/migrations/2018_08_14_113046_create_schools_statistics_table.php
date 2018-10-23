<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('schools_statistics', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('school_id')->index();
			$table->integer('year');
			$table->integer('week');
			$table->integer('month');
			$table->decimal('elect_eur', 10, 2);
			$table->decimal('elect_kwh', 10, 2);
			$table->decimal('heating_eur', 10, 2);
			$table->decimal('heating_kwh', 10, 2);
			$table->decimal('water_eur', 10, 2);
			$table->decimal('water_litres', 10, 2);
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
