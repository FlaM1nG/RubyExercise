
var cellContents;

$(document).ready(function() {

    // We get the list of days and prices
    $.ajax({
        url: Routing.generate('fullcalendar_datepick'),
        data: {},
        type: 'post',
        success: function(data) {

            cellContents = jQuery.parseJSON(data);


        }
    });

    $('#DatePicker').datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        //The calendar is recreated OnSelect for inline calendar
        onSelect: function (date, dp) {
            updateDatePickerCells();
        },
        onChangeMonthYear: function(month, year, dp) {
            updateDatePickerCells();
        },
        beforeShow: function(elem, dp) { //This is for non-inline datepicker
            updateDatePickerCells();
        }
    });
    updateDatePickerCells();
    function updateDatePickerCells(dp) {

        /* Wait until current callstack is finished so the datepicker
         is fully rendered before attempting to modify contents */
        setTimeout(function () {
            //Fill this with the data you want to insert (I use and AJAX request).  Key is day of month
            //NOTE* watch out for CSS special characters in the value

            //var cellContents = {1: '20', 15: '60', 20: '450€', 28: '99.99€'};

            //Select disabled days (span) for proper indexing but // apply the rule only to enabled days(a)
            $('.ui-datepicker td > *').each(function (idx, elem) {

                var value = cellContents[idx + 1] || 0;

                // dynamically create a css rule to add the contents //with the :after
                //             selector so we don't break the datepicker //functionality
                var className = 'datepicker-content-' + value.toString(); // + CryptoJS.MD5(value).toString();

                if(value == 0)
                    addCSSRule('.ui-datepicker td a.' + className + ':after {content: "\\a0";}'); //&nbsp;
                else
                    addCSSRule('.ui-datepicker td a.' + className + ':after {content: "' + value + '";}');

                $(this).addClass(className);
            });

        }, 0);
    }
    var dynamicCSSRules = [];
    function addCSSRule(rule) {
        if ($.inArray(rule, dynamicCSSRules) == -1) {
            $('head').append('<style>' + rule + '</style>');
            dynamicCSSRules.push(rule);
        }
    }

});