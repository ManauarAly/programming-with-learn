<?php

require_once('opentok.phar');
    /**
	 * @wordpress-plugin
	 * Plugin Name:       Mobile app API
	 * Description:       All functions which is used in mobile app.(14-Jan-2020)
	 * Version:           1.0
	 * Author:            SU
	*/
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\OutputMode;
use OpenTok\Session;
use OpenTok\Role;

use OpenTok\Util\Client;
use OpenTok\Util\Validators;

use OpenTok\Archive;
use OpenTok\Broadcast;
use OpenTok\Layout;
use OpenTok\Exception\UnexpectedValueException;
use OpenTok\Exception\InvalidArgumentException;	
	
function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyAG3AFq6Amp1sm0cgcAz7A0WjjySOE89h4');
}

add_action('acf/init', 'my_acf_init');
	
	header('Access-Control-Allow-Origin: *');
	add_action('rest_api_init', function (){
		remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
		add_filter('rest_pre_serve_request', function ($value){
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
			header('Access-Control-Allow-Credentials: true');
			return $value;
		});
	}
	, 15);
	//require_once('vendor/autoload.php');
	use \Firebase\JWT\JWT;
    
	
	// If this file is called directly, abort.
	if(!defined('WPINC')){
		die;
	}
	
	$API_KEY='46868504';
    $API_SECRET='234321558e4f02b54c3ffbe3c4ef08663bda30c7';


    global $apiObj;
    $apiObj = new OpenTok($API_KEY, $API_SECRET);

	function ba_jwt_auth_expire($issuedAt){
		return $issuedAt + (999999 * 1000);
	}
	   //Include All Files here then you will be able to user class & their functions
    include('custom-classes/class_collection.php');
    
	add_filter('jwt_auth_expire', 'ba_jwt_auth_expire');
    add_action('rest_api_init', function (){
        register_rest_route('mobileapi/v1', '/register', array(
            'methods' => 'POST',
            'callback' => 'MobileApiMakeNewAuthor',
        ));
        register_rest_route( 'mobileapi/v1/', '/updateDeviceToken', array(
            'methods'   => 'POST', 
            'callback'  => 'updateDeviceToken' 
        ));
        register_rest_route('mobileapi/v1', '/validate_token',array(
            'methods'   => 'POST',
            'callback'  => 'validate_token',
        ));
        
        //This Endpoint returned a Doctor List
        register_rest_route('mobileapi/v1', '/get_doctor', array(
            'methods'   => 'GET',
            'callback'  => 'get_doctor_callback',
        ));
        
        //This Endpoint returned a Doctor List
        register_rest_route('mobileapi/v1', '/get_surgery', array(
            'methods'   => 'GET',
            'callback'  => 'get_surgery_callback',
        ));
        
        //This Endpoint returned a Doctor List
        register_rest_route('mobileapi/v1', '/get_sub_surgery', array(
            'methods'   => 'POST',
            'callback'  => 'get_sub_surgery_callback',
        ));
    
        //This Endpoint returned a Doctor List
        register_rest_route('mobileapi/v1', '/get_body_parts', array(
            'methods'   => 'GET',
            'callback'  => 'get_body_parts_callback',
        ));
        
        //This Endpoint returned a Doctor List
        register_rest_route('mobileapi/v1', '/get_rehabs', array(
            'methods'   => 'POST',
            'callback'  => 'get_rehabs_callback',
        ));
        
         register_rest_route('mobileapi/v1', '/get_rehabs_diagnosis', array(
            'methods'   => 'POST',
            'callback'  => 'get_rehabs_diagnosis_callback',
        ));
        
        //Change Password
        register_rest_route('mobileapi/v1', '/change_password', array(
            'methods'   => 'POST',
            'callback'  => 'change_password_callback',
        ));
        
        register_rest_route('mobileapi/v1', '/Validate_surgery_selector', array(
            'methods'   => 'POST',
            'callback'  => 'validate_surgery_selector_callback',
        ));
        
        register_rest_route('mobileapi/v1', '/validate_surgery', array(
            'methods'   => 'POST',
            'callback'  => 'validate_surgery_callback',
        ));
        
        register_rest_route('mobileapi/v1', '/add_surgery', array(
            'methods'   => 'POST',
            'callback'  => 'add_surgery_callback',
        ));

        register_rest_route('mobileapi/v1', '/home_page_content', array(
            'methods'   => 'GET',
            'callback'  => 'home_page_content_callback',
        ));

        register_rest_route('mobileapi/v1', '/faq', array(
            'methods'   => 'POST',
            'callback'  => 'faq_callback',
        ));
        register_rest_route('mobileapi/v1', '/updateProfile', array(
            'methods'   => 'POST',
            'callback'  => 'updateProfile_callback',
        ));
        
         register_rest_route('mobileapi/v1', '/veiw_surgery', array(
            'methods'   => 'POST',
            'callback'  => 'veiw_surgery_callback',
        ));
        
        register_rest_route('mobileapi/v1', '/veiw_dignosis', array(
            'methods'   => 'POST',
            'callback'  => 'veiw_dignosis_callback',
        ));
        
        register_rest_route( 'mobileapi/v1/', '/get_about_us', array(
           'methods' => 'GET', 
           'callback' => 'get_about_us_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/get_staff_clients', array(
           'methods' => 'GET', 
           'callback' => 'get_staff_clients_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/get_resources', array(
           'methods' => 'POST', 
           'callback' => 'get_resources_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/change_user', array(
           'methods' => 'POST', 
           'callback' => 'change_user_callback' 
        ));
        register_rest_route( 'mobileapi/v1/', '/user_timelines', array(
           'methods' => 'POST', 
           'callback' => 'user_timelines_callback' 
        ));
        register_rest_route( 'mobileapi/v1/', '/getCaregivers', array(
           'methods' => 'POST', 
           'callback' => 'getCaregivers_callback' 
        ));
        register_rest_route( 'mobileapi/v1/', '/task_for_day', array(
           'methods' => 'POST', 
           'callback' => 'task_for_day_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/timeline_complete_tasks', array(
           'methods' => 'POST', 
           'callback' => 'timeline_complete_tasks_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/view_staff_assign_client', array(
           'methods' => 'GET', 
           'callback' => 'view_staff_assign_client_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/view_assigned_client_timeline', array(
           'methods' => 'GET', 
           'callback' => 'view_assigned_client_timeline_callback' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/updateDeviceToken', array(
            'methods' => 'POST', 
            'callback' => 'updateDeviceToken' 
        )); 
        
        register_rest_route( 'mobileapi/v1/', '/test_browser_notification', array(
            'methods' => 'POST', 
            'callback' => 'test_browser_notification' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/send_chat_messages_notifications', array(
            'methods' => 'POST', 
            'callback' => 'send_chat_messages_notifications' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/change_timeline_date', array(
            'methods' => 'POST', 
            'callback' => 'change_timeline_date' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/get_message_users', array(
            'methods' => 'GET', 
            'callback' => 'get_message_users' 
        ));
        
        register_rest_route( 'mobileapi/v1/', '/getSecoondUserInfo', array(
           'methods'    => 'POST', 
           'callback'   => 'getSecoondUserInfo' 
        ));
        
        register_rest_route('mobileapi/v1/', '/create_session', array(
            'methods'   => 'POST',
            'callback'  => 'createSession',
        ));

        register_rest_route('mobileapi/v1/', '/end_session', array(
            'methods'   => 'POST',
            'callback'  => 'endSession',
        ));
        
        register_rest_route('mobileapi/v1/', '/block_unblock_user', array(
            'methods'   => 'POST',
            'callback'  => 'block_unblock_user',
        ));
        
        register_rest_route('mobileapi/v1/', '/get_admin_contact_number', array(
            'methods'   => 'GET',
            'callback'  => 'get_admin_contact_number',
        ));
    });
 
 
add_shortcode('changerole', 'change_role');
 //------------------[End API]{change_user}--------------------------
 
   
   //[START]=> This allow to see all PHP error
    function custom_error($status = true){
        if($status == true){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }
    //[END]=> This allow to see all PHP error

    function get_weekno_of_date($date1, $date2){
        $date1 = date('Y-m-d', strtotime($date1));
        $date2 = date('Y-m-d', strtotime($date2));
        $first  = DateTime::createFromFormat('Y-m-d', $date1);
        $second = DateTime::createFromFormat('Y-m-d', $date2);
        if($date1 > $date2){
            return get_weekno_of_date($date2,$date1);
        }
        //Total Days between these two dates
        $total_days = $first->diff($second)->days;
        
        //No of week between these two dates
        $week_counter = floor($total_days/7);
        $remain_days = $total_days % 7;
        if($remain_days>0){
            $week_counter = $week_counter+1;
        }
        return $week_counter;
    }
    
    class Custom_User{
        function get_userInfo_byId($user_id, array $arg = null){
            $data = array();
            $userinfo = get_userdata($user_id);
            $data['role'] = $userinfo->roles[0];
            $first_name = get_user_meta($user_id, "first_name", true);
            if (!empty($first_name)){
                $data['user_display_name'] = ucfirst($first_name);
            }else{
                $data['user_display_name'] = ucfirst($data['user_display_name']);
            }
            $data['user_id']    = $user_id;
            $data['user_email'] = $userinfo->user_email;
            $data['first_name'] = get_user_meta($user_id,'first_name',true);
            $data['last_name']  = get_user_meta($user_id,'last_name',true);
            $data['phone']      = get_user_meta($user_id,'phone_number',true); 
            $data['address']    = get_user_meta($user_id,'address',true);
            $data['city']    = get_user_meta($user_id,'city',true);
            $data['state']    = get_user_meta($user_id,'state',true);
            $data['bio']    = get_user_meta($user_id,'description',true);
            $data['zip']    = get_user_meta($user_id,'zip',true);
            
            $useravatar = get_user_meta($user_id, 'wp_user_avatar', true);
            if($useravatar){
                $img = wp_get_attachment_image_src($useravatar, array('150','150') , true);
                $data['user_img'] = $img[0];
            }else{
                $data['user_img'] = 'http://1.gravatar.com/avatar/1aedb8d9dc4751e229a335e371db8058?s=96&d=mm&r=g';
            }
            return $data;
        }
    }
    global $user_obj;
    $user_obj = new Custom_User();
    
    
    class Rehabs extends Surgery{
        
        function get_rehab_by_surgeryId($surgery_id = null, $surgery_date = null, array $arg = null){
            $response = array();
            $surgery_date = date('Y-m-d',strtotime($surgery_date));
            $parameters = array(
                'post_type'     => array('rehab'),
                'posts_per_page'=> -1,
                'post_status'   => 'publish',
                'meta_query' => array(
                    array(
                        'key'     => 'surgery_id',
                        'value'   => $surgery_id,
                        'compare' => '=',
                    ),
                ),
            );
            $all_results = get_posts($parameters);
          
            if(count($all_results)>0){
                $arg['date'] = $surgery_date;
                foreach($all_results as $row){
                    $rehab_id = $row->ID;
                    $res  = $this->get_rehab_by_id($rehab_id,$arg);
                    //  print_r($res);
                    $response[] = $res;
                }
                if(count($response)>0){
                    return $response;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }
        
        function get_dignosis_by_surgeryId($surgery_id = null, $surgery_date = null, array $arg = null){
            $response = array();
            $surgery_date = date('Y-m-d',strtotime($surgery_date));
            $parameters = array(
                'post_type'     => array('diagnosis'),
                'posts_per_page'=> -1,
                'post_status'   => 'publish',
                'meta_query' => array(
                    array(
                        'key'     => 'surgery_id',
                        'value'   => $surgery_id,
                        'compare' => '=',
                    ),
                ),
            );
            $all_results = get_posts($parameters);
          
            if(count($all_results)>0){
                $arg['date'] = $surgery_date;
                foreach($all_results as $row){
                    $rehab_id = $row->ID;
                    $res  = $this->get_rehab_by_id($rehab_id,$arg);
                    //  print_r($res);
                    $response[] = $res;
                }
                if(count($response)>0){
                    return $response;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }
        
        //Get Rehabs Data by rehab_id(post_id)
        function get_rehab_by_id($rehab_id = null, array $arg = null){
            // echo $rehab_id;
            $response = array();
            // $parameters = array(
            //     'ID'        => $rehab_id,
            //     'post_type' => 'rehab'
            // );
            $row = get_post($rehab_id);
           
            if(count($row)>0){
                $response['rehab_id'] = $row->ID;
                $surgery_id = get_post_meta($response['rehab_id'],'surgery_id',true);
                $post_date = $row->post_date;
               
                if(isset($arg['date']) && !empty($arg['date'])){
                    $surgery_date = $arg['date'];
                }
                $response['active_week'] = "";
                $response['surgery_id']     = $surgery_id;
                $response['surgery_name']   = get_the_title($surgery_id);
                $response['surgery_date']   = date('F,j Y',strtotime($surgery_date));
                
                $surgery_information = get_post($surgery_id);
                $content = $surgery_information->post_content;
                $response['surgery_info']   = $content;
                $response['post_type']      = $row->post_type;
                $response['post_title']     = $row->post_title;
                $response['post_name']      = $row->post_name;
                $response['post_content']   = $row->post_content;
                $response['post_author']    = $row->post_author;
                $response['post_parent']    = $row->post_parent;
                $response['post_status']    = $row->post_status;
                $response['comment_status'] = $row->comment_status;
                $response['post_date']      = $post_date;
                $response['post_modified']  = $row->post_modified;
                
                $Timeline = $this->get_weeks_by_postId($response['rehab_id'],$weekno);
                if(isset($arg['timelines']) && $arg['timelines'] == true){
                    $weekno = 0;
                    if(isset($arg['weekno']) && $arg['weekno'] == true){
                        $weekno = $arg['weekno'];
                    }
                    
                    // For Extra Week
                    //$tmp1[] = array('title'=>"Blank","sub_title"=>"blank","cover_image"=>"blank","instructions"=>array());
                    $response['timelines'] =$Timeline;
                }
                $total_timelime_weeks = count($Timeline);
                
                $current_date = date('Y-m-d');
                $active_week_number = get_weekno_of_date($current_date,$surgery_date);
                if($active_week_number==0){
                    $active_week_number=1;
                }
                $response['active_week'] = ($active_week_number>=$total_timelime_weeks)? "Completed" : $active_week_number;
                $response['completed_message'] = "You have completed your rehab week successfully.";
            }
            return $response;
        }
        
        //Getting All rehabs
        function get_all_rehabs(array $arg = null){
            $response = array();
            $args1 = array('post_type'=>'rehab');
            $results = get_posts($args1);
            if(count($results)>0){
                foreach($results as $row){
                    $rehab_id = $row->ID;
                    $single_regab_data = $this->get_rehab_by_id($rehab_id,$arg);
                    $response[] = $single_regab_data;
                }
            }
            return $response;
        }
        
        //Getting Values Of Repeaters by RRehab_id (Post_id)
        function get_weeks_by_postId($rehab_id = null,$weekno = null, array $arg = null){
           
            $response = array();
            $all_weeks = get_field('weeks',$rehab_id);
            
            if(isset($all_weeks[($weekno-1)])){
                $specific_week = $all_weeks[($weekno-1)];
                unset($all_weeks);
                $all_weeks[] = $specific_week;
               
            }
            
            foreach($all_weeks as $week){
                $tmp1 = array();
               
                $tmp1['title']       = $week['title'];
                $tmp1['sub_title']   = $week['sub_title'];
               if($week['cover_image']>0){
                     $img = wp_get_attachment_image_src($week['cover_image'],'medium', true);
                     $tmp1['cover_image'] =$img[0];
                    }else{
                       $tmp1['cover_image'] = "";//site_url("wp-content/uploads/2020/03/placeholder.jpg");  
                    }
                
                $inst_data   = $week['instructions'];
                $all_instructions = array();
                
                $week_counter = 0;
                foreach($inst_data as $instruction){
                    $tmp2 = array();
                    $media_url = null;
                    $tmp2['title'] = $instruction['title'];
                    $tmp2['type'] = $instruction['types'];
                    if($instruction['cover_image']>0){
                    $img_l = wp_get_attachment_image_src($instruction['cover_image'], array('150','150') , true);
                    $img_2 = wp_get_attachment_image_src($instruction['cover_image'],"medium" , true);
                    $tmp2['cover_image'] = $img_l[0];
                    $tmp2['large_image'] = $img_2[0];
                    }else{
                       $tmp2['cover_image'] =site_url("wp-content/uploads/2020/03/placeholder.jpg");  
                       $tmp2['large_image'] = site_url("wp-content/uploads/2020/03/placeholder.jpg");  
                    }
                   
                    //If Instruction Type is Images
                    if($tmp2['type'] == 'Image'){
                        $attachment_id = $instruction['image'];
                        $media_url =wp_get_attachment_url($attachment_id);// "Image URL";
                       
                    }
                    
                     if($tmp2['type'] == 'PDF'){
                        $attachment_id = $instruction['pdf'];
                        $media_url =wp_get_attachment_url($attachment_id);// "Image URL";
                         $tmp2['donloadfilename'] =basename($media_url);
                        
                    }
                    
                    //If Instruction Type is Video
                    elseif($tmp2['type'] == 'Video'){
                        $attachment_id = $instruction['video'];
                        $media_url = wp_get_attachment_url($attachment_id);//"Video URL";
                    }
                    $tmp2['media_url'] = $media_url;
                     if($tmp2['type'] == 'PDF'){
                          $tmp2['description']='';
                     }else{
                       $tmp2['description'] = substr($instruction['description'], 0, 35).'...';
                     }
                    $tmp2['full_description'] =$instruction['description'];
                    // $tmp2['description'] = "description";
                    
                    $all_instructions[] = $tmp2;
                    $week_counter++;
                }
                $tmp1['instructions'] = $all_instructions;
               
                
                $response[] = $tmp1;
            }
            //  print_r($weeks_res);
            return $response;
        }
    }
 
    //[START]=> Update User Profile
    function updateProfile_callback($request){
        $data = array('status'=> "success","msg"=>"","error_code"=>"");
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
            $data['token'] = $param['token'];
            if(isset($param['first_name']) && !empty($param['first_name'])){
                update_user_meta($user_id,'first_name',$param['first_name']);
            }
            if(isset($param['last_name']) && !empty($param['last_name'])){
                update_user_meta($user_id,'last_name',$param['last_name']);
            }
            if(isset($param['phone']) && !empty($param['phone'])){
                update_user_meta($user_id,'phone_number',$param['phone']);
            }
            if(isset($param['address']) && !empty($param['address'])){
                update_user_meta($user_id,'address',$param['address']);
            }
            if(isset($param['city']) && !empty($param['city'])){
                update_user_meta($user_id,'city',$param['city']);
            }
            if(isset($param['state']) && !empty($param['state'])){
                update_user_meta($user_id,'state',$param['state']);
            }
            if(isset($param['bio']) && !empty($param['bio'])){
                update_user_meta($user_id,'description',$param['bio']);
            }
            if(isset($param['profileImg']) && !empty($param['profileImg'])){
                // update_user_meta($user_id,'city',$param['city']);
                $profileImg = $param['profileImg'];
                
                //HANDLE UPLOADED FILE
                $upload_dir = wp_upload_dir();
                $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
                $image_parts = explode(";base64,",$profileImg);
                $decoded = base64_decode($image_parts[1]);
                $filename = 'wigo.png';
               $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
                $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded ); 
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            
            
                    // Without that I'm getting a debug error!?
                    $file             = array();
                    $file['error']    = '';
                    $file['tmp_name'] = $upload_path . $hashed_filename;
                    $file['name']     = $hashed_filename;
                    $file['type']     = 'image/png';
                    $file['size']     = filesize( $upload_path . $hashed_filename );
                    // upload file to server
            
                    // use $file instead of $image_upload
                    $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );
                    $filename = $file_return['file'];
                    $attachment = array(
                     'post_mime_type' => $file_return['type'],
                     'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                     'post_content' => '',
                     'post_status' => 'inherit',
                     'guid' => $wp_upload_dir['url'] . '/' . basename($filename)
                     );
                    $attach_id = wp_insert_attachment( $attachment, $filename );
                       /// generate thumbnails of newly uploaded image
                       $attachment_meta = wp_generate_attachment_metadata($attach_id, $filename );
                        wp_update_attachment_metadata($attach_id,$attachment_meta);
                        set_post_thumbnail($post_id,$attach_id);
                    update_user_meta($user_id,'wp_user_avatar',$attach_id);
            }
            global $user_obj;
            $userInfo = $user_obj->get_userInfo_byId($user_id);
            $data = array_merge($data,$userInfo);
            $data['msg'] = "User record is updated successfully.";
            return new WP_REST_Response($data, 200);
            // print_r($res);
        }else{
            $data['status'] = "error";
            $data['msg']    = "Invalid user";
            $data['error_code'] = "token_expired.";
            return new WP_REST_Response($data, 403);
        }
    }
    //[END]=> Update User Profile
 
    //[START]=> Change Password
    function change_password_callback($request){
        $data = array('status'=> "success","msg"=>"","error_code"=>"");
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
            if(!isset($param['password']) && empty($param['password'])){
                $data['status'] = "error";
                $data['msg'] = "missing parameter 'password'";
                $data['error_code'] = "'password' is missing";
                return new WP_REST_Response($data, 403);
            }
            if(!isset($param['oldPassword']) && empty($param['oldPassword'])){
                $data['status'] = "error";
                $data['msg'] = "missing parameter 'oldPassword'";
                $data['error_code'] = "'oldPassword' is missing";
                return new WP_REST_Response($data, 403);   
            }
            $new_password = $param['password'];
            $old_password = $param['oldPassword'];
            
            // Password must be strong
            if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$new_password) === 0){
                $errPass = 'Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit';
                $data['status'] = "error";
                $data['msg'] = $errPass;
                $data['error_code'] = "Password validation fail.";
                return new WP_REST_Response($data, 403);   
            }
            $user = get_user_by('ID',$user_id);
            if($user && wp_check_password($old_password,$user->data->user_pass,$user->ID)){
                if($old_password == $new_password){
                    $data['status'] = "error";
                    $data['msg'] = "Your new password is same as old password. Try another new password.";
                    $data['error_code'] = "'old_password' is missing";
                    return new WP_REST_Response($data, 403); 
                }else{
                    $success = wp_set_password( $new_password, $user_id );
                    $data['msg'] = "Your password is changed successfully.";
                    return new WP_REST_Response($data, 200);
                }
            }else{
                $data['status'] = "error";
                $data['msg'] = "Old Password is not match. Try Again";
                $data['error_code'] = "invalid_old_password.";
                return new WP_REST_Response($data, 403);
            }
        }else{
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "token_expired.";
            return new WP_REST_Response($data, 403);
        }
    }
    //[END]=> Change Password
 
 
    function veiw_surgery_callback($request){
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $data  = array("status" =>"ok","msg"=> "",'error_code'=>"");
        $param = $request->get_params();
        $rehab_obj = new Rehabs();
        $arg = array('timelines'=> true);
        $token = $param['token'];
        $sur_id = $param['sur_id'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
                $surgery_date   = NULL;
                $surgery_id     = $sur_id;
                $arg['date']    = NULL; 
                $all_rehabs = $rehab_obj->get_rehab_by_surgeryId($surgery_id,$surgery_date,$arg);
                $data['Rehabs'] = $all_rehabs;
                if(count($all_rehabs)>0){
                    $data['msg'] = "There are following rehabs.";
                    return new WP_REST_Response($data, 200);
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            
        }else{
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
         
    }
    
    function veiw_dignosis_callback($request){
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $data  = array("status" =>"ok","msg"=> "",'error_code'=>"");
        $param = $request->get_params();
        $rehab_obj = new Rehabs();
        $arg = array('timelines'=> true);
        $token = $param['token'];
        $sur_id = $param['sur_id'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
                $surgery_date   = NULL;
                $surgery_id     = $sur_id;
                $arg['date']    = NULL; 
                $all_rehabs = $rehab_obj->get_dignosis_by_surgeryId($surgery_id,$surgery_date,$arg);
                $data['Rehabs'] = $all_rehabs;
                if(count($all_rehabs)>0){
                    $attachment_id = get_post_meta($all_rehabs[0]['rehab_id'],'pdf',true);
                    if($attachment_id){
                    $media_url =wp_get_attachment_url($attachment_id);// "Image URL";
                    $data['media_url']=$media_url;
                    $data['donloadfilename'] =basename($media_url);
                   
                    $data['msg'] = "There are following rehabs.";
                    return new WP_REST_Response($data, 200);
                    }else{
                     $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                    }
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            
        }else{
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
         
    }
 
    //[START]=> Written For Get All Rehabs
    function get_rehabs_callback($request){
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $data  = array("status" =>"ok","msg"=> "",'error_code'=>"");
        $param = $request->get_params();
        $rehab_obj = new Rehabs();
        $arg = array('timelines'=> true);
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
            if(isset($param['weekno']) && !empty($param['weekno'])){
                $arg['weekno'] = $param['weekno'];
            }
            if(isset($param['rehab_id']) && !empty($param['rehab_id'])){
                $rehab_id     = $param['rehab_id'];
                $rehabs_results = $rehab_obj->get_rehab_by_id($rehab_id, array('timelines'=> true));
                $data['Rehabs'] = ($rehabs_results != false) ? $rehabs_results : array();;
                if($rehabs_results != false && count($rehabs_results)>0){
                    $data['msg'] = "There are some information of specific rehabs.";
                    return new WP_REST_Response($data, 200);
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            }
            if(isset($param['surgery_id']) && !empty($param['surgery_id'])){
                $surgery_id     = $param['surgery_id'];
                $surgery_date   = date('Y-m-d');
            }else{
                //If User Requested with 'date' parameterts
                $surgeryData = CheckUserHaveActiveSurgery($user_id);
                // print_r($surgeryData);
                $data['surgeryData'] = $surgeryData; 
                $surgery_date = $surgeryData->surgery_selector_date;
                $surgery_id = $surgeryData->surgery_selector_surgery_type;
            }
            if($surgery_id){
                $arg['date'] = $surgery_date; 
                $all_rehabs = $rehab_obj->get_rehab_by_surgeryId($surgery_id,$surgery_date,$arg);
                $data['Rehabs'] = ($all_rehabs != false) ? $all_rehabs : array();;
                if($all_rehabs != false && count($all_rehabs)>0){
                    $data['msg'] = "There are following rehabs.";
                    return new WP_REST_Response($data, 200);
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            
            }
            else{
                $data['status'] = "error";
                $data['msg'] = "Sorry, you have no active surgery.";
                $data['error_code'] = "no_active_surgery";
                return new WP_REST_Response($data, 403);
            }
            
        }else{
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
        
    }
    
     function get_rehabs_diagnosis_callback($request){
        // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $data  = array("status" =>"ok","msg"=> "",'error_code'=>"");
        $param = $request->get_params();
        $rehab_obj = new Rehabs();
        $arg = array('timelines'=> true);
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
            if(isset($param['weekno']) && !empty($param['weekno'])){
                $arg['weekno'] = $param['weekno'];
            }
            if(isset($param['rehab_id']) && !empty($param['rehab_id'])){
                $rehab_id     = $param['rehab_id'];
                $rehabs_results = $rehab_obj->get_rehab_by_id($rehab_id, array('timelines'=> true));
                $data['Rehabs'] = ($rehabs_results != false) ? $rehabs_results : array();;
                if($rehabs_results != false && count($rehabs_results)>0){
                    $data['msg'] = "There are some information of specific rehabs.";
                    return new WP_REST_Response($data, 200);
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            }
            if(isset($param['surgery_id']) && !empty($param['surgery_id'])){
                $surgery_id     = $param['surgery_id'];
                $surgery_date   = date('Y-m-d');
            }else{
                //If User Requested with 'date' parameterts
                $surgeryData = CheckUserHaveActiveSurgery($user_id);
                // print_r($surgeryData);
                $data['surgeryData'] = $surgeryData; 
                $surgery_date = $surgeryData->surgery_selector_date;
                $surgery_id = $surgeryData->surgery_selector_surgery_type;
            }
            if($surgery_id){
                $arg['date'] = $surgery_date; 
                $all_rehabs = $rehab_obj->get_rehab_by_surgeryId($surgery_id,$surgery_date,$arg);
                $data['Rehabs'] = ($all_rehabs != false) ? $all_rehabs : array();;
                if($all_rehabs != false && count($all_rehabs)>0){
                    $data['msg'] = "There are following rehabs.";
                    return new WP_REST_Response($data, 200);
                }else{
                    $data['msg'] = "There are no any rehabs.";
                    $data['error_code'] = "Rehab_not_exist.";
                    return new WP_REST_Response($data, 403);
                } 
            
            }
            else{
                $data['status'] = "error";
                $data['msg'] = "Sorry, you have no active surgery.";
                $data['error_code'] = "no_active_surgery";
                return new WP_REST_Response($data, 403);
            }
            
        }else{
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
        
    }
    //[END]=> Written For Get All Rehabs    
    
    /**************************************/
    //[START]=>Get all Body Part as well as specific body part
    function get_body_parts_callback($request){
        $param = $request->get_params();
        $body_part_list = array();
        $cat_args = array(
            'orderby'       => 'term_id', 
            'order'         => 'ASC',
            'hide_empty'    => false, 
        );
        if(isset($param['body_part_id']) && !empty($param['body_part_id'])){
            // Get term by id (''term_id'') in Categories taxonomy.
            $res1 = get_term_by('id',$param['body_part_id'],'body_parts');
            $body_parts_res[] = $res1;
        }else{
            $body_parts_res = get_terms('body_parts', $cat_args);
        }
        if(count($body_parts_res)> 0){
            foreach($body_parts_res as $k1){
                $tmp1 = array();
                $tmp1['body_part_id']   = $k1->term_id;
                $tmp1['name']           = $k1->name;
                $tmp1['description']    = $k1->description;
                $tmp1['taxonomy']       = $k1->taxonomy;
                $tmp1['parent']         = $k1->parent;
                $attachment_id = get_term_meta($k1->term_id,'image',true);
                $img_url       = wp_get_attachment_url($attachment_id);
                $tmp1['images']         = $img_url;
                $body_part_list[] = $tmp1;
            }
            $data['body_part_list'] = $body_part_list;  
            if(count($body_part_list)>=0){
                $data["msg"] = "There are following body part.";
                return new WP_REST_Response($data, 200);
            }else{
                $data["status"]     = "error";
                $data["msg"]        = "There is no any body part found.";
                $data["error_code"] = "body_part_not_exist.";
                return new WP_REST_Response($data, 403);
            }
        }else{
            $data["status"]     = "error";
            $data["msg"]        = "Body part are not found.";
            $data["error_code"] = "body_part_not_found.";
            return new WP_REST_Response($data, 403);
        }
    }
    //[END]=>Get all Body Part as well as specific body part
    /**************************************/
    
    
    /**************************************/
    //[START]=>Get all Sub Surgery of Specific Surgery By surgery_id
    function get_sub_surgery_callback($request){
        $data  = array(
            "status "   => "ok",
            "msg"       => "",
            'error_code'=> ""
        );
        $param = $request->get_params();
        if(!isset($param['surgery_id']) || empty($param['surgery_id']) || $param['surgery_id']=='' ){
            $data["status"] = "error";
            $data["msg"]    = "Missing parameter 'surgery_id'.";
            $data["error_code"] = "'surgery_id' is required.";
            return new WP_REST_Response($data, 403);
        }    
        $surgery_id = $param['surgery_id'];
        $wp_param = array(
            'numberposts'   => -1,
            'post_type'     => 'surgery',
            'post_parent'   => $surgery_id,
        );
        $results = get_posts($wp_param);
        if(count($results)>0){
            global $Surgery_obj;
            foreach($results as $k1){
                $res = $Surgery_obj->get_surgery_by_id($k1->ID, array('bodyparts'=> false,'sub_surgery'=> false));
                $sub_surgery[] = $res;
            }
        }
        $data['sub_surgery_list'] = $sub_surgery;
        if(count($sub_surgery)>0){
            $data["msg"] = "There are following sub surgery Exist.";
            return new WP_REST_Response($data, 200);
        }else{
            $data["status"] = "error";
            $data["msg"]    = "Sub-Surgery are not found.";
            $data["error_code"] = "sub-surgery_not_found.";
            return new WP_REST_Response($data, 403);
        }
    }
    //[END]=>Get all Sub Surgery of Specific Surgery By surgery_id
    /**************************************/
    
    
    /**************************************/
    //[START]=>Get all Surgery as well as specific Surgery with their all sub-surgery
    function get_surgery_callback($request){
        $data  = array(
            "status "   => "ok",
            "msg"       => "",
            'error_code'=> ""
        );
        $param = $request->get_params();
        $arg1 = array(
            'post_type'     => 'surgery',
            'post_status'   => 'publish',
            'post_parent'   => 0,
            'numberposts'   => -1,
            'order'         => 'ASC',
            'tax_query' => array(
            array(
                'taxonomy' =>'body_parts',
                'field' => 'term_id',
                'terms' =>array($param['body_id']),
                'operator' => 'IN',
            )
         )
        );
        if(isset($param['surgery_id']) && !empty($param['surgery_id']) && $param['surgery_id']!=''){
            $surgery_id = $param['surgery_id'];
            $arg1['ID']= $surgery_id;
        }
        $results = get_posts($arg1);
        if(count($results)>0){
            $surgery_list = array();
            foreach($results as $row1){
                $tmp = array();
                $surgery_id = $row1->ID;
                global $Surgery_obj;
                $results = $Surgery_obj->get_surgery_by_id($surgery_id,array('bodyparts'=> true));
                if(count($results)>0){
                    //$post_parent = $results['post_parent'];
                    $sub_surgery = $Surgery_obj->get_sub_surgery_by_surgery_id($surgery_id,array());
                    if(count($sub_surgery)>0){
                        $results['sub_surgery'] = $sub_surgery;
                    }else{
                        $results['sub_surgery'] =false ;
                    }
                    
                }
                $surgery_list[] = $results;
            }
            $data['surgery_list'] = $surgery_list;
            if(count($surgery_list)>0){
                $data["msg"] = "There are following doctor.";
                $data['arg1']=$arg1;
                return new WP_REST_Response($data, 200);
            }else{
                $data["status"]     = "error";
                $data["msg"]        = "No any surgery are found.";
                $data["error_code"] = "surgery_are_not_availble.";
                return new WP_REST_Response($data, 403);
            }
        }else{
            $data["status"] = "error";
            $data["msg"]    = "Surgery not founds. ";
            $data["error_code"] = "surgery_not_exist.";
            return new WP_REST_Response($data, 403);
        }
    }
    //[END]=>Get all Surgery as well as specific Surgery with their all sub-surgery
    /**************************************/
    
    
    /**************************************/
    //[START]=>Get all doctor as well as specific doctor
    function get_doctor_callback($request){
        $data  = array(
            "status "   => "ok",
            "msg"       => "",
            'error_code'=> ""
        );
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
        $arg1 = array(
            'post_type'     => 'doctor',
            'post_status'   => 'publish',
            'numberposts'   => -1,
            'order'         => 'ASC'
        );
        if(isset($param['doctor_id']) && !empty($param['doctor_id']) && $param['doctor_id']!=''){
            $doctor_id = $param['doctor_id'];
            $arg1['ID']= $doctor_id;
        }
        $results = get_posts($arg1);
        if(count($results)>0){
            $doctor_list = array();
            foreach($results as $row1){
                $tmp = array();
                $post_id = $row1->ID;
                $tmp['doctor_id']   = $post_id;
                $tmp['name']        = $row1->post_title;
                $tmp['specialist']  = get_post_meta($post_id,'doc_specialist',true);
                $tmp['email']       = get_post_meta($post_id,'doc_email',true);
                $tmp['phone']       = get_post_meta($post_id,'doc_phone',true);
                $tmp['address']     = get_post_meta($post_id,'doc_address',true);
                $tmp['content']     = $row1->post_content;
                $tmp['status']      = $row1->post_status;
                $tmp['register_date'] = $row1->post_date;
                $doctor_list[] = $tmp;
            }
            $data['doctor_list'] = $doctor_list;
            if(count($doctor_list)>0){
                $data["msg"] = "There are following doctor.";
                return new WP_REST_Response($data, 200);
            }else{
                $data["status"]     = "error";
                $data["msg"]        = "No any doctor are founds";
                $data["error_code"] = "doctor_are_not_availble.";
                return new WP_REST_Response($data, 403);
            }
        }else{
            $data["status"] = "error";
            $data["msg"]    = "Doctor not founds. ";
            $data["error_code"] = "doctor_not_exist.";
            return new WP_REST_Response($data, 403);
        }
    }
           $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "token_expired.";
            return new WP_REST_Response($data, 403);
    }
    
    //[END]=>Get all doctor as well as specific doctor
    /**************************************/
    
    
    function MobileApiMakeNewAuthor($request){
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $user_name = $param['email'];
        $user_email = $param['email'];
        $first_name = $param['first_name'];
        $last_name = $param['last_name'];
        $password = $param['password'];
        // JWT_AUTH_SECRET_KEY define in wp-config
        if ($param['jw_auth_sec'] != JWT_AUTH_SECRET_KEY) {
            $data['status'] = "error";
            $data['errormsg'] = __('cheating----.');
            $data['error_code'] = "token_error";
            $data['code'] = 403;
            return new WP_REST_Response($data, 403);
        }
        if (!is_email($user_email)) {
            $data['status'] = "error";
            $data['msg'] = "This is not a Valid Email.";
            $data['errormsg'] = __('This is not a Valid Email.');
            $data['error_code'] = "invalid_email";
            $data['code'] = 403;
            return new WP_REST_Response($data, 403);
        }
        $user_id = username_exists($user_name);
        if ($passowrd == " ") {
            $data['status'] = "error";
            $data['errormsg'] = __('Please provide password.');
            $data['error_code'] = "password_blank";
            $data['code'] = 403;
            return new WP_REST_Response($data, 403);
        }
        if (!$user_id and email_exists($user_email) == false) {
            //$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $user_id = wp_create_user($user_name, $password, $user_email);
            $user = new WP_User($user_id);
            $user->set_role('subscriber');
            $time = time().$user_id;
            $cp_token = md5($time);
            update_user_meta($user_id, 'cp_token', $cp_token);
            //approved
            update_user_meta($user_id, 'first_name',$first_name);
            update_user_meta($user_id, 'last_name',$last_name);
            update_user_meta($user_id, 'nickname', $first_name);
    
          $url = get_site_url(). '/verification/?cp='.$cp_token;
        // basically we will edit here to make this nicer
           $html='';
           $html.='Hi , '.$name;
           $html = 'Please click the following links to confirm your account. <br/><br/> <a href="'.$url.'">'.$url.'</a>';
        // send an email out to user
          add_filter('wp_mail_content_type', 'set_html_content_type');
            //wp_mail($user_email, __('Stealth Water Account Verification Email') , $html);
          remove_filter('wp_mail_content_type', 'set_html_content_type' );
            $data['msg'] = "Account created successfully.";
            $data['code'] = 200;
            return new WP_REST_Response($data, 200);
        } else {
            $data['status'] = "error";
            $data['msg'] = "Account exists with this email.";
            $data['errormsg'] = __('Account exists with this email.');
            $data['error_code'] = "user_already";
            $data['code'] = 403;
            return new WP_REST_Response($data, 403);
        }
    }

    function set_html_content_type() {
        return 'text/html';
    }

    //apply_filters('jwt_auth_token_before_dispatch', $data, $user);
    add_filter('jwt_auth_token_before_dispatch', 'mobileapi_jwt_auth_token_before_dispatch', 10, 2);
    function mobileapi_jwt_auth_token_before_dispatch($data, $user){
        $user_id = $user->ID;
        global $user_obj;
        $userInfo = $user_obj->get_userInfo_byId($user_id);
        $data = array_merge($data,$userInfo);
        return $data;
    }

    // Get User ID by token
    function GetMobileAPIUserByIdToken($token){
        $decoded_array = array();
        $user_id = 0;
        if($token){
            try{
                $decoded = JWT::decode($token, JWT_AUTH_SECRET_KEY, array('HS256'));
                $decoded_array = (array)$decoded;
                if(count($decoded) > 0){
                    $user_id = $decoded_array['data']->user->id;
                }
                if(user_id_exists($user_id)){
                    return $user_id;
                }else{
                    return false;
                }
            }catch(\Exception $e){
                // Also tried JwtException
                return false;
            }
        }
    }

    function user_id_exists($user){
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
        if($count == 1){ return true; }else{ return false; }
    }
    /* check user activation on login*/
    
    add_filter('wp_authenticate_user', 'isUserActivated');
    function isUserActivated($user){
        $userStatus = get_user_meta($user->ID, 'approved', true);
        if(metadata_exists('user', $user->ID, 'approved')){
            if (isset($userStatus) && $userStatus == 0){
                remove_action('authenticate', 'wp_authenticate_username_password', 20);
                $user = new WP_Error('denied', __("<strong>ERROR</strong>: Please verify your account."));
            }
        }
        return $user;
    }

    function validate_token($request){
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if ($user_id) {
            $res['status'] = "ok";
            return new WP_REST_Response($res, 200);
        } else {
            $res['status'] = "error";
            $res['msg'] = "Your session expired, please login again";
            return new WP_REST_Response($res, 200);
        }
    }
    
    function validate_surgery_selector_callback($request){
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if ($user_id) {
            $check=CheckUserHaveActiveSurgery($user_id);
            
            $data['dataCheck']=$check;
            $data['is_valid']=false;
            if(count($check) > 0){
               $data['is_valid']=true; 
            }
            return new WP_REST_Response($data, 200);
        } else {
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
    }
    
    function validate_surgery_callback($request){
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $token = $param['token'];
        
        $doctor_id = $param['doctor_id'];
        $date = $param['date'];
        $time = $param['time'];
        $body_id = $param['body_id'];
        $sur_id = $param['sur_id'];
        $data['valid']=false;
        $data['valid_msg']='';
        $user_id = GetMobileAPIUserByIdToken($token);
        if ($user_id) {
            if($doctor_id > 0){
            $data['info']['doctor']=get_post_meta($doctor_id,'doc_name',true);
            }else{
              $data['info']['doctor']='';
            }
            
            if($date!="null"){
            $data['info']['date']=date('F,j Y',strtotime($date));
            }else{
                $data['info']['date']="";
            }
            
            
            $data['info']['sugury']=get_the_title($sur_id);
            $data['info']['information']='';
            $term = get_term($body_id,'body_parts');
            $data['info']['body_part_name']=$term->name;
            $check=CheckUserHaveActiveSurgery($user_id);
            $data['has_selector']=false;
                if(count($check) > 0){
                      $data['has_selector']=true;
                }
            $data['valid']=true;
            $data['valid_msg']='';
            return new WP_REST_Response($data, 200);
        } else {
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }  
    }
    
    
    function add_surgery_callback($request){
      $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $token = $param['token'];
        
        $doctor_id = $param['doctor_id'];
        $date = $param['date'];
        $time = $param['time'];
        $body_id = $param['body_id'];
        $sur_id = $param['sur_id'];
        $data['valid']=false;
        $data['valid_msg']='';
        $user_id = GetMobileAPIUserByIdToken($token);
        if ($user_id) {
            global $wpdb;
            $checkData = CheckUserHaveActiveSurgery($user_id);
            if(count($checkData)>0){
               $wpdb->update('wp_surgery_selector',
            array(
                'surgery_selector_status'=>$sur_id,
              
            ),array("user_id"=>$user_id,"surgery_selector_id"=>$checkData->surgery_selector_id)); 
            }
            $insert = $wpdb->insert('wp_surgery_selector',
            array(
                'surgery_selector_date'=>$date,
                'surgery_selector_time'=>$time,
                'surgery_selector_doctor'=>$doctor_id,
                'surgery_selector_bodypart'=>$body_id,
                'surgery_selector_surgery_type'=>$sur_id,
                'user_id'=>$user_id,
                'surgery_selector_addeddate'=>date('Y-m-d h:i:s'),
            ));
            
            if($insert){
                $data['msg'] = "your surgery added successfully.";
             }else{
              $data['status'] = "error";
            $data['msg'] = "Something went wrong!!";
            $data['error_code'] = "db_error.";
            return new WP_REST_Response($data, 403); 
             }
            
           
            return new WP_REST_Response($data, 200);
        } else {
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }  
    }
    
    function CheckUserHaveActiveSurgery($user_id){
        $result=array();
        if($user_id){
            global $wpdb;
            $results = $wpdb->get_row("select * from wp_surgery_selector where `user_id`=".$user_id." and `surgery_selector_status`=0 ORDER BY `surgery_selector_id` DESC limit 1");
            if(count($results)>0){
              $result= $results; 
            }
            
        }
        return $result;
    }


    function home_page_content_callback($request){

        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");

        // getting home page banner
        $banner_images=get_field('banners', 'option');
        $data['banner_images']=array();
        if(count($banner_images)>0){
            foreach ($banner_images as $key => $image) {
                $data['banner_images'][]=array(
                    'id'     => $image['banner_image']['ID'],
                    'url'    => $image['banner_image']['url'],
                );
            }
        }


        // getting about us
        $about_us=get_field('about_us', 'option');
        $data['about_us']='';
        if($about_us!=''){
            $data['about_us']=$about_us;
        }

        // getting contact us
        $contact_us=get_field('contact_us', 'option');
        $data['contact_us']=array();
        if(!empty($contact_us)){
            $data['contact_us']=$contact_us;
        }

        return new WP_REST_Response($data, 200);
    }


    function faq_callback($request){
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");

        $posts=get_posts(array(
                'post_type' => 'faq_informarion'
            )
        );

        if(count($posts)>0){
            foreach ($posts as $key => $post) {
                $data['faq_contens'][]=array(
                    'ID'         => $post->ID,
                    'title'      => $post->post_title,
                    'content'    => $post->post_content
                );
            }
        }

        return new WP_REST_Response($data, 200);      
    }
    
    function get_about_us_callback($request){
        $data = array('code'=> '200', 'status'=> "ok", "msg"=>"", "error"=> "");
        $page_id = 7; 
        $page_data = get_page($page_id);
        $data['about_us'] = $page_data->post_content;
        return new WP_REST_Response($data, $data['code']); 
    }
    
    
    function get_staff_clients_callback($request){
        global $wpdb;
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
             //$args=array('role'  => 'subscriber');
            // $args  = array(
            //     'role'          => 'client',
            // );
            
            if($param['keyword']!='' && $param['keyword']!='undefined'){
                $keyword_arr= explode(" ", $param['keyword']);
                if(count($keyword_arr)>1){
                   $firstname=  $keyword_arr[0];
                   $lastname=  $keyword_arr[1];
                }else{
                   $firstname=  $param['keyword'];
                   $lastname=  $param['keyword'];
                }
                $args['meta_query']  = array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'first_name',
                        'value'   => trim($firstname),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'last_name',
                        'value'   => trim($lastname),
                        'compare' => 'LIKE'
                    ),
                );
            } else {
                $args['meta_query']  = array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'added_by',
                        'value'   => $user_id,
                        'compare' => '='
                    )
                );
            }
            $data['args']   = $args;
            $wp_user_query=new WP_User_Query($args);
		    $users=$wp_user_query->get_results();
		    $data['user_count']=count($users);
            if(count($users)>0){
                foreach($users as $user){
                    if (get_user_meta($user->ID, "first_name", true)!=''){
                        $userdata=get_userdata($user->ID);
                        $name = ucfirst(get_user_meta($user->ID, "first_name", true)).' '.ucfirst(get_user_meta($user->ID, "last_name", true));
                    }else{
                        $name = ucfirst($userdata->data->display_name);
                    }
                    
                    $useravatar = get_user_meta($user->ID, 'wp_user_avatar', true);
                    if($useravatar){
                        $img = wp_get_attachment_image_src($useravatar, array('150','150') , true);
                        $user_img = $img[0];
                    }else{
                        $user_img = 'http://1.gravatar.com/avatar/1aedb8d9dc4751e229a335e371db8058?s=96&d=mm&r=g';
                    }
                    
                    $block_status="select status from wp_user_block_unblock where blocked_by=".$user_id." and blocked_to=".$user->ID;
                    $result=$wpdb->get_results($block_status,ARRAY_A);
                    
                    if(get_user_meta($user->ID,'added_by',true)==$user_id){
                        $data['clients'][]=array(
                            'ID'            => $user->ID,
                            'name'          => $name,
                            'image'         => $user_img,
                            'role'          => $user->roles,
                            'is_blocked'    => (count($result)>0) ? $result[0]['status'] : 0
                        );
                    }
                }
                return new WP_REST_Response($data, 200);
            } else {
                $data['success_msg']="No Clients Found";
                return new WP_REST_Response($data, 200);
            }
        } else {
            
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }  
    }
    
    //Get Resources
    function get_resources_callback($request){
    $data  = array(
        "status" => "ok",
        "errormsg" => "",
        'error_code' => ""
    );
    $param = $request->get_params(); 
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token);  

    if($user_id){
        $args = array(
            'post_type' => 'resource',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        
       $posts = new WP_Query( $args );
    //   print_r($posts);exit;
        if ($posts ->post_count>0) {
            foreach ( $posts->posts as $post ) {
                 $res= get_field_objects($post->ID);
                 $upload_video=$res['upload_video']['value'];
                 $blog=$res['blog']['value'];
                 $pdf_id=$res['pdf']['value'];
                 $pdf= wp_get_attachment_url($pdf_id);
                 $upload_images=$res['upload_images']['value'];
                 
                //  print_r($res);exit;
                //  $attachment_id =   get_post_meta($post->ID,'upload_images',true);
                //  $image=wp_get_attachment_image_src($attachment_id);
                 
                //  $video_id =   get_post_meta($post->ID,'upload_video',true);
                //  $video=wp_get_attachment_url($video_id);
                 
                //  $pdf_id =   get_post_meta($post->ID,'pdf',true);
                 $data['resources'][]=array(
                    'title' => $post->post_title,
                    'ID' => $post->ID,
                    'blog' =>   get_post_meta($post->ID,'blog',true),
                    'pdf' =>  $pdf ,
                    'images' =>$upload_images,
                    'video' => $upload_video 
                    );
                }
                 $data['status']= 200;
            return new WP_REST_Response($data, 200);
        }
         
    }
    
    return new WP_REST_Response($data, 403);
    
   
}

// View Client Assign by Staff

    function view_staff_assign_client_callback($request){
       
        global $wpdb;
        $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
        if($user_id){
    //          $args=array(
    //          'roles__in'				=> array('client'),
    //         );
    //         $wp_user_query=new WP_User_Query($args);
    // 		$users=$wp_user_query->get_results($wp_user_query);

		    $select_query="SELECT * FROM wp_assigned_staff where staff_id = $user_id ";
		    $users=$wpdb->get_results($select_query);
		  //  print_r($users);exit;
		  //  $data['query']=$select_query;
            if(count($users)>0){
                foreach($users as $user){
                    if (get_user_meta($user->client_id, "first_name", true)!=''){
                        $userdata=get_userdata($user->client_id);
                        $name = ucfirst(get_user_meta($user->client_id, "first_name", true)).' '.ucfirst(get_user_meta($user->client_id, "last_name", true));
                    }else{
                        $name = ucfirst($userdata->data->display_name);
                    }
                    
                    $useravatar = get_user_meta($user->client_id, 'wp_user_avatar', true);
                    if($useravatar){
                        $img = wp_get_attachment_image_src($useravatar, array('150','150') , true);
                        $user_img = $img[0];
                    }else{
                        $user_img = 'http://1.gravatar.com/avatar/1aedb8d9dc4751e229a335e371db8058?s=96&d=mm&r=g';
                    }
                    
                    $data['clients'][]=array(
                        'ID'        => $user->client_id,
                        'name'      => $name,
                        'image'     => $user_img
                       );
                }
                return new WP_REST_Response($data, 200);
            } else {
                $data['success_msg']="No Clients Found";
                return new WP_REST_Response($data, 200);
            }
        } else {
            
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }  
    }
    
    //------------------[Start API]{task_for_day}-------------------------- 
    function task_for_day_callback($request){
        global $wpdb;
        $data = array('status'=> "success","msg"=>"","error_code"=>"");  
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token); 
        $param['month']=date("m",mktime(0, 0, 0, $param['month'], 1, 1900));
        $date=$param['year'].'-'.$param['month'].'-'.(($param['day']=='') ? date('d') : str_pad($param['day'], 2, '0', STR_PAD_LEFT));
        if($user_id){
            $user_data=get_userdata($user_id);
            if(in_array('staff',$user_data->roles)){
                $args  =array(
                        'role'         => 'client',
                        'meta_key'     => 'added_by',
                        'meta_value'   => $user_id,
                        'meta_compare' => '='
                );
                $wp_user_query=new WP_User_Query($args);
    	        $users=$wp_user_query->get_results();
            }
            if($param['day']==''){
                $dates=get_dates_from_month($param['month'],$param['year']);
            } else {
                $dates=array($date);
            }
            
            if(in_array('staff',$user_data->roles)){
                $args  =array(
                        'role'         => 'client',
                        'meta_key'     => 'added_by',
                        'meta_value'   => $user_id,
                        'meta_compare' => '='
                );
                $wp_user_query=new WP_User_Query($args);
    	        $users=$wp_user_query->get_results();
    	        if(count($users)>0){
                    foreach($users as $user){
                        $client_id[]=$user->ID;
                    }
                }
            } else {
                $client_id=$user_id;
            }
            
            $args = array(
                'post_type'        => 'timeline',
                'meta_key'         => 'client',
                'meta_value'       => $client_id,
                'compare'          => '='
            );
            $data['args']=$args;
            $results = new WP_Query( $args );
            if($results->post_count>0){
                foreach($results->posts as $post){ 
                    $timeline_phases= get_field_objects($post->ID);
                    //echo "<pre>"; print_r($timeline_phases); exit;
                    if(count($timeline_phases)>0){
                        if(count($timeline_phases['phases']['value'])>0){
                            foreach($timeline_phases['phases']['value'] as  $value){
                                if($value['start_phase_afterbefore']){
                                    if($value['start_phase_afterbefore']['select_phase']=='start_before'){
                                        $phase_date=date('Y-m-d', strtotime($tmp['surgery_date'].' - '.$value['start_phase_afterbefore']['days'].' days'));
                                        
                                    } else if($value['start_phase_afterbefore']['select_phase']=='start_after'){
                                        $phase_date=date('Y-m-d', strtotime($tmp['surgery_date'].' + '.$value['start_phase_afterbefore']['days'].' days'));
                                    }
                                    
                                    $phase_week=$value['start_phase_afterbefore']['weeks'];
                                    $get_last_week_date= date('Y-m-d', strtotime($phase_date.' + '.$phase_week.' week'));
                                    
                                    if(count(createRange($phase_date, $get_last_week_date))>0){
                                        $matches_dates=array_intersect($dates,createRange($phase_date, $get_last_week_date));
                                        if(count($matches_dates)>0) {
                                            foreach($matches_dates as $matches_date){
                                                
                                                if(count($value['task'])>0){
                                                    foreach($value['task'] as $index=>$task){
                                                        
                                                        $task_status=$wpdb->get_results('select status from wp_timeline_task_status where user_id='.$user_id.' and post_id='.$post->ID.' and start_date="'.$matches_date.'" and start_time="'.$task['start_time'].'" and  task_no='.$index);
                                                        if(count($task_status)>0){
                                                            $value['task'][$index]['task_status']=1;
                                                        } else {
                                                            $value['task'][$index]['task_status']=0;
                                                        }
                                                    }    
                                                }
                                                
                                                
                                                if(count($value['task'])>0){
                                                    foreach($value['task'] as $task){
                                                        if($task['task_status']==1){
                                                            $is_phase_completed=1;            
                                                        } else {
                                                            $is_phase_completed=0;            
                                                        }
                                                    }
                                                }
                                                
                                                $client=get_userdata(get_post_meta($post->ID,'client',true));
                                                if(get_user_meta($client->ID,'first_name',true)!=''){
                                                    $client_name=get_user_meta($client->ID,'first_name',true).' '.get_user_meta($client->ID,'last_name',true);
                                                }
                                                    
                                                $data['timeline_phases'][$matches_date][]=array(
                                                    'client_name'                  => $client_name,
                                                    'surgery_title'            => $post->post_title, 
                                                    'surgery_description'      => $post->post_content, 
                                                    'phase_no'                 => $key,
                                                    'radio_value'              => $timeline_phases['phases']['key'].'_'.date('d',strtotime($matches_date)).'_'.$key,'',
                                                    'post_id'                  => $post->ID,
                                                    'date'                     => date('d',strtotime($matches_date)),
                                                    'day'                      => date('D',strtotime($matches_date)),
                                                    'phase_start_before_date'  => $phase_date,
                                                    'get_last_week_date'       => $get_last_week_date,
                                                    'phase_weeks'              => $phase_week,
                                                    'phase_title'              => $value['phase']['title'], 
                                                    'start_phase_afterbefore'  => $value['start_phase_afterbefore']['select_phase'],
                                                    'days'                     => $value['start_phase_afterbefore']['days'],
                                                    'surgery_date'             => date('d-m-y',strtotime($timeline_phases['date_of_surgery']['value'])),
                                                    'start_date'               => $matches_date,
                                                    //'dates'                    => createRange($phase_date, $get_last_week_date),
                                                    'tasks'                    => $value['task'],
                                                    'is_phase_completed'       => $is_phase_completed,
                                                );    
                                            }
                                        }  
                                    }
                                }
                            }
                        }
                    }
                }
                //echo "<pre>"; print_r($data); exit;
                return new WP_REST_Response($data, 200);
            } else {
                $data['status'] = "ok";
                $data['msg'] = "No Phase Timeline Found";
                return new WP_REST_Response($data, 200);
            }
        
        } else {
            $data['status'] = "error";
            $data['msg'] = "Invalid user";
            $data['error_code'] = "user_expire";
            return new WP_REST_Response($data, 403);
        }
 }
 
 
 function timeline_complete_tasks_callback($request){
    $data = array('status'=> "success","msg"=>"","error_code"=>"");  
    $param = $request->get_params();
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token); 
    if($user_id){
        
        global $wpdb;
        $results=$wpdb->insert('wp_timeline_task_status',array(
                'user_id'       => $user_id,
                'post_id'       => $param['post_id'],
                'start_date'    => $param['start_date'],
                'start_time'    => $param['start_time'],
                'phase_no'      => $param['phase_no'],
                'task_no'       => $param['task_no'],
                'status'        => 1
            )
        );
        
        $data=array(
            'status'        => 'Ok',
            'success_msg'   => 'Task Completed'
        );
        return new WP_REST_Response($data, 200);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Invalid user";
        $data['error_code'] = "user_expire";
        return new WP_REST_Response($data, 403);
    }
 }
 
 function get_dates_from_month($month,$year){
    
    $start_date = "01-".$month."-".$year;
    $start_time = strtotime($start_date);
    
    $end_time = strtotime("+1 month", $start_time);
    
    for($i=$start_time; $i<$end_time; $i+=86400)
    {
       $list[] = date('Y-m-d', $i);
    }
    
    return $list;
 }
 
 
function createRange($startDate, $endDate)
{
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );
    if( $endStamp > $startStamp ){
        while( $endStamp >= $startStamp ){
            $dateArr[] = date( 'Y-m-d', $startStamp );
            $startStamp = strtotime( ' +1 day ', $startStamp );
        }
        return $dateArr;    
    }else{
        return $startDate;
    }
}
 

 //------------------[End API]{task_for_day}-------------------------- 
  
 
 //------------------[Start API]{getCaregivers}--------------------------
 function getCaregivers_callback($request){
       
   $data = array('status'=> "success","msg"=>"","error_code"=>"");  
   $param = $request->get_params();
   $token = $param['token'];
   $user_id = GetMobileAPIUserByIdToken($token);
   $result=caregivers($user_id);
   $data['caregivers']=$result;
   return new WP_REST_Response($data,200);
 }
 
 function caregivers($user_id){
  global $wpdb; 
  $select="SELECT * FROM `wp_assigned_staff` WHERE `staff_id` = ".$user_id;
  $result_data = $wpdb->get_results($select,ARRAY_A);
  $tmp=array();
  foreach($result_data as $schema_test ){
   $caregiver=array();      
   $caregiver_id=  $schema_test['client_id']; 
   $res = get_user_by('ID',$caregiver_id);
   $caregiver['name']=$res->data->display_name;
   $caregiver['email']=$res->data->user_email;
   $tmp[]=$caregiver;
  } 
  return $tmp; 
 }
 //--------------------[End API]{getCaregivers}--------------------------
    
 //------------------[Start API]{user_timelines}--------------------------
 function user_timelines_callback($request){
    $data = array('status'=> "success","msg"=>"","error_code"=>"");
    // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    $param = $request->get_params();
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token);   
    $args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'timeline',
        'order'            => 'DESC',
        'post_status'      => 'publish',
        'orderby'          => 'publish_date',
        'meta_key'         => 'client',
        'meta_value'       => $user_id,
        'compare'          => '='
     );
     $query = new WP_Query( $args );
     $result=$query->posts;
     //  print_r($result);exit;
    
     $client_res=get_field_objects($result[0]->ID);
     $client=array(
             'client_name'=>$client_res['client']['value']['display_name'],
             'client_email'=>$client_res['client']['value']['user_email'],
             'client_description'=>$client_res['client']['value']['user_description'],
             'client_avatar'=>$client_res['client']['value']['user_avatar']
             );
     $data['client_details'] =  $client;
    
     //This foreach for multiple timeline===>
     $temp=array();
     foreach($result as $row){
         $timelines=array();
         $post_id=$row->ID;
         $res= get_field_objects($post_id);
            // print_r($res);exit;
         
         $surgery=array(
             'surgery_id'=>$res['surgery']['value']->ID,
             'surgery_title'=>$res['surgery']['value']->post_title
             );  
         $timelines['surgery'] =  $surgery;
         $date_of_surgery=$res['date_of_surgery']['value'];
         $timelines['date_of_surgery']= $date_of_surgery;
         
         $phases_value=$res['phases']['value'];
         //This foreach for multiple phase==>
         $all_phase=array();
         $p=1;
         foreach($phases_value as $phs)
         {
             $phases=array();
             $phase_title=$phs['phase']['title'];
             $tasks_for_week_or_day=$phs['phase']['tasks_for_week_or_day'];
             $task_for_hour=$phs['phase']['task_for_hour'];
             $phase=array(
                 'phase_title'=>$phase_title,
                 'tasks_for_week_or_day'=>$tasks_for_week_or_day,
                 'task_for_hour'=>$task_for_hour
                 );
             $phases['phase']=$phase;
             
             $tasks=$phs['task'];
             //This foreach for multiple task==>
             $task=array();
             foreach($tasks as $tsk){
                //  print_r($tsk);exit;
                 $descriptions=$tsk['descriptions'];
                 //This foreach for multiple descriptions 
                 $description=array();
                 foreach($descriptions as $des){
                    $res=$des['description']; 
                    $description[]=$res;
                 }
                 
                 
                 $upload_document=$tsk['upload_document'];
                 //This foreach for multiple document 
                 $document=array();
                 foreach($upload_document as $doc){
                     $doc_id= $doc['document'];
                     $doc_url=wp_get_attachment_url( $doc_id );
                     $document[]=$doc_url;
                 }
                 
                
                 $upload_image=$tsk['upload_image'];
                 //This foreach for multiple upload_image 
                 $image=array();
                 foreach($upload_image as $img){
                     $res=$img['images'];
                     $image[]=$res;
                 }
                 
                 
                 $upload_video=$tsk['upload_video'];
                 //This foreach for multiple upload_video 
                 $video=array();
                 foreach($upload_video as $vdo){
                     $res=$vdo['video'];
                     $video[]=$res;
                 }
                 
                
                 $add_questionnaire=$tsk['add_questionnaire'];
                 //This foreach for multiple questions
                 $question=array();
                 foreach($add_questionnaire as $qus){
                     $res=$qus['question'];
                     $question[]=$res;
                 }
                 
                 $action=$tsk['action'][0];
                 
                  $tmp_tsk=array(
                    'descriptions'    =>  $description,
                    'upload_document' =>  $document,
                    'upload_image'    =>  $image,
                    'upload_video'    =>  $video,
                    'question'        =>  $question,
                    'action'          =>  $action
                    
                 );
                 $task[]=$tmp_tsk;
             }
             $phases['task']=$task;
             $all_phase[]=$phases;
             $p++;
         }
         $timelines['timeline_phases']=$all_phase;
        $temp[]=$timelines;
        
    }
    if(count($temp)==0)
    {
       $data['msg']='No timeline found'; 
       $data['error_code']='';
       return new WP_REST_Response( $data,200);
    }
    //   print_r($temp);exit;
    $data['client_timelines']=$temp;
    return new WP_REST_Response( $data);
 }
 
 //-------------------[End API]{user_timelines}---------------------------
 
 
 //------------------[Start API]{change_user}--------------------------
 function change_user_callback($request)
 {
    $data = array('status'=> "success","msg"=>"","error_code"=>"");
    // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    $param = $request->get_params();
    $token = $param['token'];
    // $user_id = GetMobileAPIUserByIdToken($token);  
    // $clint_id=get_user_meta($user_id,'clients',true);
    $user_id=$param['user_id'];
    
    $res=change_role($user_id);
    return new WP_REST_Response($res);
 }
 function change_role($user_id) {
    $current_user = $user_id;
    $user_meta=get_userdata($user_id);
    $user_roles=$user_meta->roles;
    if($user_roles=='client'){
    //   $current_user->remove_role('client');
    //   $current_user->add_role('caregiver' );
      change_role($user_id, 'caregiver');
    }
    elseif($user_roles=='caregiver'){
    //   $current_user->remove_role('caregiver');
    //   $current_user->add_role('client' ); 
    change_role($user_id, 'client');
    }
    $user_info=array();
    $user_meta=get_userdata($user_id);
    $user_roles=$user_meta->roles;
    $user_info['user_role']=$user_roles;
    $user_info['user_id']=$user_id;
  return $user_info ;
}

// View Staff Assigned Timeline
 function view_assigned_client_timeline_callback($request){
 global $wpdb;
         $data  = array(
        "status" => "ok",
        "errormsg" => "",
        'error_code' => ""
    );
    $param = $request->get_params(); 
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token); 
    
    $select_query="SELECT * FROM wp_assigned_staff where staff_id = $user_id ";
	$users=$wpdb->get_results($select_query);
	$users = json_decode(json_encode($users), true);
	$clintId=array();
	foreach($users as $user){
	    $clintId[]=$user['client_id'];
	}

    if($user_id){
        $args = array(
            'post_type' => 'timeline',
            'post_status' => 'publish',
            'meta_key'         => 'client',
            'meta_value'       => $clintId,
            'compare'          => '=',
            'posts_per_page' => -1
        );
        
       $posts = new WP_Query( $args );
       
        if ($posts ->post_count>0) {
            foreach ( $posts->posts as $post ) {
               $timeline= get_field_objects($post->ID);
    
               
              $date_of_surgery=$timeline['date_of_surgery']['value'];
                $surgery= $timeline['surgery']['value']->post_title;
                $client = get_post_meta($post->ID,'client',true);
                   
                 $data['timeline'][$type][]=array(
                    'title' => $post->post_title,
                    // 'ID' => $post->ID,
                   'surgery_id' => get_post_meta($post->ID,'surgery',true),
                   'surgery' => $surgery,
                     'date' => $date_of_surgery,
                   
                    
                    );
                   
                 }
                 $data['status']= 200;
            return new WP_REST_Response($data, 200);
        }
         
    }
    
    return new WP_REST_Response($data, 403);
         
    }
    
//-------------------------------updateDeviceToken[start]-------------------------------- 
function updateDeviceToken($request){
    $data=array("status"=>"ok","errormsg"=>"",'error_code'=>"");
    $param = $request->get_params();
    $user_id = GetMobileAPIUserByIdToken($param['token']);
    $deviceID=$param['deviceID'];
    $deviceData=$param['deviceData'];
    $status=$param['status'];
    switch($status){
    case 'login':
        $res = saveDeviceDetails($user_id,$deviceData);
        
    break;
    case 'logout':
        $res = removeDeviceDetails($user_id,$deviceData);
    break;
    }
    return new WP_REST_Response($res, 200);
}

function saveDeviceDetails($user_id,$device){
    global $wpdb;
    $uuid=$device[0]['uuid'];
        $results = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}users_device_details WHERE user_id =$user_id  and device_uuid='".$uuid."'");
        $numberofcounts = $results;
        if($numberofcounts==0){
         $response = $wpdb->insert('wp_users_device_details', array(
            'user_id' => (int) $user_id,
            'device_uuid' =>$device[0]['uuid'],
            'device_model' =>$device[0]['model'],
            'deviceplatform' =>$device[0]['platform'],
            'deviceversion' =>$device[0]['version'],
            'timezone' =>$device[0]['offset'],
            'device_token' =>$device[0]['deviceToken'],
            'isuserloggedin' =>1,
            'logindate' =>$device[0]['logindate'],
            'device_token' =>$device[0]['deviceToken'],
             'change_password'=>0
        ));
        }else{
               $response =  $wpdb->update( 
                        'wp_users_device_details', 
 
                        array(     
                            'device_model' =>$device[0]['model'],
                            'deviceplatform' =>$device[0]['platform'],
                            'deviceversion' =>$device[0]['version'],
                            'timezone' =>$device[0]['offset'],
                            'device_token' =>$device[0]['deviceToken'],
                            'isuserloggedin' =>1,
                            'logindate' =>$device[0]['logindate'],
                            'device_token' =>$device[0]['deviceToken'],
                            'change_password'=>0
                        ),
                     array( 
                             'device_uuid' =>$device[0]['uuid'],
                             'user_id' => (int) $user_id
                        )
                    );
        }

        return $response;
}

