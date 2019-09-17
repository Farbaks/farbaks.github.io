$(document).ready(function() {
	getcity('depart');
});

function getcity(n) {
	if (n == "depart") {
		var departcity = $('#depart-city').val();
		$.ajax({
	        url: 'api/flights/getcity',
	        dataType: 'json',
	        type: 'post',
	        data: {
	        },
	        success: function(data) {
	        	// console.log(data);
	        	var template = '';
	        	for (var i = 0; i <= data.name.length; i++) {
	        		var cell1 = data.name[i];
	        		var cell2 = data.code[i];
	        		template += `<option id = "${cell2}">${cell1}</option>`;
	        	}
	        	$('#departcity').html(template);
	        }
	    });
	}
	else if (n == "arrive") {
		var arrivecity = $('#arrive-city').val();
		var homePopup = $('#loading').bPopup({closeClass:'cancel', modalClose:false});
		$.ajax({
	        url: 'api/flights/getcity',
	        dataType: 'json',
	        type: 'post',
	        data: {
	        },
	        success: function(data) {
	        	// console.log(data);
	        	homePopup.close();
	        	var template = '';
	        	for (var i = 0; i <= data.name.length; i++) {
	        		var cell1 = data.name[i];
	        		var cell2 = data.code[i];
	        		template += `<option id = "${cell2}">${cell1}</option>`;
	        	}
	        	$('#arrivecity').html(template);
	        }
	    });
	}

}
function searchflights() {
	var string = location.search;
	var departcity = $('#departcity').val();
	var arrivecity = $('#arrivecity').val();
	var departdate = $('#depart-date').val();
	var arrivedate = $('#arrive-date').val();
	var cabin = $('#cabin').val();
	var adult = $('#adult').val();
	var children = $('#children').val();
	var infants = $('#infants').val();
	if (
			departcity == '' ||
			arrivecity == '' ||
			departdate == '' ||
			arrivedate == '' ||
			cabin == '' ||
			adult == '' ||
			children == '' ||
			infants == '' 
		) {
		$('#error').html("Please fill in all fields");
	}
	else {
		var homePopup = $('#loading').bPopup({closeClass:'cancel', modalClose:false});
		$.ajax({
	        url: 'api/flights/search',
	        dataType: 'json',
	        type: 'post',
	        data: {
	        	departcity: $('#departcity').val(),
				arrivecity: $('#arrivecity').val(),
				departdate: $('#depart-date').val(),
				arrivedate: $('#arrive-date').val(),
				cabin: $('#cabin').val(),
				adult: $('#adult').val(),
				children: $('#children').val(),
				infants: $('#infants').val()
	        },
	        success: function(data) {
	        	// console.log(data);
	          	homePopup.close();
	          	if (data.message != "The data entered is valid") {
	            	$('#error').html(data.message);
	          	}
	          	else {
		            $('#error').html(" ");
		            $('#successnotification').html(data.message);
		            openmodal();
		            setTimeout(function(){
		              closemodal();
		            }, 5000);
		            setTimeout(function(){
		              $('#success-message').html('');
		            }, 1000);
		            url = "flightsearchresult?departcity="+data.departcity+"&arrivecity="+data.arrivecity+"&departdate="+departdate+"&arrivedate="+arrivedate+"&cabin="+cabin+"&adult="+adult+"&children="+children+"&infants="+infants;
		            setTimeout(function(){
		              location.assign(url);
		            }, 1000);
	          	}
	        }
	    });
	}
}

function closemodal() {
	$('#success-modal').css('top', '-66px');
	setTimeout(function() {$('#success-modal').css('display', 'none');}, 1000);
}
function openmodal() {
	$('#success-modal').css('display', 'flex');
	$('#success-modal').css('top', '100px');
}