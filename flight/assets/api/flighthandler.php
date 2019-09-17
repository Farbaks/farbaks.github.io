<?php


require_once $_SERVER['DOCUMENT_ROOT']."/assets/api/configuration.php";
require_once $_SERVER['DOCUMENT_ROOT']."/assets/api/sqlqueries.php";
require_once $_SERVER['DOCUMENT_ROOT']."/assets/api/flight.php";
date_default_timezone_set("Africa/Lagos");

$connect = connecttodatabase();
$json = array();

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	if ($action == "search") {

		$flightdetails = array(
			'departureCity' => mysqli_real_escape_string($connect, $_POST['departcity']),
			'destinationCity' => mysqli_real_escape_string($connect, $_POST['arrivecity']),
			'departureDate' => mysqli_real_escape_string($connect, $_POST['departdate']),
			'returnDate' => mysqli_real_escape_string($connect, $_POST['arrivedate']),
			'noOfAdult' => mysqli_real_escape_string($connect, $_POST['adult']),
			'noOfChild' => mysqli_real_escape_string($connect, $_POST['children']),
			'noOfInfant' => mysqli_real_escape_string($connect, $_POST['infants']),
			'cabin' => mysqli_real_escape_string($connect, $_POST['cabin'])
		); 

		$valid = new Flight();
		$message = $valid->checkvalidity($connect,$flightdetails);
		echo json_encode($message);
	}

	else if ($action == "searchresult") {
		$originalurl = "http://www.ije-api.tcore.xyz";
		$flightdetails = array(
			'departureCity' => mysqli_real_escape_string($connect, $_POST['departcity']),
			'destinationCity' => mysqli_real_escape_string($connect, $_POST['arrivecity']),
			'departureDate' => mysqli_real_escape_string($connect, $_POST['departdate']),
			'returnDate' => mysqli_real_escape_string($connect, $_POST['arrivedate']),
			'noOfAdult' => mysqli_real_escape_string($connect, $_POST['adult']),
			'noOfChildren' => mysqli_real_escape_string($connect, $_POST['children']),
			'noOfInfant' => mysqli_real_escape_string($connect, $_POST['infants']),
			'cabin' => mysqli_real_escape_string($connect, $_POST['cabin']),
		); 

		$valid = new Flight();
		$message = $valid->checkcookies($connect);
		if (!isset($_POST['cookies'])) {
			$details = array(
				'email' => 'customer@travelportal.com',
				'password' => 'customer'
			);
			$getcookies = $valid->getcookies($connect, $details, $originalurl);
			$getflights = $valid->getflights($connect, $flightdetails, $originalurl, $getcookies);
		}
		else {
			$cookies =  mysqli_real_escape_string($connect, $_POST['cookies']);
			$getflights = $valid->getflights($connect, $flightdetails, $originalurl, $cookies);
		}
		echo $getflights;
	}

	elseif ($action == "getcity" ) {
		$city = new Flight();
		$getcity = $city->getcity($connect);
		echo json_encode($getcity);

	}
}



?>