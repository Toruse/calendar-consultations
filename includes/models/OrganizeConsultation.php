<?php

namespace  plugin\calendar\consultations\models;

class OrganizeConsultation {

    public static $name = 'organize_consult';

    public $post = null;

    public $typeMeeting;

    public $date;

    public $title;

    public $thema;

    public $f_name;

    public $email_skype = null;

    public $phone;

    public $subject;

    private $errors = [];

    public function register() {
        register_post_type( self::$name, [
                'labels' => array(
                    'name' => 'Consultation',
                    'singular_name' => 'Consultations',
                ),
                'public' => true,
                'exclude_from_search ' => false,
                'publicly_queryable' => false,
                'has_archive' => false,
                'query_var' => false,
                'rewrite' => array( 'slug' => 'consultation' ),
                'supports' => array('title'),
            ]
        );
    }

    public function getIdPostSpecifiedTime() {
        global $wpdb;
        $dates = $wpdb->get_results(
            "SELECT post_id, postmeta.meta_value "
            ."FROM $wpdb->postmeta AS postmeta LEFT JOIN $wpdb->posts AS posts ON postmeta.post_id = posts.ID "
            ."WHERE posts.post_type = '".self::$name."' AND postmeta.meta_key='date' AND STR_TO_DATE(postmeta.meta_value, '%d.%m.%Y %H:%i')>=curdate() AND posts.post_status!='trash'"
        );

        $result = [];
        foreach ($dates as $date) {
            if (empty($date->meta_value)) continue;
            $date->meta_value = explode(' ', $date->meta_value);
            if (is_array($date->meta_value) && isset($date->meta_value[0]) && isset($date->meta_value[1])) {
                $result[$date->meta_value[0]]['enable'] = true;
                $result[$date->meta_value[0]]['time'][] = $date->meta_value[1];
            }
        }

        $settings = new SettingsPlugin();
        foreach ($result as $key => $value) {
            $times = array_unique($value['time']);
            $result[$key]['disable'] = $settings->countRequestsDayWeek($key, count($times));
            $result[$key]['time'] = $times;
        }

        return $result;
    }

    public function loadMeta($post) {
        $this->post = $post;

        $this->typeMeeting = get_post_meta( $post->ID,'typeMeeting',true );
        $this->date = get_post_meta( $post->ID,'date',true );
        $this->title = get_post_meta( $post->ID,'title',true );
        $this->thema = get_post_meta( $post->ID,'thema',true );
        $this->f_name = get_post_meta( $post->ID,'name',true );
        $this->email_skype = get_post_meta( $post->ID,'email_skype',true );
        $this->phone = get_post_meta( $post->ID,'phone',true );
        $this->subject = get_post_meta( $post->ID,'subject',true );
    }

    public function saveMeta($postId) {
        $old_typeMeeting = get_post_meta( $postId,'typeMeeting',true );
        $this->typeMeeting = sanitize_text_field($_POST[self::$name]['typeMeeting']);

        $old_date = get_post_meta( $postId,'date',true );
        $this->date = sanitize_text_field($_POST[self::$name]['date']);

        $old_title = get_post_meta( $postId,'title',true );
        $this->title = sanitize_text_field($_POST[self::$name]['title']);

        $old_thema = get_post_meta( $postId,'thema',true );
        $this->thema = sanitize_text_field($_POST[self::$name]['thema']);

        $old_name = get_post_meta( $postId,'name',true );
        $this->f_name = sanitize_text_field($_POST[self::$name]['f_name']);

        $old_email_skype = get_post_meta( $postId,'email_skype',true );
        $this->email_skype = sanitize_text_field($_POST[self::$name]['email_skype']);

        $old_phone = get_post_meta( $postId,'phone',true );
        $this->phone = sanitize_text_field($_POST[self::$name]['phone']);

        $old_subject = get_post_meta( $postId,'subject',true );
        $this->subject = sanitize_text_field($_POST[self::$name]['subject']);

        update_post_meta( $postId, 'typeMeeting', $this->typeMeeting);
        update_post_meta( $postId, 'date', $this->date);
        update_post_meta( $postId, 'title', $this->title);
        update_post_meta( $postId, 'thema', $this->thema);
        update_post_meta( $postId, 'name', $this->f_name);
        update_post_meta( $postId, 'email_skype', $this->email_skype);
        update_post_meta( $postId, 'phone', $this->phone);
        update_post_meta( $postId, 'subject', $this->subject);

        if (
            $old_typeMeeting != $this->typeMeeting
            || $old_date != $this->date
            || $old_title != $this->title
            || $old_thema != $this->thema
            || $old_name != $this->f_name
            || $old_email_skype != $this->email_skype
            || $old_phone != $this->phone
            || $old_subject != $this->subject
        ) {
            $this->sendMail();
        }
    }

    public function setStatus($newStatus, $oldStatus, $post) {
        if ($newStatus == $oldStatus || get_post_type($post->ID) != self::$name) return true;
        switch ($newStatus) {
            case 'publish':
                $this->sendMailConfirmed($post);
                break;
            case 'trash':
                $this->sendMailRejected($post);
                break;
        }
    }

    public function getNameInput($name) {
        return self::$name.'['.$name.']';
    }

    private function sendMail() {
        if (!filter_var($this->email_skype, FILTER_VALIDATE_EMAIL)) return;
        $settings = new SettingsPlugin();

        $subject = $settings->templateEmailChangeSubject;
        $sender = '<'.$this->email_skype.'>';

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
                $this->f_name,
                $this->email_skype,
                $this->phone,
                $this->subject,
            ],
            $settings->templateEmailChange
        );

        $headers = "From: $sender\n";
        if ( true ) {
            $headers .= "Content-Type: text/html\n";
            $headers .= "X-WPCF7-Content-Type: text/html\n";
        } else {
            $headers .= "X-WPCF7-Content-Type: text/plain\n";
        }

        return wp_mail($this->email_skype, $subject, $body, $headers);
    }

    private function sendMailConfirmed($post) {
        if (!$this->email_skype) $this->loadMeta($post);

        if (!filter_var($this->email_skype, FILTER_VALIDATE_EMAIL)) return;
        $settings = new SettingsPlugin();

        $subject = $settings->templateEmailConfirmedSubject;
        $sender = '<'.$this->email_skype.'>';

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
                $this->f_name,
                $this->email_skype,
                $this->phone,
                $this->subject,
            ],
            $settings->templateEmailConfirmed
        );

        $headers = "From: $sender\n";
        if ( true ) {
            $headers .= "Content-Type: text/html\n";
            $headers .= "X-WPCF7-Content-Type: text/html\n";
        } else {
            $headers .= "X-WPCF7-Content-Type: text/plain\n";
        }

        return wp_mail($this->email_skype, $subject, $body, $headers);
    }

    private function sendMailRejected($post) {
        if (!$this->email_skype) $this->loadMeta($post);

        if (!filter_var($this->email_skype, FILTER_VALIDATE_EMAIL)) return;
        $settings = new SettingsPlugin();

        $subject = $settings->templateEmailRejectedSubject;
        $sender = '<'.$this->email_skype.'>';

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
                $this->f_name,
                $this->email_skype,
                $this->phone,
                $this->subject,
            ],
            $settings->templateEmailRejected
        );

        $headers = "From: $sender\n";
        if ( true ) {
            $headers .= "Content-Type: text/html\n";
            $headers .= "X-WPCF7-Content-Type: text/html\n";
        } else {
            $headers .= "X-WPCF7-Content-Type: text/plain\n";
        }

        return wp_mail($this->email_skype, $subject, $body, $headers);
    }
}