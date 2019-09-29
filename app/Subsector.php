<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsector extends Model
{
	protected $guarded = [];

	public $timestamps = false;

    public function organizations()
    {
    	return $this->hasMany(Organization::class);
    }
}
