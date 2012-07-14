<?php 
/*
Plugin Name: Hustream Video Embed
Plugin URI: http://www.hustream.com
Description: Embed Hustream Interactive Videos
Author: Michael Hunter & Brent Luehr
Version: 1.0
Author URI: http://www.mikehunter.ca
*/

add_action('init', 'hustream_player');



// Scripts


function hustream_css_files(){
	    wp_deregister_style( 'hustream-style' );
	 	wp_register_style( 'hustream-style', plugins_url('/css/hustream-wp-styles.css', __FILE__) );
        wp_enqueue_style( 'hustream-style' );
	}
	
add_action( 'wp_enqueue_scripts', 'hustream_css_files' );

function hustream_javascript_files() {
	// jquery
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
	
	// hustream player
    wp_deregister_script( 'hs_player' );
    wp_register_script( 'hs_player', 'http://shared.ec2.hustream.com/player/v3/class.hs_player.js');
    wp_enqueue_script( 'hs_player', NULL, NULL, NULL, true);
	
	// swfobject 
	wp_deregister_script( 'swfobject' );
    wp_register_script( 'swfobject', 'http://shared.ec2.hustream.com/page/js/swfobject.js');
    wp_enqueue_script( 'swfobject');
	
}    
 
add_action('wp_enqueue_scripts', 'hustream_javascript_files');



function hustream_player() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_plugin' );
     add_filter( 'mce_buttons', 'register_button' );
   }
 
}

function register_button( $buttons ) {
 array_push( $buttons, "|", "hustream_embed" );
 return $buttons;
}

function get_id(){
	if(isset($_SESSION['hs_player_id']) and !empty($_SESSION['hs_player_id'])){
		$id = intval($_SESSION['hs_player_id'])+1;
		$_SESSION['hs_player_id'] = $id;
		return $id;
	}
	else {
		$_SESSION['hs_player_id'] = 1;
		return intval($_SESSION['hs_player_id']);
		}
	}

function player_div($args){
	// Settings
		$size = explode('x',$args['size']);
		$width = intval($size[0]);
		$height = intval($size[1]);

	$keyboard = intval($args['keyboard']);
	$resume = intval($args['resume']);
	$sharing = intval($args['sharing']);
	$path = $args['url'];
	$id = 'hu_player'.get_id();
	// Div	
	$return =  '<div id="'.$id.'" class="hustream-player">';
	$return .= '<video class="conversational-video" width="'.$width.'" height="'.$height.'"></video>';
	$return .= '</div>';
	// Javascript
	$return .='<script language="javascript">';
	$return .='jQuery(document).ready(function() {';
	$return .= 'jQuery("#'.$id.'").hsPlayer({ "app-path": "'.$path.'", "keyboardControl": '.$keyboard.', "resumeSupport": '.$resume.', "sharing": '.$sharing.'});});';
	$return .='</script>';
	return $return;
	}

function add_plugin( $plugin_array ) {
   $plugin_array['hustream_embed'] = '/wp-content/plugins/hustream/js/player.js';
   return $plugin_array;
}

function hustream_embed( $atts ) {
	return player_div($atts);
}
add_shortcode( 'hustream', 'hustream_embed' );