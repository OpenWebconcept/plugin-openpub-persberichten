<?php

namespace OWC\OpenPub\Persberichten\Tests\Persberichten\PostType;

use Mockery as m;
use OWC\OpenPub\Persberichten\Foundation\Config;
use OWC\OpenPub\Persberichten\Foundation\Loader;
use OWC\OpenPub\Persberichten\Foundation\Plugin;
use OWC\OpenPub\Persberichten\PostType\PostTypeServiceProvider;
use OWC\OpenPub\Persberichten\Tests\TestCase;
use WP_Mock;

class PostTypeServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_openpub_item_slug'         => '',
                '_owc_setting_use_portal_url'                   => 0,
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_openpub_item_slug'         => '',
                '_owc_setting_use_portal_url'                   => 0,
            ]
        ]);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_posttypes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new PostTypeServiceProvider($plugin);

        $this->post     = m::mock(WP_Post::class);
        $this->post->ID = 1;

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'registerPostTypes',
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'pre_get_posts',
            $service,
            'orderByPublishedDate',
        ])->once();

        // WP_Mock::passthruFunction('handleSave', [
        //     'times'  => '0+',
        //     'return' => null
        // ]);

        /**
         * Examples of registering post types: http://johnbillion.com/extended-cpts/
         */
        $configPostTypes = [
            'posttype' => [
                'args'  => [],
                'names' => [],
            ],
        ];

        $service->register();

        $this->assertTrue(true);
    }
}
