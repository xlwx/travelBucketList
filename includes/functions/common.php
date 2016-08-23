<?
/**********************************************************************
Content for VoyagerWebsites
common.php
2015-10-14 11:16AM ET
Christopher P. Burton
**********************************************************************
Some basic utility functions.
**********************************************************************/
function limit_words($string, $word_limit) {
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $word_limit))."&hellip;";
}
/**********************************************************************
Uses Google Maps API to retrieve Latitude and Longitude from an address
**********************************************************************/
function getlatandlon($address){
	$address = urlencode($address);//India, Tamil nadu, chennai
	$local = "AIzaSyAZ0-0oshCREhywF6gt1RxHeX3p7sk5wLE";
	$url = "http://maps.google.com/maps/geo?q=".$address."&output=csv&key=".$local;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0); 
	curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	$dataArray = explode(',', $data);
	return $dataArray;
}

/**********************************************************************
Simple phone number formatting function
**********************************************************************/
function format_phone($phone){
	$phone = preg_replace("/[^0-9]/", "", $phone);
	if(strlen($phone) == 7){
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	}elseif(strlen($phone) == 10){
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	}else{
		return $phone;
	}
}
/**********************************************************************
Replace the last occurance of a string within a string with a string.
**********************************************************************/
function str_lreplace($search, $replace, $subject){
	$pos = strrpos($subject, $search);
	if($pos !== false){
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}
	return $subject;
}

/**********************************************************************
Formats a variable to a 4 point floating decimal
**********************************************************************/
function formatFloatInsert($n){
	$n = number_format(floatval(str_replace(',', '', $n)), 4, '.', '');
	return $n;
}

/**********************************************************************
Simple routines to set and check a possible request forgery string
**********************************************************************/
function setCSRFtoken(){
	return md5(implode('|', $_SESSION));
}

function checkCSRFtoken($str){
	if($str == setCSRFtoken()){
		return true;
	}else{
		return false;
	}
}

function get_ip(){
//Just get the headers if we can or else use the SERVER global
	if(function_exists('apache_request_headers')){
		$headers = apache_request_headers();
	}else{
		$headers = $_SERVER;
	}
//Get the forwarded IP if it exists
	if(array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
		$the_ip = $headers['X-Forwarded-For'];
	}elseif(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
	}else{
		$the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	}
	return $the_ip;
}

function curl_get_file_size($url){
	$result = -1;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_NOBODY, true);
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, get_user_agent_string());
	$data = curl_exec($curl);
	curl_close($curl);
	if($data) {
		$content_length = "unknown";
		$status = "unknown";
		if(preg_match("/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches)) {
			$status = (int)$matches[1];
		}
		if(preg_match("/Content-Length: (\d+)/", $data, $matches)) {
			$content_length = (int)$matches[1];
		}
		if($status == 200 || ($status > 300 && $status <= 308)) {
			$result = $content_length;
		}
	}
	return $result;
}

function in_array_r($needle, $haystack, $strict = false){
	foreach($haystack as $item){
		if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))){
			return true;
		}
	}
	return false;
}

function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function geoLocationCookie($ip){
	if(!$_COOKIE['geolocation']){
		$ipLite = new ip2location_lite;
		$ipLite->setKey(IP2LOC_API);
		$visitorGeolocation = $ipLite->getCountry($ip);
		if($visitorGeolocation['statusCode'] == 'OK'){
			$data = base64_encode(serialize($visitorGeolocation));
			setcookie("geolocation", $data, time()+3600*24*7);
		}
	}else{
		$visitorGeolocation = unserialize(base64_decode($_COOKIE['geolocation']));
	}
}

function distance($lat1, $lon1, $lat2, $lon2, $unit){
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if($unit == "K"){
		return ($miles * 1.609344);
	}elseif($unit == "N"){
		return ($miles * 0.8684);
	}else{
		return $miles;
	}
}

/**********************************************************************
* Creates data URI string of an image file for CSS image embedding.
* @param  [string] $file path to the file
* @return [string]       data URI string
**********************************************************************/
function get_data_uri($file){
	$contents = file_get_contents($file);
	$base64 = base64_encode($contents);
	$imagetype = exif_imagetype($file);
	$mime = image_type_to_mime_type($imagetype);
	return "data:".$mime.";base64,".$base64;
}
function data_uri($file){
	return get_data_uri($file);
}

