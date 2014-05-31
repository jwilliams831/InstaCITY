<?php 

function home()
{
header("Location: https://api.instagram.com/oauth/authorize/?client_id=02c10cbb7d354537a2ac36d228691865&redirect_uri=http://protomofo.com/main&response_type=code");
}

function main(){

$code = $_GET["code"];
echo'
<div class="row-fluid">
        <div class="span4">
          <h2>AUSTIN</h2>
          <a href="/austin?code='.$code.'">
          <img src="images/austin.jpg"  class="img-rounded">
          </a>
        </div>
        <div class="span4">
          <h2>DALLAS</h2>
          <a href="/dallas?code='.$code.'">
          <img src="images/dallas.jpg"  class="img-rounded">
          </a>
       </div>
        <div class="span4">
          <h2>HOUSTON</h2>
          <a href="/houston?code='.$code.'">
          <img src="images/houston.jpg"  class="img-rounded">
          </a>
        </div>
      </div>';

}

function getToken($redirect_url)
{
$code = $_GET["code"];

try{
$curl= curl_init();


	curl_setopt_array($curl, array(
   	 CURLOPT_RETURNTRANSFER => 1,
    	 CURLOPT_URL => 'https://api.instagram.com/oauth/access_token?client_id=02c10cbb7d354537a2ac36d228691865&client_secret=49ff63ff0bd040b282c8fad526f1eaa8&grant_type=authorization_code&redirect_uri='.$redirect_url.'&code='.$code,

			));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);

        // get images matching specified location

        $result = json_decode($resp);
        $data = $result->data;
        return $data["access_token"];
} catch (Exception $e) {
        echo 'ERROR: ' . $e->getMessage() . print_r($client);
        exit;}

}
function austin()
{
 return getToken('/austin');
}
function houston()
{}
function dallas()
{}

function insta_result()
{

 try {
        
	$curl= curl_init();
	curl_setopt_array($curl, array(
   		 	CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => 'https://api.instagram.com/v1/media/popular?client_id=02c10cbb7d354537a2ac36d228691865',

			));

// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);

        // get images matching specified location

        $result = json_decode($resp);
        
        // display images
        $data = $result->data;  
        if (count($data) > 0) {
          echo '<ul>';
          foreach ($data as $item) {
            echo '<li style="display: inline-block; padding: 25px"><a href="' . 
              $item->link . '"><img src="' . $item->images->thumbnail->url . 
              '" /></a> <br/>';
            echo 'By: <em>' . $item->user->username . '</em> <br/>';
            echo 'Date: ' . date ('d M Y h:i:s', $item->created_time) . '<br/>';
            echo $item->comments->count . ' comment(s). ' . $item->likes->count . 
              ' likes. </li>';
          }
          echo '</ul>';
        }

      } catch (Exception $e) {
        echo 'ERROR: ' . $e->getMessage() . print_r($client);
        exit;
      }
    }  

function route($path)
{
$city = strtolower($path);
switch ($path) {
  case "austin":
    echo "<h1>AUSTIN</h1>";
    echo insta_result();
    break;
  case "dallas":
    echo "<h1>DALLAS</h1>";
    echo insta_result();
    break;
  case "houston":
    echo "<h1>HOUSTON</h1>";
    echo insta_result();
    break;
  case "home":
    echo home();
  default:
    main();
}
}

?>