function removeDeviceDetails($user_id,$device){
    global $wpdb;
               $response =  $wpdb->update( 
                        'wp_users_device_details', 
 
                        array(     
                          'isuserloggedin' =>0,
                        ),
                     array( 
                             'device_uuid' =>$device[0]['uuid'],
                             'user_id' => (int) $user_id
                        )
                    );
        return $response;
}
//--------------------------------updateDeviceToken[End]---------------------------------    
    
    
function test_browser_notification($request){
        $data = array(
            "status" => "error",
            "message" => "Invalid User"
        );
    
        $param=$request->get_params();
    
        $user_id=$param['sender_id'];
    
        if($user_id){
            update_user_meta($user_id,'device_id',$param['device_id']);
    			
            $data = array(
    			"status" => "ok", 
                "message" => "Device Token Updated"
            );
    
            return new WP_REST_Response($data, 200);
        }
        return new WP_REST_Response($data, 400);
    }    
    
 

// function send_chat_messages_notifications($request){
//     $data=array(
//     'status'=>'error',
//     'message'=> 'Invalid User'
//     );
    
//     $param=$request->get_params();
//     if(!empty($param)){
//     $devide_ids[]=get_user_meta($param['receiver_id'],'device_id',true);
//     // print_r($devide_ids);
//     $data=send_push_notification($param['sender_name'],$param['message'],$devide_ids);
//     // echo "<pre>"; print_r($data); exit;
//     } else {
//     $data=array(
//     'status'=>'error',
//     'message'=> 'Invalid User'
//     );
//     }
//     return new WP_REST_Response($data, 200);
// }
    
