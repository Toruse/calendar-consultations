<?php

namespace plugin\calendar\consultations\models;

use DateTime;

class SettingsPlugin {

    public $name;

    public $attr = [];

    public function __construct() {
        $this->name = OrganizeConsultation::$name.'_options';
        $this->attr = get_option($this->name);
        if (!$this->attr) $this->attr = [];
    }

    public static function sanitize($input) {
        $input['typeMeetings'] = sanitize_textarea_field($input['typeMeetings']);
        $input['labelName'] = sanitize_text_field($input['labelName']);
        $input['labelTitle'] = sanitize_text_field($input['labelTitle']);
        $input['labelPhone'] = sanitize_text_field($input['labelPhone']);
        $input['labelThema'] = sanitize_text_field($input['labelThema']);
        $input['labelEmailSkype'] = sanitize_text_field($input['labelEmailSkype']);
        $input['labelSubject'] = sanitize_text_field($input['labelSubject']);

        $input['hoursMonday'] = sanitize_text_field($input['hoursMonday']);
        $input['hoursTuesday'] = sanitize_text_field($input['hoursTuesday']);
        $input['hoursWednesday'] = sanitize_text_field($input['hoursWednesday']);
        $input['hoursThursday'] = sanitize_text_field($input['hoursThursday']);
        $input['hoursFriday'] = sanitize_text_field($input['hoursFriday']);
        $input['hoursSaturday'] = sanitize_text_field($input['hoursSaturday']);
        $input['hoursSunday'] = sanitize_text_field($input['hoursSunday']);

        if (is_array($input['dayWeekend'])) {
            foreach ($input['dayWeekend'] as $key => $value) {
                $input['dayWeekend'][$key] = (int) sanitize_text_field($value);
            }
        } else {
            $input['dayWeekend'] = [];
        }

        $input['disabledDates'] = sanitize_textarea_field($input['disabledDates']);
        $input['disabledTimes'] = sanitize_textarea_field($input['disabledTimes']);

        $input['templateEmailAppointmentSubject'] = sanitize_text_field($input['templateEmailAppointmentSubject']);
        $input['templateEmailChangeSubject'] = sanitize_text_field($input['templateEmailChangeSubject']);
        $input['templateEmailConfirmedSubject'] = sanitize_text_field($input['templateEmailConfirmedSubject']);
        $input['templateEmailRejectedSubject'] = sanitize_text_field($input['templateEmailRejectedSubject']);

        return $input;
    }

    public function getNameInput($name) {
        return $this->name.'['.$name.']';
    }

    public function getLabelAttr($name) {
        $attr = [
            'typeMeetings' => 'Type Meetings',
            'labelName' => 'Name',
            'labelTitle' => 'Title',
            'labelPhone' => 'Telefon',
            'labelThema' => 'Thema',
            'labelEmailSkype' => 'Email/Skype',
            'labelSubject' => 'Fachtichtung',

            'hoursMonday' => 'Monday',
            'hoursTuesday' => 'Tuesday',
            'hoursWednesday' => 'Wednesday',
            'hoursThursday' => 'Thursday',
            'hoursFriday' => 'Friday',
            'hoursSaturday' => 'Saturday',
            'hoursSunday' => 'Sunday',

            'dayWeekend' => 'Weekend',

            'disabledDates' => 'Disabled Dates',
            'disabledTimes' => 'Disabled Times',

            'templateEmailAppointmentSubject' => 'Template E-mail Appointment Subject',
            'templateEmailAppointment' => 'Template E-mail Appointment',
            'templateEmailChangeSubject' => 'Template E-mail Change Subject',
            'templateEmailChange' => 'Template E-mail Change',
            'templateEmailConfirmedSubject' => 'Template E-mail Confirmed Subject',
            'templateEmailConfirmed' => 'Template E-mail Confirmed',
            'templateEmailRejectedSubject' => 'Template E-mail Rejected Subject',
            'templateEmailRejected' => 'Template E-mail Rejected',
        ];
        return $attr[$name];
    }


