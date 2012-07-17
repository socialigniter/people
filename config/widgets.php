<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : People : Widgets
* Author: 		Brennan Novak
* 		  		hi@brennannovak.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	Installer values for People for Social Igniter 
*/

$config['people_widgets'][] = array(
	'regions'	=> array('sidebar','content','wide','leftbar','middle'),
	'widget'	=> array(
		'module'	=> 'people',
		'name'		=> 'New People',
		'method'	=> 'run',
		'path'		=> 'widgets_new_people',
		'multiple'	=> 'FALSE',
		'order'		=> '1',
		'title'		=> 'New People',
		'content'	=> 'Check out the most recent people who have joined this site
	)
);