
function openDoor(field, DoorNr) {

	jQuery(field).addClass("tx_jvadvent_questions_dayOpened") ;
	jQuery(field).removeClass("tx_jvadvent_questions_closed") ;
	jQuery(field).children().fadeOut('fast') ;
	jQuery(field).css("cursor" ,"wait") ;
	tx_quizSeite(field, DoorNr);
}

function tx_quizSeite(field, DoorNr) {
	var url= jQuery('#tx_jvadvent_answerpage').attr('href') ;
	if ( url.indexOf('http') < 0 ) {
		if ( url.indexOf('/') == 0 ) {
			url= window.location.protocol  + "//" + window.location.hostname +  url ;
		} else {
			url= window.location.protocol  + "//" + window.location.hostname + "/" + url ;
		}
	}
	// now replace .html with /day/<doornr>.html

	url= url.replace('.html' , '/day/' + DoorNr + '.html' ) ;
	window.location.href = (url + DoorNr);
}

function tx_jvadvent_ajax( syslng , sysid ) {
	jQuery.ajax({
		type: "GET",
		url: "/index.php",
		cache: false,
		data: "id=" + sysid + "&L=" + syslng + "&tx_jvadvent_user[Controler]=User&tx_jvadvent_user[Action]=answer&tx_jvadvent_user[JSON]=1&rnd=" + Math.random(),
		beforeSend: function() {
		},
		success: function(result) {
			var resultArray = result.split(",");

			for (var i = 0; i<resultArray.length; i++ ) {
				if ( resultArray[i] > 0 ) {
					jQuery(".tx_jvadvent_questions_day" + resultArray[i] + " ").removeClass("tx_jvadvent_questions_closed") ;
					jQuery(".tx_jvadvent_questions_day" + resultArray[i] + " P").removeClass("tx_jvadvent_questions_inactive_background") ;
					jQuery(".tx_jvadvent_questions_day" + resultArray[i] + " ").addClass("tx_jvadvent_questions_dayOpened") ;
				}
			}
		}
	});
}




