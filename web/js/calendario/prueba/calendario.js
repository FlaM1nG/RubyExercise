$(document).ready(function() {

    var local = window.location.href.split('/');
    var idoferta = local[local.length-2];

    $('#calendar-holder').fullCalendar({

        lang: 'es',

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },

        buttonText:
        {
            prev:     '◄',
            next:     '►',
            prevYear: ' &lt;&lt; ',
            nextYear: ' &gt;&gt; ',
            today:    'hoy',
            month:    'mes',
            week:     'semana',
            day:      'día'
        },

        /*defaultDate: '2016-09-12',*/
        editable: true,
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        eventStartEditable: false, // don't let you move the event

        eventRender: function(event, element, view) {
            // To include the price on the render

            element.bind('dblclick', function() {

                $('#ModalEdit #id').val(event.id);
                $('#ModalEdit #title').val(event.title);
                $('#ModalEdit #price').val(event.price);
                $('#ModalEdit #calendar_id').val($('#calendarID').val());
                $('#ModalEdit #service_id').val($('#serviceID').val());
                $('#ModalEdit #start').val($('#startDateCalendario').val());


                $('#ModalEdit').modal('show');
            });

            element.find(event.price + ' €');
        },

        eventClick: function(calEvent, jsEvent, view) {

            $('#startDateCalendario').val(calEvent.start._i);
          
        },
        eventDrop: function(event, delta, revertFunc) { // si changement de position

            edit(event);

        },
        eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

            edit(event);

        },

        events: function(start, end, timezone, callback) {
            $.ajax({
                url: Routing.generate('fullcalendar_calendar'),
                dataType: 'json',
                type: 'post',
                data: {'idOffer' : idoferta},
                success: function(doc) {
                 
                    var events = [];
                 
                    events = doc;
                    callback(events);
                }
            });
        }
        ,
        loading: function(bool) {
            $('#loading').toggle(bool);
        }
    });

    function edit(event){
        
        start = event.start._i;
        price = event.price;
        calendarID = event.calendarID;
        serviceID = event.serviceID;

        Event = [];

        Event['start'] = start;
        Event['price'] = price;
        Event['calendar_id'] = calendarID;
        Event['service_id'] = serviceID;
        Event['idOffer'] = idoferta;

        $.ajax({
            url: Routing.generate('fullcalendar_edit_create'),
            type: "POST",
            data: {Event:Event},
            success: function(rep) {
                if(rep == 'OK'){
                    alert('Saved');
                }else{
                    alert('Could not be saved. try again.');
                }
            }
        });
    }

});/**
 * Created by Carlos on 23/03/2017.
 */
