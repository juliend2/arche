<?php
/*
 * The functions.
 */

// Returns a MySQLi object
function get_db() {
  return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

// Routing function:
//
// Takes :
// - the $path (String) of an HTTP endpoint
// - the $action (Callable) to execute when the path is accessed 
function route($path, $action) {
  if ($_GET['uri'] === $path) {
    call_user_func($action);
    exit;
  }
}


// Helpers:
// ------------------------------------------------------------------

// Partials helpers

function get_chunk($filename, $vars=null){
  $content = '';
  ob_start();

  if(!is_null($vars)) {
    extract($vars);
  }

  if (file_exists($filename) === false) {
    throw new Exception("The template $filename does not exist.");
  } else {
    include $filename;
  }

  $content = ob_get_contents();

  ob_end_clean();
  return $content;
}

function return_chunk($filename, $vars=null){
  $filename = dirname(__FILE__) .'/'. $filename;
  return get_chunk($filename, $vars);
}

function render_chunk($filename, $vars=null){
  $filename = dirname(__FILE__) .'/'. $filename;
  echo get_chunk($filename, $vars);
}

function render_view($filename, $vars=null) {
  $filename = BASE_PATH.'/views/'.$filename;
  echo get_chunk($filename, $vars);
}


// HTTP helpers:

function respond_404(){
  header((isset($_SERVER['FCGI_SERVER_VERSION'])?'Status:':'HTTP/1.0') . ' 404 Not Found');
}

function redirect_to($url) {
  header("Location: ".$url);
}

// Text/HTML helpers:

function url_for($action) {
  return BASE_URL . $action;
}

// Pure laziness...
function e($string) {
  echo $string;
}

function link_to($label, $action) {
  return '<a href="'.url_for($action).'">'
    . $label .'</a>';
}

// Functional programming helpers
// ------------------------------------------------------------

function f($args_string, $func_string) {
  return create_function($args_string, $func_string);
}

function map($array, $callback) {
  return array_map($callback, $array);
}

function filter($array, $callback) {
  return array_filter($array, $callback);
}

// @return Array: array that contains the properties values 
// @params:
//  $array Array: array that contains objects or hashes
//  $property String: name of the properties to get from each object
//  $has_hashes Boolean: true if the array contains associative arrays
function pluck($array, $property, $has_hashes = false) {
  $f_body = $has_hashes ? 
              'return $o["'.$property.'"];' : 
              'return $o->'.$property.';';
  return map($array, f('$o', $f_body));
}


// I18n :
// ------------------------------------------------------------------

function __($key) {
  global $lang, $t;
  return isset($t[$lang][$key]) ? $t[$lang][$key] : '';
}

function _e($key) {
  echo __($key);
}

// Utilities
// ------------------------------------------------------------------

// Takes any amount of any param types, and pretty print them.
function pr() {
  $args = func_get_args();
  foreach ($args as $arg) {
    echo "<pre>";
    print_r($arg);
    echo "</pre>";
  }
}

// Takes an Array, a key (String) and maybe a default_value (Mixed)
//
// Returns the element of the array (Mixed) that corresponds to the key
function _array_get($array, $key, $default_value= null) {
  return isset($array[$key]) ? $array[$key] : $default_value;
}

function get_include_contents($filename) {
  if (is_file($filename)) {
    ob_start();
    include $filename;
    return ob_get_clean();
  }
  return false;
}

function var_dump_ret($mixed = null) {
  ob_start();
  var_dump($mixed);
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

function logger($msg) {
  $filename = BASE_PATH.'/log.txt';
  if (defined('LOG_LEVEL') && LOG_LEVEL == 1) {
    // open file 
    $fd = fopen($filename, "a"); 
    // write string 
    fwrite($fd, $msg . "\n"); 
    // close file 
    fclose($fd); 
  }
}


// User Sessions:
// ------------------------------------------------------------------

function securize() {
  session_start();
  if (!isset($_SESSION['user'])) {
    redirect_to(LOGIN_ROUTE);
  }
}

function identify() {
  session_start();
  if (!isset($_POST['user_name']) || !isset($_POST['user_pass'])
  || $_POST['user_name'] !== USER_NAME || $_POST['user_pass'] !== USER_PASS) { 
    redirect_to(LOGIN_ROUTE); die; 
  }
  $_SESSION['user'] = array(
    'name' => $_POST['user_name'],
    'pass' => $_POST['user_pass']
  );
  redirect_to('/'); die;
}

function logout() {
  session_start();
  $_SESSION = array();
  session_destroy();
  redirect_to(LOGIN_ROUTE); die;
}

function logged_in() {
  return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

