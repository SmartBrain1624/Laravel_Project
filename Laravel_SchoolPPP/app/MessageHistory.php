<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MessageHistory extends Model
{
    use Notifiable;

	protected $table = 'message_history';

	public $rules = array(
		'email' => 'required',
		'year' => 'int',
		'month' => 'int'
	);

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'year', 'month', 'schools'
	];
}
