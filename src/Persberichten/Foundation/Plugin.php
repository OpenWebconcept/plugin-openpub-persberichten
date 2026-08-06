<?php

namespace OWC\Persberichten\Foundation;

/**
 * BasePlugin which sets all the serviceproviders.
 */
class Plugin
{
	/**
	 * Name of the plugin.
	 *
	 * @var string
	 */
	const NAME = 'persberichten';

	/**
	 * Version of the plugin.
	 * Used for setting versions of enqueue scripts and styles.
	 *
	 * @var string VERSION
	 */
	const VERSION = '2.3.6';

	/**
	 * Path to the root of the plugin.
	 *
	 * @var string
	 */
	protected $rootPath;

	/**
	 * Instance of the configuration repository.
	 *
	 * @var Config
	 */
	public $config;

	/**
	 * Instance of the Hook loader.
	 *
	 * @var Loader
	 */
	public $loader;

	/**
	 * Settings page options.
	 *
	 * @var \OWC\Persberichten\Settings\SettingsPageOptions
	 */
	public $settings;

	/**
	 * Constructor of the BasePlugin
	 *
	 * @param string $rootPath
	 *
	 * @return void
	 */
	public function __construct(string $rootPath)
	{
		$this->rootPath = $rootPath;

		$this->loader = new Loader;

		$this->config = new Config($this->rootPath . '/config');
		$this->config->setProtectedNodes(['core']);
	}

	/**
	 * Load the plugin textdomain.
	 *
	 * Must run before the config files are loaded: those call __() at include
	 * time, which loads translations just-in-time from the path registered here.
	 *
	 * @return void
	 */
	public function loadTextdomain()
	{
		load_plugin_textdomain($this->getName(), false, $this->getName() . '/languages/');
	}

	/**
	 * Boot the plugin.
	 *
	 * @hook after_setup_theme
	 *
	 * @return bool
	 */
	public function boot(): bool
	{
		$this->loadTextdomain();
		$this->config->boot();

		$dependencyChecker = new DependencyChecker($this->config->get('core.dependencies'));

		if ($dependencyChecker->failed()) {
			$dependencyChecker->notify();
			deactivate_plugins(plugin_basename($this->rootPath . '/' . $this->getName() . '.php'));

			return false;
		}

		// Set up service providers
		$this->callServiceProviders('register');

		$this->callServiceProviders('boot');

		// Register the Hook loader.
		$this->loader->addAction('init', $this, 'filterPlugin', 4);
		$this->loader->register();

		return true;
	}

	/**
	 * Allows for hooking into the plugin name.
	 *
	 * @return void
	 */
	public function filterPlugin()
	{
		do_action('owc/' . self::NAME . '/plugin', $this);
	}

	/**
	 * Call method on service providers.
	 *
	 * @param string $method
	 * @param string $key
	 *
	 * @return void
	 *
	 * @throws \Exception
	 */
	public function callServiceProviders($method, $key = '')
	{
		$offset = $key ? "core.providers.{$key}" : 'core.providers';
		$services = $this->config->get($offset);

		foreach ($services as $service) {
			if (is_array($service)) {
				continue;
			}

			$service = new $service($this);

			if (! $service instanceof ServiceProvider) {
				throw new \Exception('Provider must be an instance of ServiceProvider.');
			}

			if (method_exists($service, $method)) {
				$service->$method();
			}
		}
	}

	/**
	 * Get the name of the plugin.
	 *
	 * @return string
	 */
	public function getName()
	{
		return static::NAME;
	}

	/**
	 * Get the version of the plugin.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return static::VERSION;
	}

	/**
	 * Return root path of plugin.
	 *
	 * @return string
	 */
	public function getRootPath(): string
	{
		return $this->rootPath;
	}
}