// function send_push_notification($msg_title,$msg_content,$devide_ids){
//     $data = array(
//     'source' => 'Nayak plastic Surgery',
//     'msgshow' => $msg_title,
//     );
    
//     $fcmMsg = array(
//     'body' => $msg_content,
//     'title' => $msg_title,
//     'sound' => "default",
//     'color' => "#8e2c93",
//     );
//     $fcmFields = array(
//     'registration_ids' => $devide_ids,
//     'priority' => 'high',
//     'notification' => $fcmMsg,
//     'data' => $data
//     );
    
//     $headers = array(
//     'Authorization: key=AAAAqozbYXA:APA91bGJUfHM3aN-8K_K8MTv-KQmajegVO_dMfBLWjtbpFJQ8UW4qCrNiewsB34aHCUqAyGcNLwtLy4dfnAA3XPh-hPjEhYTUAEqollmL-fBPyyIqrXhl2qvR0kYtVnljTygk34YqO8H',
//     'Content-Type: application/json'
//     );
//     $ch = curl_init();
//     curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
//     curl_setopt( $ch,CURLOPT_POST, true );
//     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//     curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($fcmFields));
//     $result = curl_exec($ch);
//     curl_close( $ch );
//     //print_r($result); exit;
//     //die(0);
//     return $result;
// }
// function change_timeline_date($request){
//     $param=$request->get_params();
//     $post_id=$param['post_id'];
//     $pre_surgery_date=get_post_meta($post_id,'date_of_surgery',true);
//     $pre_surgery_date=date('Y-m-d',strtotime($pre_surgery_date));
//     echo $pre_surgery_date."<br>";
//     $date_of_surgery=$param['date_of_surgery'];
//     $date_of_surgery=date('Y-m-d',strtotime($date_of_surgery));
//     echo $date_of_surgery."<br>";
//     if(!($pre_surgery_date==$date_of_surgery)){
//     //  delete_field( 'phases', $post_id );
//      echo "not equal";
//     }
//     else{
//         echo "equal";
//     }
// }




