


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
        eventStartEditable: false, // para que no se muevan los eventos



        eventRender: function(event, element, view) {
            // To include the price on the render

            element.bind('dblclick', function() {

                $('#ModalEdit #id').val(event.id);
                $('#ModalEdit #title').val(event.title);
                $('#ModalEdit #price').val(event.price);
                //$('#ModalEdit #calendar_id').val(event.calendar_id);
                //$('#ModalEdit #service_id').val(event.service_id);
                $('#ModalEdit #calendar_id').val($('#calendarID').val());
                $('#ModalEdit #service_id').val($('#serviceID').val());
                $('#ModalEdit #start').val($('#startDateCalendario').val());


                $('#ModalEdit').modal('show');
            });

            element.find(event.price + ' €');
        },

        eventClick: function(calEvent, jsEvent, view) {

            $('#startDateCalendario').val(calEvent.start._i);
            /*$('#ModalEdit #id').val(event.id);
            $('#ModalEdit #title').val(event.title);
            $('#ModalEdit #price').val(calEvent.price);
            $('#ModalEdit #calendar_id').val(calEvent.calendarID);
            $('#ModalEdit #service_id').val(calEvent.serviceID);


            $('#ModalEdit').modal('show');*/

            //console.log(calEvent.start._i);
            //edit(calEvent,  idoferta);
          
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
                data: {

                    'idOffer' : idoferta
                    // our hypothetical feed requires UNIX timestamps
                    //start: start.unix(),
                    //end: end.unix()
                },
                success: function(doc) {
                    console.log(doc);
                    var events = [];
                    /*$(doc).find('event').each(function() {
                     events.push({
                     title: $(this).attr('title'),
                     start: $(this).attr('start') // will be parsed
                     });
                     });*/
                    events = doc;
                    callback(events);
                }
            });
        }
        /*events: {
         url: 'php/get-events.php',
         error: function() {
         $('#script-warning').show();
         }

         $.ajax({ 
         url: '/calendario/mygetevents.php',
         data: {},
         type: 'post',
         success: function(data) {
         //var totalPrice = jQuery.parseJSON(data);
         //$('#precioTotal').text(totalPrice);
         }
         });

         }*/,
        loading: function(bool) {
            $('#loading').toggle(bool);
        }
    });

    function edit(event){

        console.log(event.start._i);
        /*
        start = event.start.format('YYYY-MM-DD HH:mm:ss');

        if(event.end){
            end = event.end.format('YYYY-MM-DD HH:mm:ss');
        }else{
            end = start;
        }
*/
      //  id =  event.id;
        start = event.start._i;
        price = event.price;
        calendarID = event.calendarID;
        serviceID = event.serviceID;

        Event = [];
      //  Event[0] = id;
        Event['start'] = start;
       // Event[2] = end;
        Event['price'] = price;
        Event['calendar_id'] = calendarID;
        Event['service_id'] = serviceID;
        Event['idOffer'] = idoferta;

        $.ajax({
            url: Routing.generate('fullcalendar_edit'),
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
