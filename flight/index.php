<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="icon" href="/favicon.png" type="image/x-icon">
	<title>Book a Flight</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/notification.css">
</head>
<body>
	<div class="homepage-header">
		<img src="/assets/images/logo-black.png">
	</div>
	<div class="background">
		<div class="background-image">
			<img src="/assets/images/plane.jpg">
		</div>
		<div class="homepage-cover">
			<div class="homepage-body-1">
				<h1>Cheap Flights at Best Deals</h1>
				<p>Search hundreds of travel sites at once...</p>
				<br>
				<div class="line"></div>
			</div>
			<div class="homepage-body-2">
				<div class="flight-search-container">
					<h2>Search for a flight</h2>
					<div class="line"></div>
					<div class="column fullwidth">
						<div class=" date fullwidth">
							<p> Departure City: </p>
							<div class="input-container fullwidth">
								<img src="/assets/images/placeholder.svg">
								<select id="departcity" onchange="getcity('arrive')">
									<option></option>
								</select>
							</div>
						</div>
						<div class=" date fullwidth">
							<p> Arrival City: </p>
							<div class="input-container fullwidth">
								<img src="/assets/images/placeholder.svg">
								<select id="arrivecity">
									<option></option>
								</select>
							</div>
						</div>						
						<div class="row fullwidth">
							<div class=" date halfwidth">
								<p> Departure Date: </p>
								<div class="input-container fullwidth">
									<img src="/assets/images/calendar.svg">
									<input type="date" id="depart-date" placeholder="Departure Date">
								</div>
							</div>
							<div class=" date halfwidth">
								<p>Arrival Date:</p>
								<div class="input-container fullwidth">
									<img src="/assets/images/calendar.svg">
									<input type="date" id="arrive-date" placeholder="Departure Date">
								</div>
							</div>
							
						</div>
						<div class="input-container fullwidth">
							<img src="/assets/images/ticket.svg">
							<select id="cabin">
								<option>First</option>
								<option>Economy</option>
								<option>Business</option>
								<option>Premium</option>
							</select>
						</div>
						<div class="row fullwidth">
							<div class="input-container onethirdwidth">
								<img src="/assets/images/man.svg">
								<input type="number" id="adult" placeholder="Adults">
							</div>
							<div class="input-container child onethirdwidth">
								<img class="child" src="/assets/images/man.svg">
								<input type="number" id="children" placeholder="Children">
							</div>
							<div class="input-container onethirdwidth">
								<img src="/assets/images/infant.svg">
								<input type="number" id="infants" placeholder="Infants">
							</div>
						</div>
						<p id="error"></p>
						<button onclick="searchflights()">SEARCH<img src="/assets/images/rightarrow.svg"></button>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<img src="/assets/images/Spinner-1.3s-200px.svg" id="loading">
	<div class="success-cont" id="success-modal">
		<div class="success-content1"><img src="/assets/images/greentick.png"></div>
		<div class="success-content-2">
			<h4>Success</h4>
			<p id="successnotification"></p>
		</div>
		<div class="success-content1" onclick="closemodal()" id="cancel"><img src="/assets/images/cancel.png"></div>
	</div>
	<script type="text/javascript" src="/assets/js/jquery.js"></script>
	<script type="text/javascript" src="/assets/js/bpopup-master/jquery.bpopup.min.js"></script>
	<script type="text/javascript" src="/assets/js/index.js"></script>
	
</body>
</html>