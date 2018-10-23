<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('schools', function (Blueprint $table){
			$table->decimal('benchmark_elect', 10, 2)->after('name');
			$table->decimal('benchmark_heating', 10, 2)->after('name');
			$table->decimal('benchmark_water', 10, 2)->after('name');
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
