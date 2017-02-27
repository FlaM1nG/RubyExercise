
$(document).ready(function() {
    
        
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();


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
		
		
                        dayClick: function (date, allDay, jsEvent, view) {
                                var belowDate = new Date();
                                  var targetDate = new Date();
                                    targetDate.setDate(targetDate.getDate() + 10);
                                    //cloning of date by refrence method!//console.log("mdate" + mdate);
                                    var mdate = new Date(date);
                                    if ((mdate.setHours(0, 0, 0, 0) < belowDate.setHours(0, 0, 0, 0)) || mdate.setHours(0, 0, 0, 0) > targetDate.setHours(0, 0, 0, 0)) {
                                            alert("Wrong slot of booking!!!");
                                            }
                                            else {
                                                    var start = mdate;
                                                    // please check format here as this is very small error creating headache!!
                                                    var formatedStartdate = $.fullCalendar.formatDate(mdate, 'yyyy-MM-dd hh:mm:ss');
                                                        alert(formatedStartdate);
                                                        var end = new Date(start.getTime() + 15*60000);
                                                        var formatedEnddate = $.fullCalendar.formatDate(end, 'yyyy-MM-dd hh:mm:ss');
                                                        var x = confirm("startTime" + formatedStartdate + "endTime" + formatedEnddate);
                                                            if(x){
                                                                    var eventname = prompt("Please enter event name", "");
                                                                    $.ajax({
                                                                            url: Routing.generate('updateInfo'),
                                                                            data: {endTime: formatedEnddate , startTime: formatedStartdate,ename:eventname},
                                                                            dataType: "json",
                                                                            success: function(response) {
                                                                                console.log(response);
                                                                                }
                                                                    });
                                                             }
                                                   }
                       },
        
        
		 eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',
                // A way to add custom filters to your event listeners
                data: {
                },
                error: function() {
                   //alert('There was an error while fetching Google Calendar!');
                }
            }
        ]
    });
		
		
		
	});

