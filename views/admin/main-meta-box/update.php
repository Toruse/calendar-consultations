<?php

use plugin\calendar\consultations\models\OrganizeConsultation;

?>

<?php wp_nonce_field(OrganizeConsultation::$name,'csrf'); ?>

<p>
    <label>Type Meeting:</label><br>
    <select name="<?= $model->getNameInput('typeMeeting') ?>">
        <?php foreach ($settings->getListTypeMeetings() as $key => $type): ?>
            <option value="<?= $key ?>" <?php selected($model->typeMeeting, $key) ?>><?= $type ?></option>
        <?php endforeach; ?>
    </select>
</p>

<p>
    <label>Title:</label><br>
    <input name="<?= $model->getNameInput('title') ?>" class="code" value="<?= esc_attr($model->title) ?>" type="text">
</p>

<p>
    <label>Thema:</label><br>
    <input name="<?= $model->getNameInput('thema') ?>" class="code" value="<?= esc_attr($model->thema) ?>" type="text">
</p>

<p>
    <label>Name:</label><br>
    <input name="<?= $model->getNameInput('f_name') ?>" class="code" value="<?= esc_attr($model->f_name) ?>" type="text">
</p>

<p>
    <label>Email Skype:</label><br>
    <input name="<?= $model->getNameInput('email_skype') ?>" class="code" value="<?= esc_attr($model->email_skype) ?>" type="text">
</p>

<p>
    <label>Phone:</label><br>
    <input name="<?= $model->getNameInput('phone') ?>" class="code" value="<?= esc_attr($model->phone) ?>" type="text">
</p>

<p>
    <label>Subject:</label><br>
    <input name="<?= $model->getNameInput('subject') ?>" class="code" value="<?= esc_attr($model->subject) ?>" type="text">
</p>

<p>
    <label>Date:</label><br>
    <input name="<?= $model->getNameInput('date') ?>" class="code" value="<?= esc_attr($model->date) ?>" type="text">
</p>
