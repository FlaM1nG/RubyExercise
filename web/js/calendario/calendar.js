
$(document).ready(function() {
    
        
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var local = window.location.href.split('/');
    var idoferta = local[local.length-2];


		$('#calendar-holder').fullCalendar({

                       
                       lang: 'es',
                       
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
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

			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
            disableDragging: true,

            select: function(start, end) {

                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                element.bind('dblclick', function() {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #price').val(event.price);
                    $('#ModalEdit #calendar_id').val(event.calendar_id);
                    $('#ModalEdit #service_id').val(event.service_id);

                    element.draggable = true;

                   
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function(event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                edit(event);

            },

            eventDataTransform: function(event) {
                if(event.allDay) {
                    event.end = moment(event.end).add(1, 'days')
                }
                return event;
            },

            eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',
                // A way to add custom filters to your event listeners
                data: {'idOffer' : idoferta
                },
                error: function() {
                   //alert('There was an error while fetching Google Calendar!');
                }
            }
        ]
    });
    function edit(event){
        start = event.start.format('YYYY-MM-DD HH:mm:ss');
        if(event.end){
            end = event.end.format('YYYY-MM-DD HH:mm:ss');
        }else{
            end = start;
        }

        id =  event.id;
        price = event.price;
        calendarID = event.calendarID;
        serviceID = event.serviceID;

        Event = [];
        Event[0] = id;
        Event[1] = start;
        Event[2] = end;
        Event[3] = price;
        Event[4] = calendarID;
        Event[5] = serviceID;

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


		
		
	});

