$(document).ready(function() {

    var local = window.location.href.split('/');
    var idoferta = local[local.length-2];

    $('#calendar-holder').fullCalendar({

        lang: 'es',

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
        },

        buttonText:
        {
            prev:     '◄',
            next:     '►',
            prevYear: ' &lt;&lt; ',
            nextYear: ' &gt;&gt; ',
            today:    'hoy',
            month:    'mes'
        },

        /*defaultDate: '2016-09-12',*/
        editable: true,
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        eventStartEditable: false, // don't let you move the event

        viewRender: function(currentView){
            var minDate = moment(),
                maxDate = moment().add(18,'month');
            // Past
            if (minDate >= currentView.start && minDate <= currentView.end) {
                $(".fc-prev-button").prop('disabled', true).addClass('fc-state-disabled');
            }
            else {
                $(".fc-prev-button").removeClass('fc-state-disabled').prop('disabled', false);
            }
            // Future
            if (maxDate >= currentView.start && maxDate <= currentView.end) {
                $(".fc-next-button").prop('disabled', true).addClass('fc-state-disabled');
            } else {
                $(".fc-next-button").removeClass('fc-state-disabled').prop('disabled', false);
            }
        },



    eventRender: function(event, element, view) {
            // To include the price on the render
      //(event.start._i > '2017-04-07')

        //Obtener la fecha actual
       hoy = new Date().toJSON().slice(0,10);

        if ((event.ocuppate == 0) && (event.start._i > hoy)) {

            element.bind('click', function () {

                $('#ModalEdit #id').val(event.id);
                $('#ModalEdit #title').val(event.title);
                $('#ModalEdit #price').val(event.price);
                $('#ModalEdit #blocked:checked').val(event.blocked);
                $('#ModalEdit #calendar_id').val($('#calendarID').val());
                $('#ModalEdit #service_id').val($('#serviceID').val());
                $('#ModalEdit #start').val($('#startDateCalendario').val());
                $('#ModalEdit #idoffer').val($('#idoffer').val());
                $('#ModalEdit #datepicker_DatePickerto').val($('#endDate').val());




                $('#ModalEdit').modal('show');
            });

            element.find(event.price + ' €');
        }

        else {
            element.bind('click', function () {
                swal({
                    title: "¡Fecha Incorrecta!",
                    text: "¡Fecha ocupada o superior a la actual! Elija otra fecha",
                    type: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "F60"
                });
        });

        }

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
                    data: {'idOffer': idoferta},
                    success: function (doc) {

                        var events = [];

                        events = doc;

                        callback(events);


                    }
                });



        },

        //Cambiar el color si esta ocupado o no
        eventAfterRender: function (event, element, view) {

            if (event.blocked == 0) {

                if (event.ocuppate == 0) {
                    //event.color = "#FFB347"; 

                    element.css('color', '#368d3a');
                } else {
                    //event.color = "#77DD77"; //Concluído OK

                    element.css('color', '#FF0000');

                }

            }else{

                element.css('color', '#151515');
                }

        },
        loading: function(bool) {
            $('#loading').toggle(bool);
        }
    });

    function edit(event){
        
        start = event.start._i;
        price = event.price;
        calendarID = event.calendarID;
        serviceID = event.serviceID;
        blocked = event.blocked;
        end = event.end;
   

        Event = [];

        Event['start'] = start;
        Event['price'] = price;
        Event['calendar_id'] = calendarID;
        Event['service_id'] = serviceID;
        Event['idOffer'] = idoferta;
        Event['blocked'] = blocked;
        Event['end'] = end;

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
