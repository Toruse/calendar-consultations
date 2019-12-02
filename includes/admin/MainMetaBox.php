<?php
namespace plugin\calendar\consultations\admin;

use plugin\calendar\consultations\asset\admin\AdminDateTimePickerAsset;
use plugin\calendar\consultations\asset\admin\MainAdminTypeAsset;
use plugin\calendar\consultations\models\OrganizeConsultation;
use plugin\calendar\consultations\models\SettingsPlugin;

class MainMetaBox
{

    public $name;

    public static $settings = null;

    public function __construct()
    {
        $this->name = OrganizeConsultation::$name;
        self::$settings = new SettingsPlugin();

        $this->addMetaBoxes();
        $this->addAsset();

        add_action('save_post', [$this, 'saveMeta']);
        add_filter('manage_'.$this->name.'_posts_columns', [$this, 'addColumns']);
        add_action('manage_'.$this->name.'_posts_custom_column' , [$this, 'addColumnValue'], 10, 2);
        add_action('transition_post_status', [$this, 'setStatus'], 10, 3);
    }

    public function addMetaBoxes()
    {
        add_action('add_meta_boxes_' . $this->name, function() {
            add_meta_box($this->name . '_meta_main', 'Information', [$this, 'addMain'], $this->name, 'advanced', 'default');
        });
    }

    public function addMain($post, $box)
    {
        $model = new OrganizeConsultation();
        $model->loadMeta($post);

        $settings = new SettingsPlugin();

        $this->view('update',[
            'model' => $model,
            'settings' => $settings
        ]);
    }

    public function saveMeta($postId) {
        if (isset($_POST[OrganizeConsultation::$name])) {
            if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            check_admin_referer( OrganizeConsultation::$name, 'csrf' );

            $model = new OrganizeConsultation();
            $model->saveMeta($postId);
        }
    }

    private function view() {
        $numargs = func_num_args();
        if (!$numargs || $numargs<2) return;

        $arg_list = func_get_args();
        foreach ($arg_list[1] as $key => $value) {
            ${$key} = $value;
        }
        include PLUGIN_CALENDAR_CONSULTATIONS_PATH . 'views/admin/main-meta-box/'.$arg_list[0].'.php';
    }

    public function addColumns($columns) {
        $add_columns = [
            "typeMeeting" => "Type Meeting",
            "phone" => "Phone",
            "email_skype" => "Email Skype",
        ];
        $result = [];
        foreach ($columns as $key => $column) {
            $result[$key] = $column;
            if ($key == 'title') {
                $result = array_merge($result, $add_columns);
            }
        }
        return $result;
    }

    public function addColumnValue($column, $postId) {
        if ($column === 'typeMeeting') {
            $listTypeMeetings = self::$settings->getListTypeMeetings();
            $typeMeeting = esc_html(get_post_meta($postId, 'typeMeeting', true));
            echo isset($listTypeMeetings[$typeMeeting])?$listTypeMeetings[$typeMeeting]:$typeMeeting;
        }
        if ($column === 'phone') {
            echo esc_html(get_post_meta($postId, 'phone', true));
        }
        if ($column === 'email_skype') {
            echo esc_html(get_post_meta($postId, 'email_skype', true));
        }
    }

    private function addAsset() {
        $assetDateTimePicker = new AdminDateTimePickerAsset();
        add_action('admin_enqueue_scripts', array($assetDateTimePicker, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($assetDateTimePicker, 'enqueue_scripts'));

        $assetMainAdminType = new MainAdminTypeAsset();
        add_action('admin_enqueue_scripts', array($assetMainAdminType, 'enqueue_scripts'));
    }

    public function setStatus($newStatus, $oldStatus, $post) {
        $model = new OrganizeConsultation();
        $model->setStatus($newStatus, $oldStatus, $post);
    }
}