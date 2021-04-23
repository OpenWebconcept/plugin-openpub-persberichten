<?php

namespace OWC\Persberichten\Settings;

use OWC\Persberichten\Traits\CheckPluginActive;

class SettingsPageOptions
{
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

    public function getOrganisationName(): string
    {
        return $this->settings['_owc_setting_press_release_organisation_account'] ?? '';
    }

    public function getOrganisationEmail(): string
    {
        return $this->settings['_owc_setting_press_release_account_email'] ?? '';
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
            '_owc_setting_portal_url'                     => '',
            '_owc_setting_portal_press_release_item_slug' => '',
            '_owc_setting_additional_message'             => '',
        ];

        $options = get_option('_owc_openpub_press_settings', []);

        if (CheckPluginActive::isPluginOpenPubBaseActive()) {
            // include openpub-base settings.
            $options = array_merge($options, get_option('_owc_openpub_base_settings', []));
        };

        return new static(wp_parse_args($options, $defaultSettings));
    }
}
