<?php
/**
 * @authors Greg Elin
 * @since   January 2014
 * @version 0.1
 * @usage   http://localhost:8080/automator1.php
 *
 */

/**
* does credentials.php exist?
*/
if (! file_exists('credentials.php') ) {
  echo 'Cannot find required credentials.php file.';
  exit;
}

// echo "here\n";

// # Requires
require_once('phppost.php');
require_once('credentials.php');

// # Instantiate PHPPost class
$phppost = new PHPPost();

// # Let's prepare a post
$phppost->host_path            = HOST_PATH;

$phppost->SimplePost();

// And The Curl appears to run, but I do not get anything back at all. Am I making an error? What is a better way to see the interaction? 

// Should I make a separate PHP script that runs within statedecoded?


?>