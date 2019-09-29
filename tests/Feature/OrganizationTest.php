<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Subsector;
use App\Organization;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanSeeOrganizations()
    {
        $subsector = Subsector::create(['name' => 'test']);

        $testOrganization = [
            'name' => 'test organization',
            'is_member' => false,
            'subsector_id' => 1
        ];
        $organization = Organization::create($testOrganization);

        $response = $this->get('/api/organizations');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => Organization::all('id', 'name as organization_name')->toArray()
            ]);
    }
}
