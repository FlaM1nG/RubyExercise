var cellContents;
var monthNumber = '';
var local = window.location.href.split('/');
var idoferta = local[local.length-2];
var totalPrice;
$(document).ready(function() {

    // We get the list of days and prices
    $.ajax({
        url: Routing.generate('fullcalendar_datepick'),
        data: {'idOffer' : idoferta},
        type: 'post',
        success: function(data) {
            cellContents = data;
        }
    });

 
    $('#datepicker_DatePicker').datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        dateFormat: 'dd-mm-yy',
        maxDate: "+2Y",
        //The calendar is recreated OnSelect for inline calendar
        onSelect: function (selectedDate,date, dp) {
            updateDatePickerCells();

            $("#datepicker_DatePickerto").datepicker("option", "minDate", selectedDate);

            var initDate = $('#datepicker_DatePicker').datepicker({ dateFormat: 'dd-mm-yy' }).val();
            var endDate = $('#datepicker_endDate').val();

            // We store the initial date in a hidden input
            $('#datepicker_startDate').val(initDate);

            // To show the initial date on the view
            $('#datepicker_fechaInicial').text(initDate);

            $.ajax({
                url: Routing.generate('fullcalendar_dateprice'),
                data: {'initDate' : initDate, 'endDate' : endDate,'idOffer' : idoferta},
                type: 'post',
                success: function(data) {
                    totalPrice = data;
                    $('#datepicker_precioTotal').text(totalPrice);
                }
            }); 

        },
        onChangeMonthYear: function(month, year, dp) {
            updateDatePickerCells();
        },
        beforeShow: function(elem, dp) { //This is for non-inline datepicker
            updateDatePickerCells();
        }
    });

    $('#datepicker_DatePickerto').datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        dateFormat: 'dd-mm-yy',
        maxDate: "+2Y",
        //The calendar is recreated OnSelect for inline calendar
        onSelect: function (selectedDate,date, dp) {
            updateDatePickerCells();

            $("#datepicker_DatePicker").datepicker("option", "maxDate", selectedDate);

            var endDate = $('#datepicker_DatePickerto').datepicker({ dateFormat: 'dd-mm-yy' }).val();
            var initDate = $('#datepicker_startDate').val();

            // We store the initial date in a hidden input
            $('#datepicker_endDate').val(endDate);

            // To show the end date on the view
            $('#datepicker_fechaFinal').text(endDate);

            $.ajax({
                url: Routing.generate('fullcalendar_dateprice'),
                data: {'initDate' : initDate, 'endDate' : endDate,'idOffer' : idoferta},
                type: 'post',
                success: function(data) {
                    totalPrice = data;
                    $('#datepicker_precioTotal').text(totalPrice);

                }
            });
        },
        onChangeMonthYear: function(month, year, dp) {
            updateDatePickerCells();
        },
        beforeShow: function(elem, dp) { //This is for non-inline datepicker
            updateDatePickerCells();
        }
    });
    
    updateDatePickerCells();

    $(function($){
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });

    function updateDatePickerCells(dp) {

        /* Wait until current callstack is finished so the datepicker
         is fully rendered before attempting to modify contents */
        setTimeout(function () {
            // We set on each '<a>' tag the month number
            $('.ui-datepicker a').each(function () {
                monthNumber = $(this).parent().data('month');
                $(this).addClass('month-' + monthNumber);
                $(this).attr("data-current-month", monthNumber);
            });

            // We have to do a foreach per each year
            $.each(cellContents, function (indexYear, yearCell) {

            // We have to do a foreach per each month
                $.each(yearCell, function (index, valueCell) {

                //Select disabled days (span) for proper indexing but // apply the rule only to enabled days(a)
                $('.ui-datepicker td > *').each(function (idx, elem) {

                    var value = valueCell['precio'][idx + 1] || 0;
                    var value2 = valueCell['ocuppate'][idx + 1] || 0;
                    var value3 = valueCell['blocked'][idx + 1] || 0;

                    // If the year data is the same one that is shown on the view
                    if (indexYear == $('.ui-datepicker td a').parent().data('year')) {

                        // If the month data is the same one that is shown on the view we include the price
                        if (index - 1 == $('.ui-datepicker td a').data('current-month')) {

                            // dynamically create a css rule to add the contents //with the :after
                            // selector so we don't break the datepicker //functionality
                            var className = 'datepicker-content-' + value.toString(); // + CryptoJS.MD5(value).toString();

                            if (value == 0) {
                                addCSSRule('.ui-datepicker td a.' + className + ':after {content: "\\a0";}'); //&nbsp;
                            } else {


                                if (value2 == 1 || value3 == 1 ) {
                                    // To deactivate the ocuppated days and blocked days
                                    $(elem).parent().addClass('ui-state-disabled ui-datepicker-unselectable');

                                    // To set the color on the price
                                    //  addCSSRule('.ui-datepicker td a.' + className + ':after {color: red;}');
                                } else {
                                    addCSSRule('.ui-datepicker td a.' + className + ':after {content: "' + value + '"; color: green;}');
                                }
                            }

                            $(this).addClass(className);
                        }

                    }
                });

              });

            });

                // To deactivate dates without price
            $('.ui-datepicker .datepicker-content-0').each(function (idx, elem) {
                $(elem).parent().addClass('ui-state-disabled ui-datepicker-unselectable');
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

/*

 if(value == 0) {
 addCSSRule('.ui-datepicker td a.' + className + ':after {content: "\\a0";}'); //&nbsp;
 } else {
 addCSSRule('.ui-datepicker td a.' + className + ':after {content: "' + value + '";}');

 if (value2 == 1) {
 // To deactivate the ocuppated days
 $(elem).parent().addClass('ui-state-disabled ui-datepicker-unselectable');

 // To set the color on the price
 addCSSRule('.ui-datepicker td a.' + className + ':after {color: red;}');
 } else {
 addCSSRule('.ui-datepicker td a.' + className + ':after {color: green;}');
 }
 }

 */

