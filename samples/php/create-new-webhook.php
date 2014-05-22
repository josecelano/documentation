<?php 

require '../../vendor/autoload.php';
require 'Config.php';

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

$client = new Client(API_HOST);

// Set a single header using path syntax
$client->setDefaultOption('headers/Content-Type', 'application/json');

// Default values. Can be overridden from GET parameters.
$event = 'new-pool-tx';
$address = '1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v';

if (!empty($_GET['event'])) $event = $_GET['event'];
if (!empty($_GET['address'])) $address = $_GET['address'];

// webhook sample request body
// {"filter": "event=new-block-tx&addr=1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v", "token": "dhy76hdg-dh7y-dhyh-dfvg-0645bf4gr5f5"}

$dataArray = array(
	'filter'	=> "event=$event&addr=$address",
	'url'		=> CALLBACK_URL,
	'token'		=> API_TOKEN
);

$dataJson = json_encode($dataArray);

// Headers
$headers = array(
	'Content-Length' => strlen($dataJson),
);

// Options
$options = array(
	//'cert' => __DIR__ . '/cacert.pem',
);

$request = $client->post(API_PATH, $headers, $dataJson, $options);

//$request->setAuth('john@doe.tst', 'yourpasswordhere');

// TODO: Do not do this in production
// http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
$request->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, false);

echo "<b>Request POST</b> ".API_HOST."/".API_PATH." with <b>POST data</b>:<br/>";
var_dump($dataArray);

try {

	$response = $request->send();

	echo "<b>Response Headers:</b><br/>";
	echo "<pre>";
	echo $response->getRawHeaders();
	echo "</pre>";
	
	$responseBody = $response->getBody(true);

	echo "<b>Response Body:</b><br/>";
	echo "<pre>";
	echo $responseBody;
	echo "</pre>";

} catch (ClientErrorResponseException $e) {
	
	echo '<b>Exception: </b>'.$e->getMessage();
	
	$responseBody = $e->getResponse()->getBody(true);

	echo "<b>Response Body:</b><br/>";
	echo "<pre>";
	echo $responseBody;
	echo "</pre>";

}

?>