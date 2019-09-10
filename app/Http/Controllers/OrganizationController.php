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

        if(request('has_connections') === 'true')
            $organizations = $organizations->has('contacts')->orHas('hosts');

    	$organizations = $organizations->paginate();

		return (new Organizations($organizations));
    }
}
