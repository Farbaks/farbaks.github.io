$(document).ready(function() {
	getcity('depart');
	getcity('arrive');
	
	setTimeout(function(){
      searchresult();
    }, 1000);

});



function searchresult() {
	var homePopup = $('#loading').bPopup({closeClass:'cancel', modalClose:false});
	var parameters = new URLSearchParams(window.location.search);

	var departcity = parameters.get('departcity');
	var arrivecity = parameters.get('arrivecity');
	var departdate = parameters.get('departdate');
	var arrivedate = parameters.get('arrivedate');
	var cabin1 = parameters.get('cabin');
	var adult = parameters.get('adult');
	var children = parameters.get('children');
	var infants = parameters.get('infants');
	$.ajax({
        url: 'api/flights/searchresult',
        dataType: 'json',
        type: 'post',
        data: {
        	departcity: departcity,
			arrivecity: arrivecity,
			departdate: departdate,
			arrivedate: arrivedate,
			cabin: cabin1,
			adult: adult,
			children: children,
			infants: infants
        },
        success: function(data) {
        	// // console.log(data);
        	// // console.log(data[0].airline);	
          	document.cookie = "cookie="+data[data.length-1].cookies;

          	$('#'+departcity+"1").attr('selected', 'selected');	
          	$('#'+arrivecity+"2").attr('selected', 'selected');	
          	$('#'+cabin1).attr('selected', 'selected');
          	$('#departdate').val(departdate);
          	$('#arrivedate').val(arrivedate);
          	$('#cabin').val(cabin1);
          	$('#adult').val(adult);	
          	$('#child').val(children);	
          	$('#infants').val(infants);	
          	$('#content-1').css('display', 'block');
          	var template = "";
          	$('#content-2').html('');	

          	// // console.log(data[2].airline);
          	// // console.log(data.length);
          	if (data[data.length-1].message == "flights available" && data.length >= 2) {
          		for(var j = 0; j < data.length-1; j++) {

	            	var airline = data[j].airline;	
	            	var price = data[j].price;
	            	var cabin = data[j].cabin;

	            	// console.log(data[j].To['left']);
	            	var toDate1 = data[j].To.left.date;

	            	var toTime1 = data[j].To.left.time;
	            	var toCity1 = data[j].To.left.city;
	            	var toDate2 = data[j].To.right.date;
	            	var toTime2 = data[j].To.right.time;
	            	var toCity2 = data[j].To.right.city;
	            	var froDate1 = data[j].fro.left.date;
	            	var froTime1 = data[j].fro.left.time;
	            	var froCity1 = data[j].fro.left.city;
	            	var froDate2 = data[j].fro.right.date;
	            	var froTime2 = data[j].fro.right.time;
	            	var froCity2 = data[j].fro.right.city;

		           	template +=	`<div class="content-2-item fullwidth">
									<div class="detail fullwidth">
										<div class="">
											<p>${airline}</p>
										</div>
										<div class="detail-1 fullwidth">
											<div class="detail-3 threequarterwidth">
												<div class="detail-2 fullwidth">
													<div class="">
														<h2 class="time">${toTime1}</h2>
														<p class="city">${toCity1}</p>
														<p class="day">${toDate1}</p>
													</div>
													<div class="to">
														
													</div>
													<div class=" ">
														<h2 class="time">${toTime2}</h2>
														<p class="city">${toCity2}</p>
														<p class="day">${toDate2}</p>
													</div>
												</div>
												<div class="detail-2 fullwidth">
													<div class="">
														<h2 class="time">${froTime1}</h2>
														<p class="city">${froCity1}</p>
														<p class="day">${froDate1}</p>
													</div>
													<div class="to">
														
													</div>
													<div class=" ">
														<h2 class="time">${froTime2}</h2>
														<p class="city">${froCity2}</p>
														<p class="day">${froDate2}</p>
													</div>
												</div>
											</div>
											<div class="book onequarterwidth">
												<h2 class="price"> ₦ ${price}</h2>
												<p class="day">${cabin}</p>
												<button>BOOK</button>
											</div>
										</div>
									</div>
								</div>`;
					// console.log(airline);	

				} 
				// console.log(template);
				$('#content-2').html(template);	
          	}
	        else if (data.length < 2) {

	        	$('#content-2').css('display', 'none');
	        	$('#content-3').css('display', 'flex');
	        	$('#message').html("No flights available...");
	        } 
	        homePopup.close();  
        }
    });
}

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
	        	// // console.log(data);
	        	var template = '';
	        	for (var i = 0; i <= data.name.length; i++) {
	        		var cell1 = data.name[i];
	        		var cell2 = data.code[i];
	        		template += `<option id = "${cell2}1">${cell1}</option>`;
	        	}
	        	$('#depart-city').html(template);
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
	        	// // console.log(data);
	        	homePopup.close();
	        	var template = '';
	        	for (var i = 0; i <= data.name.length; i++) {
	        		var cell1 = data.name[i];
	        		var cell2 = data.code[i];
	        		template += `<option id = "${cell2}2">${cell1}</option>`;
	        	}
	        	$('#arrive-city').html(template);
	        }
	    });
	}

}
function searchflights() {
	var string = location.search;
	var departcity = $('#depart-city').val();
	var arrivecity = $('#arrive-city').val();
	var departdate = $('#departdate').val();
	var arrivedate = $('#arrivedate').val();
	var cabin = $('#cabin').val();
	var adult = $('#adult').val();
	var children = $('#child').val();
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
	        	departcity: departcity,
				arrivecity: arrivecity,
				departdate: departdate,
				arrivedate: arrivedate,
				cabin: cabin,
				adult: adult,
				children: children,
				infants: infants
	        },
	        success: function(data) {
	        	// // console.log(data);
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