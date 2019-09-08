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

    	$organizations = $organizations->paginate();

		return (new Organizations($organizations));	 
    }
}
