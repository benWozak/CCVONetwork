<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Connection;
use App\Organization;
use App\Subsector;

use App\Http\Requests\StoreConnection;

class ConnectionController extends Controller
{
    public function index()
    {
    	return [
    		'data' => Connection::all()
    	];
    }

    public function store(StoreConnection $request)
    {
    	$other = Subsector::where('name', 'Other')->first();

    	$host = Organization::firstOrCreate(
    		['name' => $request->organization_name],
    		['is_member' => $request->is_member, 'subsector_id' => $other->id]
    	);

    	$contactIds = [];

    	foreach($request->connections as $contact) {

    		$organization = Organization::firstOrCreate(
	    		['name' => $contact['organization_name']],
	    		[
	    			'is_member' => false, 
	    			'subsector_id' => $other->id
	    		],
	    	);

	    	$contactIds[$organization->id] = [ 'connection_type' => $contact['connection_type'] ];
    	}

    	$host->contacts()->syncWithoutDetaching($contactIds);
    }
}
