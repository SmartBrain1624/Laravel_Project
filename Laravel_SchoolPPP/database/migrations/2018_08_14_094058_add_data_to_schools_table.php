<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::table('schools')->insert(
			array(
				'name' => 'Ballincollig'
			)
		);
		DB::table('schools')->insert(
			array(
				'name' => 'Dunmanway'
			)
		);
		DB::table('schools')->insert(
			array(
				'name' => 'Shannon'
			)
		);
		DB::table('schools')->insert(
			array(
				'name' => 'Largy'
			)
		);
		DB::table('schools')->insert(
			array(
				'name' => 'Tubbercurry'
			)
		);
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
