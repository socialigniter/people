<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : People : Controller
* Author: 		Brennan Novak
* 		  		hi@brennannovak.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the public People Controller class
*/
class People extends Site_Controller
{
    function __construct()
    {
        parent::__construct();

		if (config_item('people_enabled') != 'TRUE') redirect(base_url());
	}

	function index()
	{
		$this->data['users']		= $this->social_auth->get_users('active', 1);
 		$this->data['page_title'] 	= "People";
	
		$this->render('wide');	
	}
	
 	function profile()
 	{
		if (!$this->uri->segment(2)) redirect(base_url());	 	
 	
		$timeline_view = null;
		$this->user = $this->social_auth->get_user('username', $this->uri->segment(2), TRUE); 
 	
		if($this->user)
		{
	 		$this->user_meta				= $this->social_auth->get_user_meta($this->user->user_id);		
		
			// User Data
			$this->data['user_id'] 			= $this->user->user_id;	
			$this->data['username'] 		= $this->user->username;
			$this->data['gravatar'] 		= $this->user->gravatar;
			$this->data['name'] 			= $this->user->name;
			$this->data['image'] 			= $this->social_igniter->profile_image($this->user->user_id, $this->user->image, $this->user->gravatar, 'large');; 
			$this->data['created_on'] 		= $this->user->created_on;
			
			// Meta Tags			
			$this->data['site_image']		= base_url().config_item('users_images_folder').$this->user->user_id.'/large_'.$this->user->image;
			
			// User Meta
			$this->data['company']			= $this->social_auth->find_user_meta_value('company', $this->user_meta);
			$this->data['location']			= $this->social_auth->find_user_meta_value('location', $this->user_meta);
			$this->data['url']				= $this->social_auth->find_user_meta_value('url', $this->user_meta);
			$this->data['bio']				= $this->social_auth->find_user_meta_value('bio', $this->user_meta);
			
			// Social Connections
			$this->data['connections']		= $this->social_auth->get_connections_user($this->user->user_id);
			
			// Relationships
			$this->data['followers']		= $this->social_tools->get_relationships_user($this->user->user_id, 'users', 'follow');
			$this->data['follows']			= $this->social_tools->get_relationships_owner($this->user->user_id, 'users', 'follow');
			$this->data['follow_word']		= 'follow';			

			// Links
			if ($this->social_auth->logged_in())
			{
				if ($follow_check = $this->social_tools->check_relationship_exists(array('site_id' => config_item('site_id'), 'owner_id' => $this->session->userdata('user_id'), 'user_id' => $this->user->user_id, 'module' => 'users', 'type' => 'follow', 'status' => 'Y')))
				{
			 		$this->data['follow_word']	= 'unfollow';
				}
				else
				{
			 		$this->data['follow_word']	= 'follow';				
				}	
			}
			
	 		$this->data['message_url'] 		= base_url().'api/message/send/id/'.$this->user->user_id;
	 		
			// Sidebar
			$this->data['sidebar_profile'] = $this->load->view(config_item('site_theme').'/partials/sidebar_profile.php', $this->data, true);	
			
			// Timeline 		
			$timeline 							= $this->social_igniter->get_timeline_user($this->user->user_id, 8);
			$timeline_view 						= NULL;	
			$timeline_count						= 1;
			$this->data['activities']			= array();
			$this->data['social_igniter']		= $this->social_igniter;
					 			
			if (!empty($timeline))
			{
				foreach ($timeline as $activity)
				{	
					$timeline_count++;
						
					// Item
					array_push($this->data['activities'], $activity);
					$this->data['item_id']				= $activity->activity_id;
					$this->data['item_type']			= item_type_class($activity->type);
					// Contributor
					$this->data['item_user_id']			= $activity->user_id;
					$this->data['item_avatar']			= $this->social_igniter->profile_image($activity->user_id, $activity->image, $activity->gravatar, 'medium');
					$this->data['item_contributor']		= $activity->name;
					$this->data['item_profile']			= base_url().'profile/'.$activity->username;
					
					// Activity
					$this->data['item_content']			= $this->social_igniter->render_item($activity);
					$this->data['item_content_id']		= $activity->content_id;
					$this->data['item_date']			= format_datetime(config_item('home_date_style'), $activity->created_at);			

			 		// Actions
				 	$this->data['item_comment']			= base_url().'comment/item/'.$activity->activity_id;
				 	$this->data['item_comment_avatar']	= $this->data['logged_image'];


				 	$this->data['item_can_modify']		= $this->social_auth->has_access_to_modify('activity', $activity, $this->session->userdata('user_id'), $this->session->userdata('user_level_id'));			 	
					$this->data['item_edit']			= base_url().'home/'.$activity->module.'/manage/'.$activity->content_id;
					$this->data['item_delete']			= base_url().'status/delete/'.$activity->activity_id;

					// View
					$timeline_view  .= $this->load->view(config_item('site_theme').'/partials/user_timeline.php', $this->data, true);
		 		}
		 	}
		 	else
		 	{
		 		$timeline_view = '<li>Nothing to show from anyone!</li>';
	 		}		
		}
		else
		{
			redirect(404);
		}

		$this->data['timeline_view'] 	= $timeline_view;
 		$this->data['timeline_count']	= $timeline_count; 	 	
 		$this->data['page_title'] 		= $this->data['name']."'s profile";
		$this->render('profile');
 	}

 	function feed()
 	{
 		$this->output->set_header('Content-type:application/atom+xml');
 		$this->load->view('site_default/partials/feed', $this->data);
 	}

 	function add_friend()
 	{
 		$this->data['webfinger'] = $this->uri->segment(4);
 		$this->render('profile');
 	}
 	
 	function image()
 	{
 		$this->data['page_title'] = $this->data['name']."'s profile picture";	
 		$this->render('profile');
 	}
 	
    /* Webfinger */
    function webfinger() {
    	$this->data['this'] = $this;
    	$this->load->view(config_item('site_theme').'/partials/webfinger', $this->data);
    }

    function webfinger_user()
    {
    	$uri = $this->uri->segment(2);
    	preg_match('/@/', $uri, $matches);
    	
    	if ($matches)
    	{
    		preg_match('/(acct:|^)(.*?)@/',$uri, $matches);
    		$username = $matches[2];
    		$this->data['uri'] = $uri;
	    	$this->data['username'] = $username;
	    	$user = $this->social_auth->get_user('username', $username); 
			
			if ($user)
			{
				$connections = $this->social_auth->get_connections_user($user->user_id); 		
			}
			
			foreach ($connections as $connection)
			{
				if ($connection->module == "twitter")
				{
					$screen_name = $connection->connection_username;
				}
				elseif ($connection->module == "facebook")
				{
					$screen_name = $connection->connection_username;
				}
			}
			
			if (isset($screen_name))
			{
				$this->data['screen_name'] = $screen_name;
			}

	    	$this->load->view(config_item('site_theme').'/partials/webfinger_user', $this->data);
		}
		else
		{
			$this->error_404();
		}
    } 

    
    /* Widgets */
    function widgets_new_people($widget_data)
    {
		$widget_data['users'] = $this->social_auth->get_users('active', 1);

		$this->load->view('widgets/new_people', $widget_data);
    }

}
