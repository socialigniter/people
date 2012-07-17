<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* People Library
*
* @package		Social Igniter
* @subpackage	People Library
* @author		Brennan Novak
*
* Contains methods for People App
*/

class People_library
{
	function __construct()
	{
		// Global CodeIgniter instance
		$this->ci =& get_instance();

	}
	
	/* Interact with Data_Model */
	function my_custom_method($data_id)
	{
		return $this->ci->people_model->get_data($data_id);
	}

}