<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    public function hosts()
    {
    	return $this->hasMany(Organization::class, 'host_id');
    }

    public function contacts()
    {
    	return $this->hasMany(Organization::class, 'contact_id');
    }
}
