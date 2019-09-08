<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];
    
	protected $searchColumns = ['name'];

    public function subsector()
    {
    	return $this->belongsTo(Subsector::class);
    }

    public function contacts()
    {
    	return $this->belongsToMany(Organization::class, 'connections', 'host_id', 'contact_id')
            ->withPivot('connection_type')
            ->withTimestamps();
    }

    public function hosts()
    {
    	return $this->belongsToMany(Organization::class, 'connections', 'contact_id', 'host_id')
            ->withPivot('connection_type')
            ->withTimestamps();
    }

    public function scopeSearch($query, $term)
    {
        if(empty($term))
            return $query;
        foreach($this->searchColumns as $key=>$column) {
        	if($key == 0)
        		$query->where($column, 'LIKE', '%' . $term . '%');
        	$query->orWhere($column, 'LIKE', '%' . $term . '%');
        }
        return $query;
    }
}
