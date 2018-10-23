<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SchoolStatistics extends Model
{
    use Notifiable;

	protected $table = 'schools_statistics';
	
	public $rules = array(

		'school' => 'required',
		'year' => 'int',
		'month' => 'int',
		'week' => 'int',
		'electricity_euro' => 'required|numeric',
		'electricity_kwh' => 'required|numeric',
		'heating_euro' => 'required|numeric',
		'heating_kwh' => 'required|numeric',
		'water_euro' => 'required|numeric',
		'water_litres' => 'required|numeric',
	);

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id', 'year', 'week', 'month', 'elect_eur', 'elect_kwh', 'heating_eur', 'heating_kwh', 'water_eur', 'water_litres'
	];
}
