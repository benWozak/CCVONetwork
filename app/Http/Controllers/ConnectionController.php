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

    public function mynetwork($id) {
        $returnArray = array();
        $myContacts = Connection::where('host_id',$id)->get();
        $returnArray['data'] = $myContacts;
        
        foreach ($myContacts->toArray() as $contactData) {
            $hostID = $contactData['contact_id'];
            $hostContacts = Connection::where('host_id',$hostID)->get();
            $mergedCollection = $returnArray['data']->toBase()->merge($hostContacts);
            $returnArray['data'] = $mergedCollection;
        }
        
        return $returnArray;
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

    }
}