function get_message_users($request){
    global $wpdb;
    $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
    $param = $request->get_params();
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token);
    if($user_id){
        $loggedin_userdata=get_userdata($user_id);
        $data['current_user']=$loggedin_userdata;
        if(in_array('staff',$loggedin_userdata->roles)){
            $args  =array(
                    //'role'         => 'subscriber',
                    'meta_key'     => 'added_by',
                    'meta_value'   => $user_id,
            );
            $wp_user_query=new WP_User_Query($args);
	        $users=$wp_user_query->get_results();
        } else if(in_array('client',$loggedin_userdata->roles)){
            $select_query="select * from wp_assigned_clients where client_id=".$user_id;
            $results=$wpdb->get_results($select_query,ARRAY_A);
            if(count($results)>0){
                foreach($results as $user){
                    $users=array(
                        get_userdata($user['caregiver_id']),
                        get_userdata($user['staff_id'])
                    );
                }
            }
        }
        if(count($users)>0){
            foreach($users as $user){
                if (get_user_meta($user->ID, "first_name", true)!=''){
                    $userdata=get_userdata($user->ID);
                    $name = ucfirst(get_user_meta($user->ID, "first_name", true)).' '.ucfirst(get_user_meta($user->ID, "last_name", true));
                }else{
                    $name = ucfirst($userdata->data->display_name);
                }
                
                $useravatar = get_user_meta($user->ID, 'wp_user_avatar', true);
                if($useravatar){
                    $img = wp_get_attachment_image_src($useravatar, array('150','150') , true);
                    $user_img = $img[0];
                }else{
                    $user_img = 'http://1.gravatar.com/avatar/1aedb8d9dc4751e229a335e371db8058?s=96&d=mm&r=g';
                }
                
                $results=$wpdb->get_results("select * from wp_user_block_unblock where blocked_by=".$user_id." and blocked_to=".$user->ID);
                
                
                $data['users'][]=array(
                    'ID'        => $user->ID,
                    'name'      => $name,
                    'image'     => $user_img,
                    'role'      => $user->roles,
                    'is_blocked'=> count($results)>0 ? $results[0]->status : 0
                   );
            }
            return new WP_REST_Response($data, 200);
        } else {
            $data['success_msg']="No User Found";
            return new WP_REST_Response($data, 200);
        }
    } else {
        $data['status'] = "error";
        $data['msg'] = "Invalid user";
        $data['error_code'] = "user_expire";
        return new WP_REST_Response($data, 403);
    }  
}

