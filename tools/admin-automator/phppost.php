<?php

/**
 * @name    phppost.php
 * @desc    Simple Post Class for PHP
 * @author  Greg Elin
 * @since   January 2014
 * @version 0.1
 *
 * 
 **/

error_reporting(-1);

class PHPPost {


  public function __construct() {
   /**
   * Set defaults
   */
    $this->api_key = null;
    $this->app_id = null;
    $this->auth_token = null;
    $this->host_path = null;
    $this->base_url = null;
    $this->method = "null";
    $this->format = ".json";
    $this->file_name = null;
    $this->file_url = null;


   /**
   * is cURL installed?
   */
    if (! function_exists('curl_init')) {
      throw new Exception('CURL PHP extension not installed.');
    }

    # Check credentials defined?
    if ( !defined('HOST_PATH') ) {
      echo 'Credentials missing.';
      exit;
    }
  }


  public function SetProperty($prop='',$value='')
  {
  	# WARNING: Not testing type and should be
  	$this->$prop = $value;
  }

  public function SetApiKey($api_key) 
  {
  	$this->api_key = $api_key;
  }

  public function GetApiKey() {
  	return $this->api_key;
  }

  public function CheckProperty($prop=null)
  {
  	try {
  		echo "Property '$prop' is ", (isset($this->$prop)? "'{$this->$prop}'": "not set or null"); 
  	} catch (Exception $e) {
  		echo "Property $prop does not exist.";
  	}
  }

  public function Url()
  {
  	return $url = $this->host_path;
  }

  public function SimpleGet()
  {
  	$this->method = "my_method";
    $this->format = ".json";
  	$result = $this->ApiUtilCurlGet($this->Url());
  	$this->_ResetPostParams();
    return $result;
  }


  public function SimplePost()
  {
  	$this->method = "my_post_method";
    $this->format = ".json";
    echo $this->Url()."\n";
    $result = $this->ApiUtilCurlPost($this->Url());
    $this->_ResetPostParams();
    return $result;
  }

  private function _ResetPostParams()
  {
  	// Reset all upload parameters to avoid accidental actions
  	
  }


  /** 
   * Send a GET requst using cURL 
   * @param string $url to request 
   * @param array $get values to send 
   * @param array $options for cURL 
   * @return string 
   * @source from PHP Manual pages
   */ 
  function ApiUtilCurlGet($url, array $get = array(), array $options = array()) 
  {    
    $defaults = array( 
    	CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '' : '?'). http_build_query($get),
   		CURLOPT_HEADER => 0, 
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_RETURNTRANSFER => TRUE, 
      CURLOPT_TIMEOUT => 120
    ); 
    // echo "defaults: ".$defaults[CURLOPT_URL];

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    
    if( ! $result = curl_exec($ch)) 
    { 
      trigger_error(curl_error($ch)); 
      echo "<br>here error";
      echo curl_error($ch);
    }
    curl_close($ch);
    return $result; 
} 

  /** 
   * Send a POST requst using cURL 
   * @param string $url to request 
   * @param array $post values to send 
   * @param array $options for cURL 
   * @return string 
   * @source from PHP Manual pages
   */ 

  function ApiUtilCurlPost($url, array $post = NULL, array $options = array()) 
  {  
    # Set options - note we are currently ignoring the incoming options
	$post_fields = Array(
		// 'api_key' => $this->api_key,
		// 'host_path' => $this->host_path,
		// 'method' => $this->method,
		// 'format' => $this->format

    // This *might* work for statedecoded!
    'action' => "parse",
    'edition_option' => "new",
    'new_edition_name' => "2014-01",
    'new_edition_slug' => "2014-01",
    'make_current' => 1 
	);

  echo "preparing to post\n";

   $defaults = array( 
      CURLOPT_POST => 1, 
      CURLOPT_HEADER => 0, 
      CURLOPT_URL => $url, 
      CURLOPT_FRESH_CONNECT => 1, 
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_RETURNTRANSFER => 1, 
      CURLOPT_FORBID_REUSE => 1, 
      CURLOPT_TIMEOUT => 1200, 
      CURLOPT_POSTFIELDS => $post_fields
    ); 
   echo "<pre>\n";print_r($defaults);echo "</pre>\n";

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 

    echo "about to run curl_exec";


    if( ! $result = curl_exec($ch)) 
    { 
      trigger_error(curl_error($ch)); 
    } 
    curl_close($ch); 
      return $result; 
  } 


}
?>