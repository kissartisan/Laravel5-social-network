<?php

namespace App;

// Add a Authenticatable contract to automatically validate the user
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable // Add a contract Authenticatable
{
		// If you change the table name in the migration, you should declare this line:
    // protected $table = 'users2';
		use \Illuminate\Auth\Authenticatable; // Add a trait Authenticatable

		public function posts()
		{
			return $this->hasMany('App\Post');
		}

		public function likes()
    {
    	return $this->hasMany('App\Like');
    }

}
