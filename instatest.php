<html>
  <head></head>
  <body>
    <h1>Instagram Photo Search by Location</h1>
    <?php
    if (!isset($_POST['submit'])) {
    ?>
    <form method="post" 
      action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      Latitude: <input type="text" name="lat" />  
      Longitude: <input type="text" name="long" /> 
      <input type="submit" name="submit" value="Search!" />      
    </form>
    <?php
    } else {
    ?>
    <h1>Search results for 'lat:<?php echo $_POST['lat']; ?>, 
      long:<?php echo $_POST['long']; ?>'</h1>
    <?php


      // define consumer key and secret
      // available from Instagram API console
      $CLIENT_ID = '7d41e34ff099492b8ace24d2fef796ad';
      $CLIENT_SECRET = 'YOUR-CLIENT-SECRET';

      try {
        
	$curl= curl_init();
	curl_setopt_array($curl, array(
   		 	CURLOPT_RETURNTRANSFER => 1,
    			/*CURLOPT_URL => 'https://api.instagram.com/v1/media/search?lat=32.7758&lng=96.7967&distance=5000
			&client_id=7d41e34ff099492b8ace24d2fef796ad'*/
                        CURLOPT_URL => 'https://api.instagram.com/v1/media/popular?client_id=02'.$CLIENT_ID,

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
    ?>
  </body>
</html>
