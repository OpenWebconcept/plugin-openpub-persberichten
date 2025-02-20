<?php

namespace OWC\Persberichten\Settings;

use OWC\Persberichten\Traits\CheckPluginActive;

class SettingsPageOptions
{

	use CheckPluginActive;

    /**
     * Settings defined on settings page
     *
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * URL to the portal website.
     *
     * @return string
     */
    public function getPortalURL(): string
    {
        return $this->settings['_owc_setting_portal_url'] ?? '';
    }

    public function getPortalItemSlug(): string
    {
        return $this->settings['_owc_setting_portal_press_release_item_slug'] ?? '';
    }

    /**
     * URL to the portal website.
     *
     * @return string
     */
    public function getAdditionalMessage(): string
    {
        return $this->settings['_owc_setting_additional_message'] ?? '';
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                           => '',
            '_owc_setting_portal_press_release_item_slug'       => '',
            '_owc_setting_additional_message'                   => '',
        ];

        $options = get_option('_owc_press_settings', []);

        if (static::isPluginOpenPubBaseActive()) {
            // include openpub-base settings.
            $options = array_merge($options, get_option('_owc_openpub_base_settings', []));
        };

        return new static(wp_parse_args($options, $defaultSettings));
    }
}