    public function inputTypeMeetings() {
        if (!isset($this->typeMeetings)) {
            $this->typeMeetings = '';
        }

        echo "<textarea name='".$this->getNameInput('typeMeetings')."' rows='7' cols='50' type='textarea'>".$this->typeMeetings."</textarea>";
    }

    public function inputLabelTitle() {
        if (!isset($this->labelTitle)) {
            $this->labelTitle = '';
        }

        echo '<input name="'.$this->getNameInput('labelTitle').'" type="text" value="'.$this->labelTitle.'">';
    }

    public function inputLabelName() {
        if (!isset($this->labelName)) {
            $this->labelName = '';
        }

        echo '<input name="'.$this->getNameInput('labelName').'" type="text" value="'.$this->labelName.'">';
    }

    public function inputLabelPhone() {
        if (!isset($this->labelPhone)) {
            $this->labelPhone = '';
        }

        echo '<input name="'.$this->getNameInput('labelPhone').'" type="text" value="'.$this->labelPhone.'">';
    }

    public function inputLabelThema() {
        if (!isset($this->labelThema)) {
            $this->labelThema = '';
        }

        echo '<input name="'.$this->getNameInput('labelThema').'" type="text" value="'.$this->labelThema.'">';
    }

    public function inputLabelEmailSkype() {
        if (!isset($this->labelEmailSkype)) {
            $this->labelEmailSkype = '';
        }

        echo '<input name="'.$this->getNameInput('labelEmailSkype').'" type="text" value="'.$this->labelEmailSkype.'">';
    }

    public function inputLabelSubject() {
        if (!isset($this->labelSubject)) {
            $this->labelSubject = '';
        }

        echo '<input name="'.$this->getNameInput('labelSubject').'" type="text" value="'.$this->labelSubject.'">';
    }

