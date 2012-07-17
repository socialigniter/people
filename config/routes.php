<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : People : Routes
* Author: 		Brennan Novak
* 		  		hi@brennannovak.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	URI Routes for People for Social Igniter 
*/

$route['people/:any/image'] 				= 'people/image';
$route['people/:any/add_friend/:any']		= 'people/add_friend';
$route['people/:any/feed']					= 'people/feed';
$route['people/:any'] 						= 'people/profile';
$route['people'] 							= 'people/index';
