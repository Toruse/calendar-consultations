<?php

namespace  plugin\calendar\consultations\models;

class OrganizeConsultationForm {

    public $token = 'organize_consultation_form_csrf';

    public $typeMeeting;

    public $date;

    public $title;

    public $thema;

    public $name;

    public $email_skype;

    public $phone;

    public $subject;

    private $errors = [];

    public function load() {
        if (self::isAjax() && self::isPost()) {
            check_admin_referer($this->token,'csrf');
            $this->typeMeeting = sanitize_text_field($_POST["typeMeeting"]);
            $this->date = $this->filterDate(sanitize_text_field($_POST["date"]));
            $this->title = sanitize_text_field($_POST["title"]);
            $this->thema = sanitize_text_field($_POST["thema"]);
            $this->name = sanitize_text_field($_POST["name"]);
            $this->email_skype = sanitize_text_field($_POST["email_skype"]);
            $this->phone = sanitize_text_field($_POST["phone"]);
            $this->subject = sanitize_text_field($_POST["subject"]);
            return true;
        }
        return false;
    }

    public function save() {
        if (!$this->validate()) return false;

        $post_id = wp_insert_post($this->getData(), true);
        if( is_wp_error($post_id) ){
            $this->errors = $post_id->get_error_message();
            return false;
        } else {
            $this->sendMail();
            return true;
        }
    }

    public function validate() {
        if (empty(trim($this->typeMeeting))) return false;

        if (empty(trim($this->date))) return false;
        if ($this->validateDate()) return false;
        if ($this->validateDateTimeConsultation()) return false;
        if ($this->validateDisableDateTimeConsultation()) return false;

        if (empty(trim($this->title))) return false;

        if (empty(trim($this->thema))) return false;

        if (empty(trim($this->name))) return false;

        if (empty(trim($this->email_skype))) return false;

        if (empty(trim($this->phone))) return false;

        if (empty(trim($this->subject))) return false;

        return true;
    }

    public static function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getData() {
        return [
            'post_author' => 0,
            'post_date' => date('Y-m-d H:i:s'),
            'post_date_gmt'  => date('Y-m-d H:i:s'),
            'post_status' => 'pending',
            'post_title' => 'Consultation '.$this->date,
            'post_type' => OrganizeConsultation::$name,
            'comment_status' => 'closed',
            'meta_input' => [
                'typeMeeting' => $this->typeMeeting,
                'date' => $this->date,
                'title' => $this->title,
                'thema' => $this->thema,
                'name' => $this->name,
                'email_skype' => $this->email_skype,
                'phone' => $this->phone,
                'subject' => $this->subject,
            ],
        ];
    }

    public function validateDateTimeConsultation() {
        global $wpdb;
        $date = $wpdb->get_var(
            "SELECT post_id, postmeta.meta_value "
            ."FROM $wpdb->postmeta AS postmeta LEFT JOIN $wpdb->posts AS posts ON postmeta.post_id = posts.ID "
            ."WHERE posts.post_type = '".OrganizeConsultation::$name."' AND postmeta.meta_key='date' AND postmeta.meta_value='".$this->date."' AND posts.post_status!='trash'",
            1,
            0
        );
        return $date;
    }

    public function validateDisableDateTimeConsultation() {
        $settings = new SettingsPlugin();
        $settings = $settings->getSettingDateTimePicker();

        $week = date('w', strtotime($this->date));
        if (in_array($week, $settings['dayWeekend'])) return true;

        $date = date('d.m.Y', strtotime($this->date));
        if (in_array($date, $settings['disabledDates'])) return true;

        if (in_array(date('H:i', strtotime($this->date)), $settings['disabledTimes'])) return true;

        if (isset($settings['hours']) && is_array($settings['hours']) && isset($settings['hours'][$week])) {
            $minTime = strtotime($date.' '.$settings['hours'][$week][0]);
            $maxTime = strtotime($date.' '.$settings['hours'][$week][1]);
            $time = strtotime($this->date);
            if (!($minTime<$time && $time<$maxTime)) return true;
        }

        return false;
    }

    public function validateDate() {
        return date('d.m.Y H:i', strtotime($this->date)) != $this->date;
    }

    public function filterDate($value) {
        return date("d.m.Y H:i",(floor(floor(strtotime($value)/60)/60)+floor(date("i",strtotime($value))/60))*3600);
    }

    private function sendMail() {
        $settings = new SettingsPlugin();

        $subject = $settings->templateEmailAppointmentSubject;
        $mailAdmin = get_option('admin_email');
        $sender = '<'.$mailAdmin.'>';

        $listTypeMeetings = $settings->getListTypeMeetings();
        $typeMeeting = isset($listTypeMeetings[$this->typeMeeting])?$listTypeMeetings[$this->typeMeeting]:$this->typeMeeting;

        $body = str_replace(
            [
                '[typeMeeting]',
                '[date]',
                '[title]',
                '[thema]',
                '[name]',
                '[email_skype]',
                '[phone]',
                '[subject]',
            ],
            [
                $typeMeeting,
                $this->date,
                $this->title,
                $this->thema,
                $this->name,
                $this->email_skype,
                $this->phone,
                $this->subject,
            ],
            $settings->templateEmailAppointment
        );

        $headers = "From: $sender\n";
        if ( true ) {
            $headers .= "Content-Type: text/html\n";
            $headers .= "X-WPCF7-Content-Type: text/html\n";
        } else {
            $headers .= "X-WPCF7-Content-Type: text/plain\n";
        }

        if(filter_var("$this->email_skype", FILTER_VALIDATE_EMAIL)) {
            wp_mail($this->email_skype, $subject, $body, $headers);
        }
        return wp_mail($mailAdmin, $subject, $body, $headers);
    }

}