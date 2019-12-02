jQuery(function() {
    jQuery.datetimepicker.setLocale('en');
    jQuery('input[name="organize_consult[date]"]').datetimepicker({
        format:'d.m.Y H:i',
        inline:true,
        lang: 'en',
        todayButton: false,
        dayOfWeekStart: 1,
    });
});