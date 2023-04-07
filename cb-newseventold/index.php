<?php
/*
Plugin Name: CB OLD News Event
Plugin URI: 
Version: 1.1
Description: News Event
License URI: https://www.ikf.co.in/
*/
if ( ! defined( 'ABSPATH' ) ) exit; 
require_once 'class/cb_newseventold.php';
global $cb_newseventold;
$cb_newseventold = new CB_Newseventold(__FILE__);
?>