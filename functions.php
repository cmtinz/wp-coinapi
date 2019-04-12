<?php 

wp_enqueue_style( 'style', get_stylesheet_uri() );
wp_enqueue_script( 'icon-scripts', get_stylesheet_directory_uri() . "/main.js", array('jquery'), false, true );

 ?>