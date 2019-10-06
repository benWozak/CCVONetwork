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


    public function egoNetwork($id) {
        //$contactIDs = $organization->contacts->pluck('contact_id')->toArray();
        $contactIDs = Connection::where('host_id',$id)->get()->pluck('contact_id')->toArray();
        array_push($contactIDs,$id);
        $connections = Connection::wherein('host_id',$contactIDs)->get();

        $pairedIDs = $connections->pluck('host_id','contact_id')->toArray();
        $allContactIDs = array_unique(array_merge(array_values($pairedIDs),array_keys($pairedIDs)));
        $organizations = Organization::wherein('id',$allContactIDs)->get();
        
        return [
            'data' => ['connections' => $connections, 'organizations' => $organizations]
            
        ];
    }

    public function store(StoreConnection $request)
    {

    	$unknown = Subsector::where('name', config('app.unknown_subsector.name'))->first();

    	$host = Organization::firstOrCreate(
    		['name' => $request->organization_name],
    		['is_member' => $request->is_member, 'subsector_id' => $unknown->id]
    	);

    	foreach($request->connections as $contact) {

    		$organization = Organization::firstOrCreate(
	    		['name' => $contact['organization_name']],
	    		[
	    			'is_member' => false,
	    			'subsector_id' => $unknown->id
	    		]
	    	);


    		$host->contacts()->attach(
    			$organization->id, ['connection_type' => $contact['connection_type']]
    		);

    	}

        return [
            'data' => $host->load('contacts')
        ];

    }
}
