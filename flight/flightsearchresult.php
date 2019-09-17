<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="icon" href="/favicon.png" type="image/x-icon">
	<title>Flight Search Result | Bookify</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/notification.css">
</head>
<body>
	<div class="homepage-header">
		<img src="/assets/images/logo-black.png">
	</div>
	<div class="search-body">
		<div class="content-1">
			<img src="/assets/images/plane2.jpg">
			<div class="search-edit" id="content-1">
				<div class="search-edit-content twothirdwidth">
					<div class="fullrow fullwidth">
						<div class="marg-right halfwidth">
							<p>From:</p>
							<select id="depart-city">
								<option></option>
							</select>
						</div>
						<div class="halfwidth">
							<p>To:</p>
							<select id="arrive-city">
								<option></option>
							</select>
						</div>
					</div>
					<div class="fullrow fullwidth">
						<div class="marg-right onequaterwidth">
							<p>Depart:</p>
							<input type="date" id="departdate" >
						</div>
						<div class="onequaterwidth">
							<p>Arrive:</p>
							<input type="date" id="arrivedate" >
						</div>
					</div>	
					<div class="fullrow fullwidth">
						<div class="onequaterwidth">
							<p>Cabin Class:</p>
							<select id="cabin">
								<option id="All">All</option>
								<option id="First">First</option>
								<option id="Economy">Economy</option>
								<option id="Business">Business</option>
								<option id="Premium">Premium</option>
							</select>
						</div>
					</div>	
					<div class="fullrow fullwidth">
						<div class="marg-right onequaterwidth">
							<p>Adult:</p>
							<input type="number" id="adult" >
						</div>
						<div class="marg-right onequaterwidth">
							<p>Children:</p>
							<input type="number" id="child">
						</div>
						<div class="onequaterwidth">
							<p>Infant:</p>
							<input type="number" id="infants">
						</div>
					</div>	
					<p id="error"></p>
					<div class="fullrow onethirdwidth">
						<button onclick="searchflights()">EDIT</button>
					</div>
				</div>
			</div>
		</div>
		<div class="content-2 fullwidth" id="content-2">
			<!-- <div class="content-2-item fullwidth">
				<div class="detail fullwidth">
					<div class="">
						<p id=""></p>
					</div>
					<div class="detail-1 fullwidth">
						<div class="detail-3 threequarterwidth">
							<div class="detail-2 fullwidth">
								<div class="">
									<h2 class="time"></h2>
									<p class="city"></p>
									<p class="day"></p>
								</div>
								<div class="to">
									
								</div>
								<div class=" ">
									<p class="time"></p>
									<p class="city"></p>
									<p class="day"></p>
								</div>
							</div>
							<div class="detail-2 fullwidth">
								<div class="">
									<h2 class="time"></h2>
									<p class="city"></p>
									<p class="day"></p>
								</div>
								<div class="to">
									
								</div>
								<div class="det ">
									<p class="time"></p>
									<p class="city"></p>
									<p class="day"></p>
								</div>
							</div>
						</div>
						<div class="book onequarterwidth">
							<h2 class="price"></h2>
							<p class="day"></p>
							<button>BOOK</button>
						</div>
					</div>
				</div>
			</div> -->
			
		</div>
		<div class="content-3" id="content-3">
			<h2 id="message"></h2>
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
	<script type="text/javascript" src="/assets/js/flightsearch.js"></script>

</body>
</html>