function getSecoondUserInfo($request){
    $data=array("status"=>"ok","errormsg"=>"",'error_code'=>"");
    $param = $request->get_params();
    $user_id = $param['id'];
       
    $user_datas=array();
    if ($user_id>0)
    {
        $data['msg_data']=$user_id;
        $data['msg_time'] = $user_id['time1'];
        $data['id']=$user_id;
        $data['first_name'] = get_user_meta($user_id, 'first_name', true);
        $data['last_name'] = get_user_meta($user_id, 'last_name', true);
        $data['view_type'] = get_user_meta($user_id, 'view_type', true);
        $data['service_name'] = get_term($data['view_type'])->name;
        $data['display_name'] = $single['first_name'] . ' ' . get_user_meta($user_id, 'last_name', true);
        $useravatar = get_user_meta($user_id, 'wp_user_avatar', true);
        if ($useravatar)
        {
            $img = wp_get_attachment_image_src($useravatar, array(
                '150',
                '150'
            ) , true);
            $user_avatar = $img[0];
            $data['user_img'] = $user_avatar;
        }
        else
        {

            $data['user_img'] = 'http://1.gravatar.com/avatar/1aedb8d9dc4751e229a335e371db8058?s=96&d=mm&r=g';
        }

    }else{
       return new WP_REST_Response($data, 403);
    }
      return new WP_REST_Response($data, 200);
    
}