    public function inputHoursMonday() {
        if (!isset($this->hoursMonday)) {
            $this->hoursMonday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursMonday').'" type="text" value="'.$this->hoursMonday.'">';
    }

    public function inputHoursTuesday() {
        if (!isset($this->hoursTuesday)) {
            $this->hoursTuesday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursTuesday').'" type="text" value="'.$this->hoursTuesday.'">';
    }

    public function inputHoursWednesday() {
        if (!isset($this->hoursWednesday)) {
            $this->hoursWednesday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursWednesday').'" type="text" value="'.$this->hoursWednesday.'">';
    }

    public function inputHoursThursday() {
        if (!isset($this->hoursThursday)) {
            $this->hoursThursday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursThursday').'" type="text" value="'.$this->hoursThursday.'">';
    }

    public function inputHoursFriday() {
        if (!isset($this->hoursFriday)) {
            $this->hoursFriday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursFriday').'" type="text" value="'.$this->hoursFriday.'">';
    }

    public function inputHoursSaturday() {
        if (!isset($this->hoursSaturday)) {
            $this->hoursSaturday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursSaturday').'" type="text" value="'.$this->hoursSaturday.'">';
    }

    public function inputHoursSunday() {
        if (!isset($this->hoursSunday)) {
            $this->hoursSunday = '';
        }

        echo '<input name="'.$this->getNameInput('hoursSunday').'" type="text" value="'.$this->hoursSunday.'">';
    }

    public function inputDayWeekend() {
        if (!isset($this->dayWeekend)) {
            $this->dayWeekend = [];
        }
        echo '<input '.checked(in_array(1, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="1" type="checkbox">Monday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(2, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="2" type="checkbox">Tuesday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(3, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="3" type="checkbox">Wednesday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(4, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="4" type="checkbox">Thursday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(5, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="5" type="checkbox">Friday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(6, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="6" type="checkbox">Saturday &nbsp;&nbsp;';
        echo '<input '.checked(in_array(0, $this->dayWeekend),true, false).' name="'.$this->getNameInput('dayWeekend').'[]" value="0" type="checkbox">Sunday &nbsp;&nbsp;';
    }

    public function inputDisabledDates() {
        if (!isset($this->disabledDates)) {
            $this->disabledDates = '';
        }

        echo "<textarea name='".$this->getNameInput('disabledDates')."' rows='7' cols='50' type='textarea'>".$this->disabledDates."</textarea>";
    }

    public function inputDisabledTimes() {
        if (!isset($this->disabledTimes)) {
            $this->disabledTimes = '';
        }

        echo "<textarea name='".$this->getNameInput('disabledTimes')."' rows='7' cols='50' type='textarea'>".$this->disabledTimes."</textarea>";
    }

    public function inputEmailAppointmentSubject() {
        if (!isset($this->templateEmailAppointmentSubject)) {
            $this->templateEmailAppointmentSubject = '';
        }

        echo '<input name="'.$this->getNameInput('templateEmailAppointmentSubject').'" type="text" value="'.$this->templateEmailAppointmentSubject.'">';
    }

    public function inputEmailAppointment() {
        if (!isset($this->templateEmailAppointment)) {
            $this->templateEmailAppointment = '';
        }

        echo "<textarea name='".$this->getNameInput('templateEmailAppointment')."' rows='15' cols='50' type='textarea'>".$this->templateEmailAppointment."</textarea>";
    }

    public function inputEmailChangeSubject() {
        if (!isset($this->templateEmailChangeSubject)) {
            $this->templateEmailChangeSubject = '';
        }

        echo '<input name="'.$this->getNameInput('templateEmailChangeSubject').'" type="text" value="'.$this->templateEmailChangeSubject.'">';
    }

    public function inputEmailChange() {
        if (!isset($this->templateEmailChange)) {
            $this->templateEmailChange = '';
        }

        echo "<textarea name='".$this->getNameInput('templateEmailChange')."' rows='15' cols='50' type='textarea'>".$this->templateEmailChange."</textarea>";
    }

    public function inputEmailConfirmedSubject() {
        if (!isset($this->templateEmailConfirmedSubject)) {
            $this->templateEmailConfirmedSubject = '';
        }

        echo '<input name="'.$this->getNameInput('templateEmailConfirmedSubject').'" type="text" value="'.$this->templateEmailConfirmedSubject.'">';
    }

    public function inputEmailConfirmed() {
        if (!isset($this->templateEmailConfirmed)) {
            $this->templateEmailConfirmed = '';
        }

        echo "<textarea name='".$this->getNameInput('templateEmailConfirmed')."' rows='15' cols='50' type='textarea'>".$this->templateEmailConfirmed."</textarea>";
    }

    public function inputEmailRejectedSubject() {
        if (!isset($this->templateEmailRejectedSubject)) {
            $this->templateEmailRejectedSubject = '';
        }

        echo '<input name="'.$this->getNameInput('templateEmailRejectedSubject').'" type="text" value="'.$this->templateEmailRejectedSubject.'">';
    }

    public function inputEmailRejected() {
        if (!isset($this->templateEmailRejected)) {
            $this->templateEmailRejected = '';
        }

        echo "<textarea name='".$this->getNameInput('templateEmailRejected')."' rows='15' cols='50' type='textarea'>".$this->templateEmailRejected."</textarea>";
    }

    public function __get($name)
    {
        return $this->attr[$name];
    }

    public function __isset($name)
    {
        return isset($this->attr[$name]);
    }

    public function __set($name, $value)
    {
        $this->attr[$name] = $value;
    }

    public function __unset($name)
    {
        unset($this->attr[$name]);
    }

    public function getListTypeMeetings() {
        if (!isset($this->typeMeetings)) return [];

        $typeMeetings = explode("\n", $this->typeMeetings);

        if (!is_array($typeMeetings)) return [];

        $result = [];

        foreach ($typeMeetings as $type) {
            $result[sanitize_title($type)] = $type;
        }

        return $result;
    }

    public function getSettingDateTimePicker() {
        $settings = $this->attr;

        unset($settings['labelName']);
        unset($settings['labelPhone']);
        unset($settings['labelSubject']);
        unset($settings['labelThema']);
        unset($settings['labelTitle']);
        unset($settings['typeMeetings']);
        unset($settings['labelEmailSkype']);

        $settings['hours'][0] = self::getTimeRange($settings['hoursSunday']);
        unset($settings['hoursSunday']);
        $settings['hours'][1] = self::getTimeRange($settings['hoursMonday']);
        unset($settings['hoursMonday']);
        $settings['hours'][2] = self::getTimeRange($settings['hoursTuesday']);
        unset($settings['hoursTuesday']);
        $settings['hours'][3] = self::getTimeRange($settings['hoursWednesday']);
        unset($settings['hoursWednesday']);
        $settings['hours'][4] = self::getTimeRange($settings['hoursThursday']);
        unset($settings['hoursThursday']);
        $settings['hours'][5] = self::getTimeRange($settings['hoursFriday']);
        unset($settings['hoursFriday']);
        $settings['hours'][6] = self::getTimeRange($settings['hoursSaturday']);
        unset($settings['hoursSaturday']);

        $settings['disabledDates'] = $this->getListDisabledDates($settings['disabledDates']);
        $settings['disabledTimes'] = $this->getListDisabledTimes($settings['disabledTimes']);

        return $settings;
    }

    public static function getTimeRange($str) {
        $str = preg_replace('/[^:\-0-9]/', '', $str);
        $timeRange = explode('-', $str);
        if (!(is_array($timeRange) && count($timeRange)==2)) return false;

        return [$timeRange[0], $timeRange[1]];
    }

    public function getListDisabledDates() {
        if (!isset($this->disabledDates)) return [];

        $disabledDates = explode("\n", $this->disabledDates);

        if (!is_array($disabledDates)) return [];

        $result = [];

        foreach ($disabledDates as $date) {
            $date = preg_replace('/[^\.\-0-9]/', '', $date);
            if (strripos($date, '-')!==false) {
                $dateRange = explode('-', $date);
                if (!(is_array($dateRange) && count($dateRange)==2)) continue;
                $result[] = $dateRange[0];
                while (strtotime($dateRange[0])<strtotime($dateRange[1]))
                {
                    $dateRange[0] = date('d.m.Y', strtotime($dateRange[0].' + 1 days'));
                    $result[] = $dateRange[0];
                }
                continue;
            }
            if (date('d.m.Y', strtotime($date)) == $date) {
                $result[] = $date;
            }
        }

        return $result;
    }

    public function getListDisabledTimes() {
        if (!isset($this->disabledTimes)) return [];

        $disabledTimes = explode("\n", $this->disabledTimes);

        if (!is_array($disabledTimes)) return [];

        $result = [];

        foreach ($disabledTimes as $time) {
            $time = preg_replace('/[^:0-9]/', '', $time);
            if (strlen($time)<=5) $result[] = $time;
        }

        return $result;
    }

    public function countRequestsDayWeek($date, $count) {
        $hours = $this->attr['hours'.date("l", strtotime($date))];
        if (!$hours) return false;

        $timeRange = $this->getTimeRange($hours);
        $minDate = $date.' '.$timeRange[0];
        $maxDate = $date.' '.$timeRange[1];
        $d1=new DateTime($minDate);
        $d2=new DateTime($maxDate);
        $diff=$d2->diff($d1);

        $minTime = strtotime($minDate);
        $maxTime = strtotime($maxDate);
        $disabledTimes = $this->getListDisabledTimes($this->disabledTimes);

        if (!empty($disabledTimes)) {
            foreach ($disabledTimes as $time) {
                $tmpDate = strtotime($date.' '.$time);
                if ($minTime<$tmpDate && $tmpDate<$maxTime) $diff->h--;
            }
        }

        return $count>=$diff->h;
    }
}