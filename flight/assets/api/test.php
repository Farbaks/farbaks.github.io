<?php
$originalurl = "http://www.ije-api.tcore.xyz";
$url = $originalurl."/v1/flight/search-flight";
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n    \"header\": {\n        \"cookie\": \"KLvhYK3kZUI8gLYDlCgb\"\n    },\n    \"body\": {\n        \"origin_destinations\": [\n            {\n                \"departure_city\": \"LOS\",\n                \"destination_city\": \"DXB\",\n                \"departure_date\": \"09/13/2019\",\n                \"return_date\": \"\"\n            }\n        ],\n        \"search_param\": {\n            \"no_of_adult\": 1,\n            \"no_of_child\": 1,\n            \"no_of_infant\": 0,\n            \"preferred_airline_code\" : \"EK\",\n            \"calendar\" : true,\n            \"cabin\": \"All\"\n        }\n    }\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;}

$json = array();

// $postRequest = array(
//     "header" => array(
//         "cookie" => "KLvhYK3kZUI8gLYDlCgb"
//     ),
//     "body" => array(
//         "origin_destinations" => array(
//             0 => array(
//                 "departure_city" => "LOS",
//                 "destination_city" => "DXB",
//                 "departure_date" => "2019-12-13",  
//                 "return_date" => "2019-12-26"           
//             )
//         ),
//         "search_param" => array(
//             "no_of_adult" => 1,
//             "no_of_child" => 1,
//             "no_of_infant" => 1,
//             "cabin" => "All"
//         )
//     )
// );
// $post = json_encode($postRequest);
// print_r($post);
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Accept: application/json'
// ));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// $apiResponse = curl_exec($ch);
// curl_close($ch);
$response = json_decode($apiResponse, true);
if ($response['header']['cookie'] != "" && "KLvhYK3kZUI8gLYDlCgb" != $response['header']['cookie']) {
	$field = array(
		'cookieid' => $response['header']['cookie']
	);
}

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
	$json[$b]['message'] = "flights available";
}
	
return $apiResponse;
print_r($apiResponse);
echo "<script type='text/javascript' >console.log(".$apiResponse.")</script>";

// $date = date_create("'2''0''1'9-'0'9-'1''1'");
// print_r( $date);
// print_r(date_format($date, 'Y/m/d'));