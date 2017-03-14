$('#DatePicker').datepicker({
    changeMonth: true,
    changeYear: true,

    closeText: 'Cerrar',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'yy/mm/dd',


    minDate: 0,
    //The calendar is recreated OnSelect for inline calendar
    onSelect: function(date, dp) {
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
    setTimeout(function() {
        //Fill this with the data you want to insert (I use and AJAX request).  Key is day of month
        //NOTE* watch out for CSS special characters in the value
        var cellContents = {
            1: '20€',
            15: '30€',
            16: '35€',
            17: '36€',
            18: '45€',
            28: '60€'
        };

        //Select disabled days (span) for proper indexing but // apply the rule only to enabled days(a)
        $('.ui-datepicker td > *').each(function(idx, elem) {
            var value = cellContents[idx + 1] || 0;

            // dynamically create a css rule to add the contents //with the :after                         
            //             selector so we don't break the datepicker //functionality 
            var className = 'datepicker-content-' + CryptoJS.MD5(value).toString();

            if (value == 0)
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
