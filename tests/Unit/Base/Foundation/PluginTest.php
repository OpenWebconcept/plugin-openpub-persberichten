<?php

namespace OWC\Persberichten\Tests\Base\Foundation;

use OWC\Persberichten\Foundation\Plugin;
use OWC\Persberichten\Tests\TestCase;
use WP_Mock;

class PluginTest extends TestCase
{
    /** @var string */
    protected $rootPath;

    protected function setUp(): void
    {
        WP_Mock::setUp();
        $this->rootPath = __DIR__ . '/../../../Stubs/plugin';
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /**
     * Config files call __() at include time, so they must not be loaded during
     * construction on `plugins_loaded`: WordPress 6.7+ flags translation calls
     * made before `after_setup_theme` with a "_load_textdomain_just_in_time was
     * called incorrectly" notice.
     *
     * @test
     */
    public function construction_does_not_load_config_files()
    {
        $plugin = new Plugin($this->rootPath);

        $this->assertEquals([], $plugin->config->all());
    }

    /** @test */
    public function boot_loads_textdomain_before_config_files()
    {
        $plugin = new Plugin($this->rootPath);

        $configWhenTextdomainLoaded = null;
        WP_Mock::userFunction('load_plugin_textdomain', [
            'times'  => 1,
            'return' => function () use ($plugin, &$configWhenTextdomainLoaded) {
                $configWhenTextdomainLoaded = $plugin->config->all();

                return true;
            },
        ]);

        $this->assertTrue($plugin->boot());
        $this->assertEquals([], $configWhenTextdomainLoaded);
        $this->assertEquals([], $plugin->config->get('core.dependencies'));
    }
}
