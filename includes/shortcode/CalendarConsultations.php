<?php

namespace  plugin\calendar\consultations\shortcode;

use plugin\calendar\consultations\asset\CalendarConsultationsAsset;
use plugin\calendar\consultations\asset\DateTimePickerAsset;
use plugin\calendar\consultations\asset\ValidateFormAsset;
use plugin\calendar\consultations\models\OrganizeConsultation;
use plugin\calendar\consultations\models\OrganizeConsultationForm;
use plugin\calendar\consultations\models\SettingsPlugin;

class CalendarConsultations {

    public $name = 'calendar-consultations';

    public $form = null;

    public $dates = [];

    public $settings = null;

    public function add_shortcode() {
        $this->addAsset();
        $this->addAction();
        add_shortcode($this->name, array($this, 'shortcode'));
    }

    public function shortcode($attibutes, $content) {
        $this->form = new OrganizeConsultationForm();

        $model = new OrganizeConsultation();
        $this->dates = $model->getIdPostSpecifiedTime();

        $this->settings = new SettingsPlugin();

        return $this->view();
    }

    private function addAsset() {
        $assetDateTimePicker = new DateTimePickerAsset();
        add_action('wp_enqueue_scripts', [$assetDateTimePicker, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$assetDateTimePicker, 'enqueue_scripts']);

        $assetValidateForm = new ValidateFormAsset();
        add_action('wp_enqueue_scripts', [$assetValidateForm, 'enqueue_scripts']);

        $assetCalendarConsultations = new CalendarConsultationsAsset();
        add_action('wp_enqueue_scripts', [$assetCalendarConsultations, 'enqueue_scripts']);
    }

    private function view() {
        ob_start();
        include PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'views/shortcode/calendar-consultations.php';
        return ob_get_clean();
    }

    public function addAction() {
        add_action('wp_ajax_save_appointment', array($this, 'actionSaveAppointment'));
        add_action('wp_ajax_nopriv_save_appointment', array($this, 'actionSaveAppointment'));
    }

    public function actionSaveAppointment() {
        $form = new OrganizeConsultationForm();
        if ($form->load() && $form->save()) {
            $model = new OrganizeConsultation();
            $this->dates = $model->getIdPostSpecifiedTime();
            echo json_encode([
                'status' => 'ok',
                'dates' => json_encode($this->dates)
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'errors' => $form->getErrors()
            ]);
        }
        wp_die();
    }
}