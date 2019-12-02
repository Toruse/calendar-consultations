jQuery(function() {
    function findCurrentDate(objThis) {
        return jQuery(objThis).find('.xdsoft_calendar .xdsoft_date.xdsoft_disabled.xdsoft_current').length!=0;
    }

    function findCurrentTime(objThis) {
        return jQuery(objThis).find('.xdsoft_time_variant .xdsoft_time.xdsoft_disabled.xdsoft_current').length!=0;
    }

    function clearTextTime(form) {
        form.find('span[data-model="date"]').text('');
        form.find('span[data-model="time"]').text('');
        form.find('.xdsoft_timepicker .xdsoft_time_title').text('Zeit');
    }

    function disableDates(objThis, current) {
        var form = jQuery(objThis).closest('form');
        var dates = form.find('input[name="dates"]').val();
        if (dates) dates = JSON.parse(dates);

        var settings = form.find('input[name="settings"]').val();
        if (settings) settings = JSON.parse(settings);

        var disabledDates = [];
        for (key in dates) {
            if (dates[key].disable) disabledDates.push(key);
        }

        objThis.setOptions({
            disabledDates: disabledDates.concat(settings.disabledDates),
            formatDate:'d.m.Y',
        });

        objThis.setOptions({
            disabledWeekDays: settings.dayWeekend,
            minTime: settings.hours[current.getDay()][0],
            maxTime: settings.hours[current.getDay()][1],
        });
    }

    var deMonths = [
        'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'
    ];

    jQuery.datetimepicker.setLocale('de');
    jQuery('.calendar-consultations-datetimepicker').datetimepicker({
        format:'d.m.Y H:i',
        inline:true,
        lang: 'de',
        minDate: 0,
        todayButton: false,
        dayOfWeekStart: 1,
        defaultDate: false,
        defaultSelect: false,
        onSelectDate : function(current, $input){
            // console.log('onSelectDate', current, $input);
        },
        onSelectTime : function(current, $input){
            // console.log('onSelectTime');
        },
        onChangeMonth : function(current, $input){
            // console.log('onChangeMonth', current, $input)
        },
        onChangeYear : function(current, $input){
            // console.log('onChangeYear', current, $input)
        },
        onChangeDateTime : function(current, $input){
            disableDates(this, current);
            // console.log('onChangeDateTime', current, $input)
        },
        onShow : function(current, $input){
            // console.log('onShow', current, $input)
        },
        onClose : function(current, $input){
            // console.log('onClose', current, $input)
        },
        onGenerate : function(current, $input){
            var form = jQuery(this).closest('form');

            var dates = form.find('input[name="dates"]').val();
            if (dates) dates = JSON.parse(dates);

            var settings = form.find('input[name="settings"]').val();
            if (settings) settings = JSON.parse(settings);

            var date = $input.val().split(' ')[0];

            if (
                (date && !(typeof dates[date] != "undefined" && dates[date].disable))
                && settings.disabledDates.indexOf(date) == -1
                && !findCurrentDate(this)
                && (typeof this.flagInit != "undefined" && this.flagInit)
            ) {
                form.find('span[data-model="date"]').text(current.getDate()+'. '+deMonths[current.getMonth()]+'.');
                form.find('span[data-model="time"]').text(current.getHours()+':00');
                jQuery(this).find('.xdsoft_timepicker .xdsoft_time_title').text(current.getHours()+':00');
            }

            jQuery(this).find('.xdsoft_time_variant .xdsoft_time').removeClass('xdsoft_disabled');
            if (dates[date]) {
                var times = dates[date]['time'];
                for (var key in times) {
                    var hour = parseInt(times[key].split(':')[0]);
                   jQuery(this).find('.xdsoft_time_variant .xdsoft_time[data-hour="'+hour+'"][data-minute="0"]').addClass('xdsoft_disabled');
                }
            }

            if (findCurrentDate(this)) {
                jQuery(this).find('.xdsoft_time_variant .xdsoft_time').addClass('xdsoft_disabled');
                jQuery(this).find('.xdsoft_time_variant .xdsoft_time').removeClass('xdsoft_current');
                $input.val('');
                clearTextTime(form);
            }

            if (findCurrentTime(this)) {
                jQuery(this).find('.xdsoft_calendar .xdsoft_date').removeClass('xdsoft_current');
                jQuery(this).find('.xdsoft_time_variant .xdsoft_time').removeClass('xdsoft_current');
                $input.val('');
                clearTextTime(form);
            }

            var that = this;
            settings.disabledTimes.forEach(function(item) {
                var time = item.split(':');
                jQuery(that).find('.xdsoft_time_variant .xdsoft_time[data-hour="'+parseInt(time[0])+'"][data-minute="'+parseInt(time[1])+'"]').addClass('xdsoft_disabled');
            });

            if (typeof this.flagInit == "undefined") {
                disableDates(this, current);
                $input.val('');

                jQuery(this).find('.xdsoft_timepicker').prepend('<div class="xdsoft_time_title">Zeit</div>');

                this.flagInit = true;
            }
        }
    });

    jQuery(document).on("submit", ".calendar-consultations-form", function (e) {
        e.preventDefault();
        var form = jQuery(this);
        var formData = form.serializeArray();

        formData.push({
            name: 'action',
            value: form.attr("action")
        });

        form.find('button[type="submit"]').attr("disabled", true);

        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: form.attr("method"),
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'ok') {
                    var popup = form.find('.send-popup-ok');
                    popup.removeClass('hidden');
                    setTimeout(function () {
                        popup.removeClass('visuallyhidden');
                    }, 20);
                    form.trigger("reset");
                    jQuery('.calendar-consultations-datetimepicker').datetimepicker('reset');
                    form.find('input[name="dates"]').val(response.dates);
                    form.find('span[data-model="date"]').text('');
                    form.find('span[data-model="time"]').text('');
                    form.find('.xdsoft_timepicker .xdsoft_time_title').text('Zeit');
                }

                if (response.status == 'error') {
                    var popup = form.find('.send-popup-error');
                    popup.removeClass('hidden');
                    setTimeout(function () {
                        popup.removeClass('visuallyhidden');
                    }, 20);
                    form.trigger("reset");
                    jQuery('.calendar-consultations-datetimepicker').datetimepicker('reset');
                }

                form.find('button[type="submit"]').removeAttr("disabled");
            },
            error: function () {
            }
        });
    });

    jQuery(".calendar-consultations-form").validate({
        lang: 'de',
        errorContainer: '.display-errors',
        errorElement: 'p',
        ignore: '[name="csrf"], [name="_wp_http_referer"], [name="dates"], [name="settings"]',
        rules: {
            typeMeeting: "required",
            date: "required",
            title: "required",
            name: "required",
            phone: {
                number: true,
                minlength:12,
                maxlength:13
            },
            thema: "required",
            email_skype: {
                required: true,
                // email: true
            },
            subject: "required"
        },
        showErrors: function(errorMap, errorList) {
            var html = '';
            for (key in errorMap) {
                html+="<p>"+$(this.currentForm).find('[name="'+key+'"]').attr('data-name')+': '+errorMap[key]+"</p>";
            }
            $(this.containers).html(html);
        },
    });

    jQuery('.formSendPopup.send-popup-ok .btn, .formSendPopup.send-popup-ok img[alt="close"], .formSendPopup.send-popup-error .btn, .formSendPopup.send-popup-error img[alt="close"]').on('click', function () {
        var popup = jQuery(this).closest('.formSendPopup');
        popup.addClass('visuallyhidden');
        popup.one('transitionend', function (e) {
            popup.addClass('hidden');
        });
    });
});