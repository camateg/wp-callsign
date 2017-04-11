<?php
/*
* Plugin Name: Callsign ShortCode
* Description: Queries QRZ for Callsign Data.
* Version: 0.1 
* Author: Matthew Fleeger 
* Author URI: https://kb3tix.net
*/

function kb3tix_get_callsign($atts){
  $atts = shortcode_atts(
    array(
      'call' => '',
      'show_address' => 1,
    ), $atts, 'callsign');
  
  $url = 'https://callook.info/' . $atts['call'] . '/json';
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $res = curl_exec($ch);
  curl_close(ch);
  
  $data = json_decode($res, true);

  if (isset($data['name'])) {
    if ($atts['show_address']) {
      return $data['name'] . "<br />" . $data['address']['line1'] . "<br />" . $data['address']['line2'];
    } else {
      return $data['name'];
    }
  } else {
    return $atts['call'] . " is not a valid callsign";
  }
}

add_shortcode('callsign', 'kb3tix_get_callsign');

?>
