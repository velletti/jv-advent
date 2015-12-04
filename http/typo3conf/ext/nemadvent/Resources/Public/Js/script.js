function openDoor_today(field, DoorNr) {
	console.info(DoorNr);

	jQuery(field).removeClass("tx_Advent_questions_day");

	var y = jQuery(field).find(".tx_Advent_questions_today");
	var z = jQuery(field).find(".tx_advent_no_accessMsg");
	var x = y.attr("class");

	if (y.hasClass("tx_Advent_questions_today_Opened")) {
		tx_quizSeite(field, DoorNr);
	}  else {
		z.addClass("tx_advent_no_accessMsg_opened");
		y.addClass("tx_Advent_questions_today_Opened");
	}

}


function openDoor(field, DoorNr) {
	jQuery(field).removeClass("tx_Advent_questions_day");
	var y = jQuery(field).find(".tx_Advent_questions_dayBefore");
	var x = y.attr("class");
	var z = jQuery(field).find(".tx_advent_no_accessMsg");
	var msg= jQuery('#tx_advent_no_accessMsg').html() ;
	// jQuery(".tx_Advent_questions_day"+DoorNr).html('<p><b> ' + msg + ' </b></p>' + jQuery(".tx_Advent_questions_day"+DoorNr).html());
	if (y.hasClass("tx_Advent_questions_dayBefore_Opened")) {
		tx_quizSeite(field, DoorNr);
	}  else{
		y.addClass("tx_Advent_questions_dayBefore_Opened");
		z.addClass("tx_advent_no_accessMsg_opened");

	}
}

function tx_quizSeite(field, DoorNr) {
	var url= "https://" + window.location.hostname + "/" + jQuery('#tx_advent_answerpage').attr('href') ;
	var msg= jQuery('.tx_advent_no_accessMsg p') ;
	if ( msg.hasClass('noaccess') ) {
		alert( msg.html() ) ;
	} else {

		window.location.href = (url + DoorNr);
	}

}

function tx_nemadvent_ajax( syslng , sysid ) {
	jQuery.ajax({
		type: "GET",
		url: "index.php",
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
					jQuery(".tx_Advent_questions_day" + resultArray[i]).html("");
					jQuery(".tx_Advent_questions_day" + resultArray[i]).attr("onclick", "tx_quizSeite(this, " + resultArray[i] + ')');
					jQuery(".tx_Advent_questions_day" + resultArray[i]).append( '<div class="tx_Advent_questions_dayOpen"></div><div class="tx_Advent_questions_dayOpen_2"> </div>')
						.removeClass("tx_Advent_questions_day")
						.addClass("tx_Advent_questions_dayOpened")
						.removeClass("tx_Advent_questions_inactive")
					//.append("<div id="tx_Advent_open_question"><p></p></div>")
				}
			}
		}
	});
}




