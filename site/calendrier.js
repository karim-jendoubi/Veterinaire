
        $(document).ready(function() {
            moment.locale('fr'); // Définit la locale en français
            var calendar = $('#calendar').fullCalendar({
                selectable: true,
                select: function(start, end) {
                    $('#eventForm').show();
                }
            });
	    
            $('#addEvent').click(function() {
                var eventName = $('#eventName').val();
                var eventDate = moment($('#eventDate').val()).toDate();

                if (eventName && eventDate) {
                    calendar.fullCalendar('renderEvent', {
                        title: eventName,
                        start: eventDate,
                        allDay: false
                    });

                    resetForm();

                    // Vérifier régulièrement si l'événement est atteint
                    var timer = setInterval(function() {
                        var now = moment();
                        if (now.isSame(eventDate, 'minute')) {
                            clearInterval(timer);
                            window.alert('L\'événement "' + eventName + '" commence maintenant !');
                        }
                    }, 1000 * 1); // Vérifie toutes les 1 secondes (1 * 1000 millisecondes)

                } else {
                    alert('Veuillez remplir tous les champs.');
                }
            });

            function resetForm() {
                $('#eventName').val('');
                $('#eventDate').val('');
            }
        });
