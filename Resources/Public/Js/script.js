
function openDoor(field, DoorNr) {

	jQuery(field).addClass("tx_Advent_questions_dayOpened") ;
	jQuery(field).removeClass("tx_Advent_questions_closed") ;
	jQuery(field).children().fadeOut('fast') ;
	jQuery(field).css("cursor" ,"wait") ;
	tx_quizSeite(field, DoorNr);
}

function tx_quizSeite(field, DoorNr) {
	var url= window.location.protocol  + "//" + window.location.hostname +  jQuery('#tx_advent_answerpage').attr('href') ;
	window.location.href = (url + DoorNr);
}

function tx_nemadvent_ajax( syslng , sysid ) {
	jQuery.ajax({
		type: "GET",
		url: "/index.php",
		cache: false,
		data: "id=" + sysid + "&L=" + syslng + "&tx_nemadvent_pi1[JSON]=1",
		beforeSend: function() {
		},
		success: function(result) {
			// console.log(result);
			var resultArray = result.split(",");

			// console.info(resultArray);

			for (var i = 0; i<resultArray.length; i++ ) {
				if ( resultArray[i] > 0 ) {
					// console.info(resultArray[i]);
					jQuery(".tx_Advent_questions_day" + resultArray[i] + " ").removeClass("tx_Advent_questions_closed") ;
					jQuery(".tx_Advent_questions_day" + resultArray[i] + " ").addClass("tx_Advent_questions_dayOpened") ;
				}
			}
		}
	});
}




