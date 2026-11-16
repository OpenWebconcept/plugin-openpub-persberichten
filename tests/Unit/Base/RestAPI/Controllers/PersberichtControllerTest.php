<?php

namespace OWC\Persberichten\Tests\Base\RestAPI\Controllers;

use Mockery;
use OWC\Persberichten\Foundation\Plugin;
use OWC\Persberichten\Repositories\Persbericht;
use OWC\Persberichten\RestAPI\Controllers\PersberichtenController;
use OWC\Persberichten\Tests\TestCase;
use WP_Mock;

class PersberichtControllerTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function add_tax_query_to_wp_query()
    {
        $expected = [
            'tax_query' => [
                [
                    'taxonomy' => 'press_mailing_list',
                    'terms'    => 'test',
                    'field'    => 'slug'
                ]
            ]
        ];

        $actual = Persbericht::addFilterTypeParameters('test');

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function add_tax_query_to_wp_query_returns_empty_array()
    {
        $expected = [
            'tax_query' => [
                [
                    'taxonomy' => 'press_mailing_list',
                    'terms'    => 'test',
                    'field'    => 'slug'
                ]
            ]
        ];

        $actual = Persbericht::addFilterTypeParameters();

        $this->assertNotEquals($expected, $actual);
    }

    /** @test */
    public function collections_only_query_published_press_releases()
    {
        $request = Mockery::mock('WP_REST_Request');
        $request->shouldReceive('get_param')->with('type')->andReturn('test');
        $request->shouldReceive('get_param')->andReturn(null);

        $controller = new PersberichtenController(Mockery::mock(Plugin::class));

        foreach (['getItems', 'getTypeFilteredItems'] as $method) {
            $response = $controller->$method($request);

            $this->assertEquals(['publish'], $response['pagination']['query_parameters']['post_status'], $method);
        }
    }
}