function createSession($request){
    global $apiObj;
    $data=array("status"=>"ok","errormsg"=>"",'error_code'=>"");
    $param = $request->get_params();

    $sessionOptions = array(
        // 'archiveMode' => ArchiveMode::ALWAYS, 
        'mediaMode' => MediaMode::ROUTED
    );
    $session = $apiObj->createSession($sessionOptions);
    $session_id = $session->getSessionId();
    $token = $apiObj->generateToken($session_id);
 
    $data['session_id'] = $session_id;
    $data['token'] = $token;
    $data['archive_id'] = $session->connection;

    return new WP_REST_Response($data, 200);
}

function endSession($request){
    global $apiObj;
    $data=array("status"=>"ok","errormsg"=>"",'error_code'=>"");
    $param = $request->get_params();
    $session_id = $param['session_id'];
    $connectionId = '';
    $r = $apiObj->createSession($session_id, $connectionId);

    $data['endData'] = $r;

    return new WP_REST_Response($data, 200);
}

function block_unblock_user($request){
    global $wpdb;
    $data = array("status" => "ok", "errormsg" => "", 'error_code' => "");
    $param = $request->get_params();
    $token = $param['token'];
    $user_id = GetMobileAPIUserByIdToken($token);
    if($user_id){
        $results=$wpdb->get_results('select * from wp_user_block_unblock where blocked_by='.$user_id.' and blocked_to='.$param['blocked_to']);
        if(count($results)>0){
            $wpdb->query('update wp_user_block_unblock set status='.$param['block_status'].' where blocked_by='.$user_id.' and blocked_to='.$param['blocked_to']);
            $data['query']=$wpdb->last_query;
        } else {
            $wpdb->insert('wp_user_block_unblock',array(
                'blocked_by'    => $user_id,
                'blocked_to'    => $param['blocked_to'],
                'status'        => 1
            ));
        }
        $data['status'] = "ok";
        $data['msg'] = ($param['block_status']==0) ? 'Unblocked' : 'Blocked';
        return new WP_REST_Response($data, 200);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Invalid user";
        $data['error_code'] = "user_expire";
        return new WP_REST_Response($data, 403);
    } 
}

function get_admin_contact_number($request){
    $data=get_option('contact_phone_number');
    return new WP_REST_Response($data, 200);
}
