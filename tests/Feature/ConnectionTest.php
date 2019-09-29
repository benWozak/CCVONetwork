<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Subsector;
use App\Organization;

class ConnectionTest extends TestCase
{
    //use RefreshDatabase;

    public function testCanSeeConnections()
    {
        $subsector = Subsector::create(['name' => 'test']);

        $ccvoAttributes = [
            'name' => 'ccvo',
            'is_member' => false,
            'subsector_id' => 1
        ];

        $ccecaAttributes = [
            'name' => 'cceca',
            'is_member' => false,
            'subsector_id' => 1
        ];

        $ccvo = Organization::create($ccvoAttributes);
        $cceca = Organization::create($ccecaAttributes);

        $ccvo->contacts()->attach($cceca, ['connection_type' => 'awareness']);
        $cceca->contacts()->attach($ccvo, ['connection_type' => 'knowledge sharing']);

        $response = $this->get('/api/connections');

        $response
            ->assertStatus(200);
    }

    public function testCanCreateConnections()
    {
        $this->withoutExceptionHandling();

        $subsector = Subsector::create(['name' => 'other']);

        $attributes = [
            'organization_name' => 'test organization',
            'is_member' => true,
            'connections' => [
                [
                    'organization_name' => 'test contact organization',
                    'connection_type' => 'awareness'
                ],
                [
                    'organization_name' => 'test contact organization 2',
                    'connection_type' => 'knowledge sharing'
                ]
            ]
        ];

        $response = $this->post('/api/connections', $attributes);

        $response->assertStatus(200);
    }
}
