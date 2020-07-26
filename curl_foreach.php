<?php
//  http:/ /stackoverflow.com/questions/2692704/how-can-i-use-curl-to-open-multiple-urls-simultaneously-with-php
/*
$SQL = mysql_query("SELECT url FROM urls") or die(mysql_error()); //Query the urls table
while($resultSet = mysql_fetch_array($SQL)){ //Put all the urls into one variable

                // Now for some cURL to run it.
            $ch = curl_init($resultSet['url']); //load the urls
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); //No need to wait for it to load. Execute it and go.
            curl_exec($ch); //Execute
            curl_close($ch); //Close it off 
        } //While loop

$curl_handles = array("http://www.tamavodka.net23.net/profilepage.php?id=1","http://www.tamavodka.net23.net/profilepage.php?id=2");
foreach ($curl_handles as $url) {
    $curl_handles[$url] = curl_init();
    curl_setopt($curl_handles[$url], CURLOPT_URL, $url);
    // set other curl options here
	$ch = curl_init($curl_handles); //load the urls
	//page with the content I want to grab
	curl_setopt($ch, CURLOPT_URL, $curl_handles[$url]);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // wait 30 seconds to open next url. Execute it and go.
    curl_exec($ch); //Execute
    curl_close($ch); //Close it off 		
	//do stuff with the info with DomDocument() etc
	$html = curl_exec($ch);
	echo $html;
}
*/
//  http:/ /stackoverflow.com/questions/19732488/php-curl-request-as-a-foreach-loop
$numbers = array('1','2','3');

 foreach ($numbers as $value)
 {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($curl, CURLOPT_USERPWD, "user:password");
  curl_setopt($curl, CURLOPT_URL, "http://www.tamavodka.net23.net/profilepage.php?id=".$value);

  $ret = curl_exec($curl);
  $result = json_decode($ret,true);

   echo $result['someData'] . "<br>";
  curl_close($curl);
 }
?>