<?php

namespace plugin\calendar\consultations\admin;

use plugin\calendar\consultations\asset\admin\MainAdminSettingsAsset;
use plugin\calendar\consultations\models\OrganizeConsultation;
use plugin\calendar\consultations\models\SettingsPlugin;

class SectionSettingsPlugin {

    public $name;

    public $group;

    public function __construct() {
        $this->name = OrganizeConsultation::$name;
        $this->group = $this->name.'-settings-group';
        add_action('admin_menu', [$this, 'createMenu']);
    }

    public function createMenu() {
        $this->addAsset();

        add_submenu_page(
            'edit.php?post_type='.$this->name,
            'Settings Calendar of consultations',
            'Settings',
            'manage_options',
            $this->name.'-settings-plugin',
            [$this, 'actionPageSettings']
        );

        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function registerSettings() {
        $settings = new SettingsPlugin();

        add_settings_section( $this->name.'_section_id', false, false , $this->group.'_tab_1_block_1' );
        add_settings_field('hoursMonday', $settings->getLabelAttr('hoursMonday'), [$settings, 'inputHoursMonday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursTuesday', $settings->getLabelAttr('hoursTuesday'), [$settings, 'inputHoursTuesday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursWednesday', $settings->getLabelAttr('hoursWednesday'), [$settings, 'inputHoursWednesday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursThursday', $settings->getLabelAttr('hoursThursday'), [$settings, 'inputHoursThursday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursFriday', $settings->getLabelAttr('hoursFriday'), [$settings, 'inputHoursFriday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursSaturday', $settings->getLabelAttr('hoursSaturday'), [$settings, 'inputHoursSaturday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );
        add_settings_field('hoursSunday', $settings->getLabelAttr('hoursSunday'), [$settings, 'inputHoursSunday'], $this->group.'_tab_1_block_1', $this->name.'_section_id' );

        add_settings_section( $this->name.'_section_id', false, false , $this->group.'_tab_1_block_2' );
        add_settings_field('dayWeekend', $settings->getLabelAttr('dayWeekend'), [$settings, 'inputDayWeekend'], $this->group.'_tab_1_block_2', $this->name.'_section_id' );
        add_settings_field('disabledDates', $settings->getLabelAttr('disabledDates'), [$settings, 'inputDisabledDates'], $this->group.'_tab_1_block_2', $this->name.'_section_id' );
        add_settings_field('disabledTimes', $settings->getLabelAttr('disabledTimes'), [$settings, 'inputDisabledTimes'], $this->group.'_tab_1_block_2', $this->name.'_section_id' );

        add_settings_section( $this->name.'_section_id', false, false , $this->group.'_tab_2_block_1' );
        add_settings_field('typeMeetings', $settings->getLabelAttr('typeMeetings'), [$settings, 'inputTypeMeetings'], $this->group.'_tab_2_block_1', $this->name.'_section_id' );

        add_settings_section( $this->name.'_section_id', false, false , $this->group.'_tab_2_block_2' );
        add_settings_field('labelTitle', $settings->getLabelAttr('labelTitle'), [$settings, 'inputLabelTitle'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );
        add_settings_field('labelName', $settings->getLabelAttr('labelName'), [$settings, 'inputLabelName'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );
        add_settings_field('labelPhone', $settings->getLabelAttr('labelPhone'), [$settings, 'inputLabelPhone'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );
        add_settings_field('labelThema', $settings->getLabelAttr('labelThema'), [$settings, 'inputLabelThema'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );
        add_settings_field('labelEmailSkype', $settings->getLabelAttr('labelEmailSkype'), [$settings, 'inputLabelEmailSkype'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );
        add_settings_field('labelSubject', $settings->getLabelAttr('labelSubject'), [$settings, 'inputLabelSubject'], $this->group.'_tab_2_block_2', $this->name.'_section_id' );

        add_settings_section( $this->name.'_section_id', false, false , $this->group.'_tab_3' );
        add_settings_field('templateEmailAppointmentSubject', $settings->getLabelAttr('templateEmailAppointmentSubject'), [$settings, 'inputEmailAppointmentSubject'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailAppointment', $settings->getLabelAttr('templateEmailAppointment'), [$settings, 'inputEmailAppointment'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailChangeSubject', $settings->getLabelAttr('templateEmailChangeSubject'), [$settings, 'inputEmailChangeSubject'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailChange', $settings->getLabelAttr('templateEmailChange'), [$settings, 'inputEmailChange'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailConfirmedSubject', $settings->getLabelAttr('templateEmailConfirmedSubject'), [$settings, 'inputEmailConfirmedSubject'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailConfirmed', $settings->getLabelAttr('templateEmailConfirmed'), [$settings, 'inputEmailConfirmed'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailRejectedSubject', $settings->getLabelAttr('templateEmailRejectedSubject'), [$settings, 'inputEmailRejectedSubject'], $this->group.'_tab_3', $this->name.'_section_id' );
        add_settings_field('templateEmailRejected', $settings->getLabelAttr('templateEmailRejected'), [$settings, 'inputEmailRejected'], $this->group.'_tab_3', $this->name.'_section_id' );

        register_setting( $this->group, $this->name.'_options', [SettingsPlugin::class, 'sanitize']);
    }

    public function prowp_setting_section() {
        echo '<p>Configure the Halloween plugin options below</p>';
    }

    public function actionPageSettings() {
        $this->addAsset();

        $this->view('page-settings',[
        ]);
    }

    private function addAsset() {
        $assetMainAdminSettings = new MainAdminSettingsAsset();
        add_action('admin_enqueue_scripts', array($assetMainAdminSettings, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($assetMainAdminSettings, 'enqueue_scripts'));
    }

    private function view() {
        $numargs = func_num_args();
        if (!$numargs || $numargs<2) return;

        $arg_list = func_get_args();
        foreach ($arg_list[1] as $key => $value) {
            ${$key} = $value;
        }
        include PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'views/admin/section-settings-plugin/'.$arg_list[0].'.php';
    }
}