/**********************************************************************
Function to process authorization and payment requests to the Payeezy API
**********************************************************************/
/*
function sendPayzeeyRequest(PDO $vDB, $merchantName, $_POST, $transaction_type){
	$reqbody['merchant_ref'] = $merchantName." - Voyager Websites";
	$reqbody['partial_redemption'] = 'false';
	$reqbody['transaction_type'] = $transaction_type;
	$reqbody['method'] = "credit_card";
	$reqbody['amount'] = str_replace('.', '', number_format($_POST['amount'], 2, '.', ''));
	$reqbody['currency_code'] = "USD";
	$reqbody['credit_card']['type'] = $_POST['type'];
	$reqbody['credit_card']['cardholder_name'] = $_POST['name'];
	$reqbody['credit_card']['card_number'] = $_POST['num'];
	$reqbody['credit_card']['exp_date'] = $_POST['date'];
	$reqbody['credit_card']['cvv'] = $_POST['code'];

	list($usec, $sec) = explode(" ", microtime());
	$timestamp = round(((float)$usec + (float)$sec) * 1000);
	$timestamp = $timestamp - 5000;
	$nonce = rand();
	$reqbody = json_encode($reqbody);
	$summarize = "";
	$summarize .= $apikey;
	$summarize .= $nonce;
	$summarize .= $timestamp;
	$summarize .= $token;
	$summarize .= $reqbody;
	$hmac = hash_hmac('SHA256', $summarize, $apisecret);
	$hmac_enc = base64_encode($hmac);

	$curl = curl_init($serviceURL);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $reqbody);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_VERBOSE, true);

	$headers = array(
	    'Content-type: application/json',
	    "Authorization: ".$hmac_enc,
	    "apikey: ".$apikey,
	    "token: ".$token,
	    "timestamp: ".$timestamp,
	    "nonce: ".$nonce,
	);

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$json_response = curl_exec($curl);

	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	if($status != 201){
	    $response = "<p>Error: call to URL <em>".$serviceURL."</em> failed with status <strong>".$status."</strong>.<br />Response <strong>".$json_response."</strong><br />curl_error <strong>".curl_error($curl)."</strong><br />curl_errno <strong>".curl_errno($curl)."</strong></p>";
	    return $response;
	    exit();
	}
	curl_close($curl);
	$response = json_decode($json_response, true);
	$vDB->query("INSERT INTO subscriberTransactions() VALUES(:cardholder_name,:correlation_id,:transaction_status,:validation_status,:transaction_type,:transaction_id,:transaction_tag,:method,:token_type,:token_data,:bank_resp_code,:bank_message,:gateway_resp_code,:gateway_message,:transaction_date)");
	$vDB->bind(':cardholder_name', strtolower($_POST['name']), PDO::PARAM_STR);
	$vDB->bind(':correlation_id', $response['correlation_id'], PDO::PARAM_STR);
	$vDB->bind(':transaction_status', $response['transaction_status'], PDO::PARAM_STR);
	$vDB->bind(':validation_status', $response['validation_status'], PDO::PARAM_STR);
	$vDB->bind(':transaction_type', $response['transaction_type'], PDO::PARAM_STR);
	$vDB->bind(':transaction_id', $response['transaction_id'], PDO::PARAM_STR);
	$vDB->bind(':transaction_tag', $response['transaction_tag'], PDO::PARAM_STR);
	$vDB->bind(':method', $response['method'], PDO::PARAM_STR);
	$vDB->bind(':token_type', $response['token_type'], PDO::PARAM_STR);
	$vDB->bind(':token_data', $response['token_data'], PDO::PARAM_STR);
	$vDB->bind(':bank_resp_code', $response['bank_resp_code'], PDO::PARAM_STR);
	$vDB->bind(':bank_message', $response['bank_message'], PDO::PARAM_STR);
	$vDB->bind(':gateway_resp_code', $response['gateway_resp_code'], PDO::PARAM_STR);
	$vDB->bind(':gateway_message', $response['gateway_message'], PDO::PARAM_STR);
	$vDB->bind(':transaction_date', time(), PDO::PARAM_STR);
	$vDB->execute();
	$lid = $vDB->lastInsertId();
	$response = $transaction_type." - ".$response['transaction_status'].":".$response['validation_status'];
	return $response;
}
*/


