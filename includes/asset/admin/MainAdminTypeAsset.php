<?php

namespace  plugin\calendar\consultations\asset\admin;

use plugin\calendar\consultations\models\OrganizeConsultation;

class MainAdminTypeAsset {

    private $name = 'calendar_consultations';

    public function __construct() {
        $this->plugin = PLUGIN_CALENDAR_PLUGIN_NAME . $this->name;
    }

    public function enqueue_styles() {

    }

    public function enqueue_scripts($hook) {
        global $post_type;

        if ('post.php' == $hook && $post_type == OrganizeConsultation::$name) {
            wp_enqueue_script($this->name, PLUGIN_CALENDAR_CONSULTATIONS_URL . 'public/js/main-admin-type.js', array( 'jquery', 'jquery-ui-tabs'), false, true);
        }
    }
}