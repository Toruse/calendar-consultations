<?php

?>

<div class="wrap">
    <h2><?= get_admin_page_title() ?></h2><br>
    <form method="post" action="options.php">
        <?php settings_fields( $this->group ); ?>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Calendar</a></li>
                <li><a href="#tabs-2">Customize Form</a></li>
                <li><a href="#tabs-3">E-mail Templates</a></li>
            </ul>
            <div id="tabs-1">
                <fieldset>
                    <legend>Working hours:</legend>
                    <?php do_settings_sections( $this->group.'_tab_1_block_1'); ?>
                </fieldset>
                <hr>
                <fieldset>
                    <?php do_settings_sections( $this->group.'_tab_1_block_2'); ?>
                </fieldset>
            </div>
            <div id="tabs-2">
                <fieldset>
                    <?php do_settings_sections( $this->group.'_tab_2_block_1'); ?>
                </fieldset>
                <fieldset>
                    <legend>Form field names:</legend>
                    <?php do_settings_sections( $this->group.'_tab_2_block_2'); ?>
                </fieldset>
            </div>
            <div id="tabs-3">
                <?php do_settings_sections( $this->group.'_tab_3'); ?>
            </div>
        </div>
        <?php submit_button(); ?>
    </form>
</div>