function generateFileCSV($data, $fileName, $delimiter = ',', $enclosure = '"') {
       $handle = fopen($fileName, "w");
       foreach ($data as $line) {
               fputcsv($handle, $line, $delimiter, $enclosure);
       }
       fclose($handle);
       return true;
}

function mailingHeader($pageTitle = ''){
	$msgHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	$msgHeader .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	$msgHeader .= "  <head>\n";
	$msgHeader .= "    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />\n";
	$msgHeader .= "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>\n";
	$msgHeader .= "    <title>".$pageTitle."</title>\n";
	$msgHeader .= "    <style type=\"text/css\">\n";
	$msgHeader .= "      #outlook a {\n";
	$msgHeader .= "      padding:0;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      body{\n";
	$msgHeader .= "      width:100% !important;\n";
	$msgHeader .= "      -webkit-text-size-adjust:100%;\n";
	$msgHeader .= "      -ms-text-size-adjust:100%;\n";
	$msgHeader .= "      margin:0;\n";
	$msgHeader .= "      padding:0;\n";
	$msgHeader .= "      font-family:Tahoma, Verdana, Segoe, sans-serif;\n";
	$msgHeader .= "      font-size:12px;\n";
	$msgHeader .= "      line-height:1;\n";
	$msgHeader .= "      background-color:#FFFEF0;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      .ExternalClass {\n";
	$msgHeader .= "      width:100%;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {\n";
	$msgHeader .= "      line-height: 100%;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      .backgroundTable {\n";
	$msgHeader .= "      margin:0;\n";
	$msgHeader .= "      padding:0;\n";
	$msgHeader .= "      width:100% !important;\n";
	$msgHeader .= "      line-height: 100% !important;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      img {\n";
	$msgHeader .= "      outline:none;\n";
	$msgHeader .= "      text-decoration:none;\n";
	$msgHeader .= "      border:none;\n";
	$msgHeader .= "      -ms-interpolation-mode: bicubic;\n";
	$msgHeader .= "      display:block;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      a img {\n";
	$msgHeader .= "      border:none;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      .image_fix {\n";
	$msgHeader .= "      display:block;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      p {\n";
	$msgHeader .= "      line-height:1.2;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      table td {\n";
	$msgHeader .= "      border-collapse: collapse;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      table {\n";
	$msgHeader .= "      border-collapse:collapse;\n";
	$msgHeader .= "      mso-table-lspace:0pt;\n";
	$msgHeader .= "      mso-table-rspace:0pt;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      a {\n";
	$msgHeader .= "      color: #00669D;\n";
	$msgHeader .= "      text-decoration: none;\n";
	$msgHeader .= "      text-decoration:none!important;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "      .wrap{\n";
	$msgHeader .= "      border-left-width:1px;\n";
	$msgHeader .= "      border-left-style:solid;\n";
	$msgHeader .= "      border-left-color:#BDBDBD;\n";
	$msgHeader .= "      border-right-width:1px;\n";
	$msgHeader .= "      border-right-style:solid;\n";
	$msgHeader .= "      border-right-color:#BDBDBD;\n";
	$msgHeader .= "      border-top-width:1px;\n";
	$msgHeader .= "      border-top-style:solid;\n";
	$msgHeader .= "      border-top-color:#D8D8D8;\n";
	$msgHeader .= "      border-bottom-width:1px;\n";
	$msgHeader .= "      border-bottom-style:solid;\n";
	$msgHeader .= "      border-bottom-color:#8C8C8C;\n";
	$msgHeader .= "      background-color:#FFFFFF;\n";
	$msgHeader .= "      margin-top:0;\n";
	$msgHeader .= "      margin-bottom:0;\n";
	$msgHeader .= "      margin-right:auto;\n";
	$msgHeader .= "      margin-left:auto;\n";
	$msgHeader .= "      border-collapse:collapse;\n";
	$msgHeader .= "      mso-table-lspace:0pt;\n";
	$msgHeader .= "      mso-table-rspace:0pt;\n";
	$msgHeader .= "      padding:12px 12px 12px 12px;\n";
	$msgHeader .= "      }\n";
	$msgHeader .= "    </style>\n";
	$msgHeader .= "  </head>\n";
	$msgHeader .= "  <body style=\"margin-top:10px;margin-bottom:0;margin-right:auto;margin-left:auto;width:100%;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:Tahoma, Verdana, Segoe, sans-serif;font-size:12px;line-height:1;background-color:#FFFEF0;\">\n";
	$msgHeader .= "    <center>\n";
	$msgHeader .= "      <table id=\"wrap\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">\n";
	$msgHeader .= "        <tr>\n";
	$msgHeader .= "          <td align=\"center\" valign=\"top\">\n";
	$msgHeader .= "            <table width=\"100%\" bgcolor=\"#FFFEF0\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"backgroundTable\">\n";
	$msgHeader .= "              <tr>\n";
	$msgHeader .= "                <td>\n";
	$msgHeader .= "                  <table width=\"625\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" style=\"border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;\">\n";
	$msgHeader .= "                    <tr>\n";
	$msgHeader .= "                      <td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;\">\n";
	$msgHeader .= "                        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" class=\"wrap\">\n";
	$msgHeader .= "                          <tr>\n";
	$msgHeader .= "                            <td align=\"left\" valign=\"top\">\n";
	return $msgHeader;
}

function mailingFooter(){
	$msgFooter = "";
	$msgFooter .= "                            </td>\n";
	$msgFooter .= "                          </tr>\n";
	$msgFooter .= "                        </table>\n";
	$msgFooter .= "                      </td>\n";
	$msgFooter .= "                    </tr>\n";
	$msgFooter .= "                  </table>\n";
	$msgFooter .= "                </td>\n";
	$msgFooter .= "              </tr>\n";
	$msgFooter .= "            </table>\n";
	$msgFooter .= "          </td>\n";
	$msgFooter .= "        </tr>\n";
	$msgFooter .= "      </table>\n";
	$msgFooter .= "    </center>\n";
	$msgFooter .= "  </body>\n";
	$msgFooter .= "</html>";
	return $msgFooter;
}



function romanNumerals($num){
	$n = intval($num);
	$res = '';
	$roman_numerals = array(
		'M'  => 1000,
		'CM' => 900,
		'D'  => 500,
		'CD' => 400,
		'C'  => 100,
		'XC' => 90,
		'L'  => 50,
		'XL' => 40,
		'X'  => 10,
		'IX' => 9,
		'V'  => 5,
		'IV' => 4,
		'I'  => 1);
	foreach ($roman_numerals as $roman => $number){
		$matches = intval($n / $number);
		$res .= str_repeat($roman, $matches);
		$n = $n % $number;
	}
	return $res;
}

function updateProgress($db, $userID, $section, $page){
	$db->query("SELECT COUNT(*) AS count FROM participantProgress WHERE participantID = :uID AND sectionProgress = :sID AND pageProgress = :pID");
	$db->bind(":uID", $userID, PDO::PARAM_INT);
	$db->bind(":sID", $section, PDO::PARAM_INT);
	$db->bind(":pID", $page, PDO::PARAM_INT);
	$db->execute();
	$c = $db->single();
	if(intval($c['count']) > 0){
		$db->query("UPDATE participantProgress SET progressDate = :dateTime WHERE participantID = :uID AND sectionProgress = :sID AND pageProgress = :pID");
		$db->bind(":dateTime", date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$db->bind(":uID", $userID, PDO::PARAM_INT);
		$db->bind(":sID", $section, PDO::PARAM_INT);
		$db->bind(":pID", $page, PDO::PARAM_INT);
		$db->execute();
	}else{
		$db->query("INSERT INTO participantProgress(participantID,sectionProgress,pageProgress,progressDate) VALUES(:uID, :sID, :pID, :dateTime)");
		$db->bind(":uID", $userID, PDO::PARAM_INT);
		$db->bind(":sID", $section, PDO::PARAM_INT);
		$db->bind(":pID", $page, PDO::PARAM_INT);
		$db->bind(":dateTime", date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$db->execute();
	}
}

function getRef(){
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	$domain = $_SERVER['HTTP_HOST'];
	$script = $_SERVER['SCRIPT_NAME'];
	$parameters = $_SERVER['QUERY_STRING'];
	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
	$qs = (strlen($parameters) >= 1) ? '?' : '';
	$finalUrl = $protocol . '://' . $domain. $script . $qs . $parameters;
 
	return $finalUrl;
}