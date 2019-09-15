<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Organization;
use App\Subsector;
use App\Http\Resources\Organizations;
use App\Http\Requests\StoreOrganization;

class OrganizationController extends Controller
{
    public function index()
    {
    	$organizations = new Organization;

    	$search = request('search');
    	$organizations = $organizations->search($search);
    	$organizations = $organizations->orderBy('name', 'asc');

        if(request('has_connections') === 'true') {
            $organizations = $organizations->has('contacts')->orHas('hosts');
            return (new Organizations($organizations->get()));
        }

		return (new Organizations($organizations->paginate()));
    }

    public function store(StoreOrganization $request)
    {
    	$organization = new Organization;
	$organization->name = $request->organization_name;
	$organization->is_member = $request->is_member;
	$organization->subsector_id = 
		Subsector::where(
			'name', config('app.unknown_subsector.name')
		)->first()->id;
	$organization->save();

	return $organization;
    }
}
