<?php

$form = $this->form;
$dates = $this->dates;
$settings = $this->settings;

?>
<section class="main-page-vereinbaren container" id="tocalendar">
    <h2 id="beratungs">
        Beratungstermin
        <span>vereinbaren</span>
    </h2>
    <div class="main-page-vereinbaren__calculator-wrapper">
        <form action="save_appointment" method="post" class="calendar-consultations-form">
            <?php wp_nonce_field($form->token,'csrf'); ?>
            <input type="hidden" name="dates" value="<?= htmlspecialchars(json_encode($dates)) ?>">
            <input type="hidden" name="settings" value="<?= htmlspecialchars(json_encode($settings->getSettingDateTimePicker())) ?>">
            <ol>
                <li>Wählen Sie die Art von Besprechung, die für Sie geeignet ist
                    <div class="main-page-vereinbaren__checkbox-wrapper">
                        <?php foreach ($settings->getListTypeMeetings() as $key => $type): ?>
                            <label>
                                <input class="checkbox" type="radio" name="typeMeeting" value="<?= $key ?>" required data-name="Geben Sie Besprechungen ein">
                                <span class="checkbox-custom checkbox-custom-blue"></span>
                                <span class="label">
                                    <?= $type ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>Wählen Sie das freie Datum und die Uhrzeit des Meetings aus. Füllen Sie auch die Felder des Kontaktformulars aus
                    <div class="main-page-vereinbaren__calendar-infoform-wrapper">
                        <div class="main-page-vereinbaren__calendar-wrapper">
                            <input class="calendar-consultations-datetimepicker" type="text" name="date" value="<?= esc_attr($form->date) ?>" required data-name="Datum">
                        </div>
                        <div class="main-page-vereinbaren__infoform-wrapper">
                            <h6>Sie haben das Datum ausgewählt:
                                <span data-model="date"></span>
                                Zeit:
                                <span data-model="time"></span>
                            </h6>
                            <div class="main-page-vereinbaren__infoform-input-wrapper">
                                <input
                                        class="white-input"
                                        type="text"
                                        placeholder="<?= isset($settings->labelTitle)?$settings->labelTitle:'' ?>"
                                        name="title"
                                        value="<?= esc_attr($form->title) ?>"
                                        required
                                        data-name="<?= isset($settings->labelTitle)?$settings->labelTitle:'' ?>"
                                >
                                <input
                                        class="white-input"
                                        type="text"
                                        placeholder="<?= isset($settings->labelThema)?$settings->labelThema:'' ?>"
                                        name="thema"
                                        value="<?= esc_attr($form->thema) ?>"
                                        required
                                        data-name="<?= isset($settings->labelThema)?$settings->labelThema:'' ?>"
                                >
                                <input
                                        class="white-input"
                                        type="text"
                                        placeholder="<?= isset($settings->labelName)?$settings->labelName:'' ?>"
                                        name="name"
                                        value="<?= esc_attr($form->name) ?>"
                                        required
                                        data-name="<?= isset($settings->labelName)?$settings->labelName:'' ?>"
                                >
                                <input
                                        class="white-input"
                                        type="text"
                                        placeholder="<?= isset($settings->labelEmailSkype)?$settings->labelEmailSkype:'' ?>"
                                        name="email_skype"
                                        value="<?= esc_attr($form->email_skype) ?>"
                                        required
                                        data-name="<?= isset($settings->labelEmailSkype)?$settings->labelEmailSkype:'' ?>"
                                >
                                <input
                                        class="white-input"
                                        type="tel"
                                        pattern="[0-9]{12,13}"
                                        placeholder="<?= isset($settings->labelPhone)?$settings->labelPhone:'' ?>"
                                        name="phone"
                                        value="<?= esc_attr($form->phone) ?>"
                                        required
                                        data-name="<?= isset($settings->labelPhone)?$settings->labelPhone:'' ?>"
                                >
                                <input
                                        class="white-input"
                                        type="text"
                                        placeholder="<?= isset($settings->labelSubject)?$settings->labelSubject:'' ?>"
                                        name="subject"
                                        value="<?= esc_attr($form->subject) ?>"
                                        required
                                        data-name="<?= isset($settings->labelSubject)?$settings->labelSubject:'' ?>"
                                >
                            </div>
                            <button class="btn" type="submit" name="submit">Termin sichern</button>
                            <div class="display-errors" style="color: #ff0000">
            </div>
                        </div>
                    </div>
                </li>
            </ol>
            <div class="visuallyhidden hidden send-popup-ok formSendPopup">
                <p>Ваша заявка отправлена, мы свяжемся с вами в ближайшее время</p>
                <div class="btn">Ok</div><img src="<?php bloginfo('template_url'); ?>/img/icons/blue-close.png" alt="close">
            </div>
            <div class="visuallyhidden hidden send-popup-error formSendPopup">
                <p>При отправке заявки, возникла ошибка.</p>
                <div class="btn">Ok</div><img src="<?php bloginfo('template_url'); ?>/img/icons/blue-close.png" alt="close">
            </div>
        </form>
    </div>
</section>
