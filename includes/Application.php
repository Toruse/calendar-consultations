<?php

namespace  plugin\calendar\consultations;

use plugin\calendar\consultations\admin\MainMetaBox;
use plugin\calendar\consultations\admin\SectionSettingsPlugin;
use plugin\calendar\consultations\models\OrganizeConsultation;
use plugin\calendar\consultations\models\SettingsPlugin;
use plugin\calendar\consultations\shortcode\CalendarConsultations;

class Application {

    protected $plugin_name;

    public function __construct() {
        $this->plugin_name = defined( 'PLUGIN_CALENDAR_PLUGIN_NAME' )?PLUGIN_CALENDAR_PLUGIN_NAME:'noname_plugin';

        $this->load_dependencies();
//        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    public function run() {
        load_plugin_textdomain( PLUGIN_CALENDAR_PLUGIN_NAME, false, PLUGIN_CALENDAR_PLUGIN_NAME . '/languages/' );
    }

    private function load_dependencies() {
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/DateTimePickerAsset.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/CalendarConsultationsAsset.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/ValidateFormAsset.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/admin/MainAdminSettingsAsset.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/admin/MainAdminTypeAsset.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/asset/admin/AdminDateTimePickerAsset.php';

        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/models/OrganizeConsultation.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/models/OrganizeConsultationForm.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/models/SettingsPlugin.php';

        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/admin/MainMetaBox.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/admin/SectionSettingsPlugin.php';
        require_once PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'includes/shortcode/CalendarConsultations.php';
    }

    private function define_public_hooks() {
        $shortcodeCalendarConsultations = new CalendarConsultations();
        $shortcodeCalendarConsultations->add_shortcode();

        $typeOrganizeConsultation = new OrganizeConsultation();
        add_action('init', array($typeOrganizeConsultation, 'register') );

        new MainMetaBox();
        new SectionSettingsPlugin();
    }

    public static function install() {
        $settings = new SettingsPlugin();

        $settings->typeMeetings = "Über Skype\nKomm ins Büro\nEinen Berater anrufen\nTelefonisch";

        $settings->labelTitle = 'Title';
        $settings->labelName = 'Name';
        $settings->labelPhone = 'Telefon';
        $settings->labelThema = 'Thema';
        $settings->labelEmailSkype = 'Email/Skype';
        $settings->labelSubject = 'Fachtichtung';

        $settings->hoursMonday = '09:00-20:00';
        $settings->hoursTuesday = '09:00-20:00';
        $settings->hoursWednesday = '09:00-20:00';
        $settings->hoursThursday = '09:00-20:00';
        $settings->hoursFriday = '09:00-20:00';
        $settings->hoursSaturday = '09:00-20:00';
        $settings->hoursSunday = '09:00-20:00';

        $settings->dayWeekend = [0, 6];

        $settings->disabledDates = "01.08.2018\n10.08.2018-20.08.2018\n24.08.2018";
        $settings->disabledTimes = "12:00\n13:00\n";

        $settings->templateEmailAppointmentSubject = 'Antrag auf Konsultation';
        $settings->templateEmailAppointment = "Informationen über die Konsultation<br>\nGeben Sie ein: [typeMeeting]<br>\nDatum: [date]<br>\nTitle: [title]<br>\nThema: [thema]<br>\nName: [name]<br>\nEmail/Skype: [email_skype]<br>\nTelefon: [phone]<br>\nFachtichtung: [subject]<br>\n";

        $settings->templateEmailChangeSubject = 'Änderungen in der Ernennung einer Konsultation';
        $settings->templateEmailChange = "Informationen über die Konsultation<br>\nGeben Sie ein: [typeMeeting]<br>\nDatum: [date]<br>\nTitle: [title]<br>\nThema: [thema]<br>\nName: [name]<br>\nEmail/Skype: [email_skype]<br>\nTelefon: [phone]<br>\nFachtichtung: [subject]<br>\n";

        $settings->templateEmailConfirmedSubject = 'Die Konsultation wurde bestätigt';
        $settings->templateEmailConfirmed = "Informationen über die Konsultation<br>\nGeben Sie ein: [typeMeeting]<br>\nDatum: [date]<br>\nTitle: [title]<br>\nThema: [thema]<br>\nName: [name]<br>\nEmail/Skype: [email_skype]<br>\nTelefon: [phone]<br>\nFachtichtung: [subject]<br>\n";

        $settings->templateEmailRejectedSubject = 'Die Konsultation wurde abgelehnt';
        $settings->templateEmailRejected = "Informationen über die Konsultation<br>\nGeben Sie ein: [typeMeeting]<br>\nDatum: [date]<br>\nTitle: [title]<br>\nThema: [thema]<br>\nName: [name]<br>\nEmail/Skype: [email_skype]<br>\nTelefon: [phone]<br>\nFachtichtung: [subject]<br>\n";

        update_option( $settings->name, $settings->attr);
    }
}