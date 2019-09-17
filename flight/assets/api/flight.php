<?php



/**
 * 
 */
class Flight extends sqlqueries
{	
	// Function to gegt the list of all cities and their IATA codes
	function getcity($connect) 
	{
		$city = array();
		$query = "SELECT * FROM iata_airport_codes";
		$result = mysqli_query($connect, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$city['name'][] = $row['airport'];
			$city['code'][] = $row['code'];
		}
		return $city;
	}

	// Function to validate the dates entered
	function checkdate($date1, $date2) 
	{
		$today = date("Y-m-d");
		if ($today >= $date1) {
			$message =  "Departure date cannot be today or a previous day";
		}
		else if ($date2 < $date1) {
			$message =  "Return date must be after the departure date";
		}
		else {
			$message = "date valid";
		}
		return $message;
	}

	// Function to validate the number of passengers
	function checkpassengers($adult, $infant) 
	{
		if ($adult > 9) {
			$message = "The maximum number of adults allowed is 9";
		}
		else if ($infant > $adult) {
			$message = "The number of adults must be equal or more than the number of infants";
		}
		else {
			$message = "passenger valid";
		}
		return $message;
	}

	// Function to check if the arrival city and departure city are the same
	function checkcity($city1, $city2) 
	{
		$today = date("Y-m-d");
		if ($city1 == $city2) {
			$message =  "City of Arrival cannot be the same as the city of departure";
		}
		else {
			$message = "city valid";
		}
		return $message;
	}

	// Function to check the validity of the entries
	function checkvalidity($connect, $flightdetails)
	{
		$check = array();
		$check['message'] = $this->checkcity($flightdetails['departureCity'], $flightdetails['destinationCity']);
		if ($check['message'] == "city valid") {
			$check['message'] = $this->checkdate($flightdetails['departureDate'], $flightdetails['returnDate']);
			if ($check['message'] == "date valid") {
				$check['message'] = $this->checkpassengers($flightdetails['noOfAdult'], $flightdetails['noOfInfant']);

				if ($check['message'] == "passenger valid") {
					$query1 = 'SELECT * FROM iata_airport_codes WHERE airport = "'.$flightdetails['departureCity'].'"';
					$result1 = mysqli_query($connect, $query1);
					while ($row1 = mysqli_fetch_assoc($result1)) {
						$check['departcity'] = $row1['code'];
					}
					$query2 = 'SELECT * FROM iata_airport_codes WHERE airport = "'.$flightdetails['destinationCity'].'"';
					$result2 = mysqli_query($connect, $query2);
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$check['arrivecity'] = $row2['code'];
					}
					$check['message'] = "The data entered is valid";
				}
			}
		}
			
		return $check;
	}

	// Function to check if there is an available cookie for the api request
	function checkcookies($connect) {
		$message = array();
		$query = "SELECT * FROM cookies ORDER BY ID DESC LIMIT 1";
		$result = mysqli_query($connect, $query);
		if (mysqli_num_rows($result) == 0) {
			$message['status'] = "No cookies set";
		}
		else {
			while ($row = mysqli_fetch_assoc($result)) {
				$message['status'] = "Cookie found";
				$message['cookie'] = $row['cookieid'];
			}
		}
		return $message;
	}

	// Function to fetch the most recent cookie from the database 
	function getcookies($connect, $details, $originalurl) {
		$message = array();
		$url = $originalurl."/v1/auth/login";

		$postRequest = array(
		    'header' => array(
		    	'cookie' => ''
		    ),
		    'body' => array(
		    	'email' => $details['email'],
		    	'password' => $details['password']
		    )
		);
		$post = json_encode($postRequest);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Accept: application/json'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$apiResponse = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($apiResponse, true);

		$field = array(
			'cookieid' => $response['body']['data']['api_token']
		);
		$go = $this->insert($connect, 'cookies', $field);
		$message['cookieid'] = $response['body']['data']['api_token'];
		return $message['cookieid'];
	}

	// Function to get the list of available flights 
	function getflights($connect, $flightdetails, $originalurl, $cookie) {
		$url = $originalurl."/v1/flight/search-flight";
		$json = array();

		$postRequest = array(
		    "header" => array(
		        "cookie" => "$cookie"
		    ),
		    "body" => array(
		        "origin_destinations" => array(
		            0 => array(
		                "departure_city" => $flightdetails['departureCity'],
		                "destination_city" => $flightdetails['destinationCity'],
		                "departure_date" => $flightdetails['departureDate'],  
		                "return_date" => $flightdetails['returnDate']           
		            )
		        ),
		        "search_param" => array(
		            "no_of_adult" => $flightdetails['noOfAdult'],
		            "no_of_child" => $flightdetails['noOfChildren'],
		            "no_of_infant" => $flightdetails['noOfInfant'],
		            "preferred_airline_code"  => "",
		            "calendar"  => false,
		            "cabin" => $flightdetails['cabin']
		        )
		    )
		);
		$post = json_encode($postRequest);
		// print_r($post);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Accept: application/json'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$apiResponse = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($apiResponse, true);
		$status = $response['body']['status'];
		if ($status == "422") {
			$info = $response['body']['errors'][0]['flight'];
			$json[0]['message'] = $info;
		}
		else {
			
			$one1 = $response['body']['data']['itineraries'];
			$b = 0;
			for ($a=0; $a < count($one1); $a++) { 
				$one = $response['body']['data']['itineraries'][$a];
				$two =  $one['origin_destinations'][1]['segments'];
				
				if (count($two) == 1) { 
					$json[$b]['cabin'] = $one['cabin']['name'];
					$json[$b]['price'] = number_format($one['pricing']['provider']['total_fare']);
					$json[$b]['airline'] = $one['origin_destinations'][0]['segments'][0]['marketing_airline']['name'];
					$json[$b]['To']['left']['date'] = $one['origin_destinations'][0]['segments'][0]['departure']['date'];
					$json[$b]['To']['left']['time'] = $one['origin_destinations'][0]['segments'][0]['departure']['time'];
					$json[$b]['To']['left']['city'] = $one['origin_destinations'][0]['segments'][0]['departure']['airport']['city_name'];
					$json[$b]['To']['right']['date'] = $one['origin_destinations'][0]['segments'][0]['arrival']['date'];
					$json[$b]['To']['right']['time'] = $one['origin_destinations'][0]['segments'][0]['arrival']['time'];
					$json[$b]['To']['right']['city'] = $one['origin_destinations'][0]['segments'][0]['arrival']['airport']['city_name'];
					$json[$b]['fro']['left']['date'] = $one['origin_destinations'][1]['segments'][0]['departure']['date'];
					$json[$b]['fro']['left']['time'] = $one['origin_destinations'][1]['segments'][0]['departure']['time'];
					$json[$b]['fro']['left']['city'] = $one['origin_destinations'][1]['segments'][0]['departure']['airport']['city_name'];
					$json[$b]['fro']['right']['date'] = $one['origin_destinations'][1]['segments'][0]['arrival']['date'];
					$json[$b]['fro']['right']['time'] = $one['origin_destinations'][1]['segments'][0]['arrival']['time'];
					$json[$b]['fro']['right']['city'] = $one['origin_destinations'][1]['segments'][0]['arrival']['airport']['city_name'];

					$b = $b +1;
				}
			}	
			
			if ($response['header']['cookie'] != "" && $cookie != $response['header']['cookie']) {
				$json[$b]['cookies'] = $response['header']['cookie'];
			}
			else {
				$json[$b]['cookies'] = $cookie;
			}			
			$json[$b]['message'] = "flights available";
		}
			
		return json_encode($json);
	}
}


?>