<?php
include_once('constant.php');
class DB_Controller extends DB_Function{
    
    private $functions = NULL;
		private $conn = NULL;

    public function __construct() {
        // $this->conn = new DB();
        // $this->functions = new functions($this->db);
    }
            
    public function get_company_list($id){
        
        // $db = new DB();
        // $conn = $db->Db_Connect();
        // $conn = $this->Db_Connect(); 
        $conn = $this->Db_Connect(); 
        $ComSql = "SELECT * from companies where `id`='$id'";
        $Cquery = $conn->query($ComSql);
        if($Cquery->num_rows>0){
            $row = $Cquery->fetch_assoc();
            $response['id']=$row['id'];
            $response['name']=$row['name'];
            return $response;
        }else{
            return '';
        }
    }
    public function login($data){
        //$conn = $this->Db_Connect();
        $check_sql = is_numeric($data['id']) ? " AND mobile='".$data['id']."'" : " AND email='".$data['id']."'"  ; 
        $sql = "SELECT * from users where status = 1 $check_sql ";
        //,CONCAT('".USER_IMAGE_PATH."', `image`) as user_image
        $result = $this->getSingleResult($sql);
        $otp = str_pad(substr(str_shuffle(mt_rand(111111,999999)),0,6), 6, '0', STR_PAD_LEFT);
        if(!empty($result)){
            $temp = array(
                'otp' => $otp,
                'image' => ($result['image']== 'no_image.png' || empty($result['image']))  ? '': USER_IMAGE_PATH.$result['image']  ,
            );
            $up = $this->executeUpdate('users',array('otp'=>$otp),array('id'=>$result['id']));
            return $temp;
        }
        return '';
    }
    public function send_otp($data){
        // $result = $this->executeSelectSingle('users',array(),array('mobile' => $data['mobile'],'otp'=>$data['otp']));
        $usql = "SELECT * ,CONCAT('".USER_IMAGE_PATH."', `image`) as image,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,     IF(`sub_categories` = '', '0', `sub_categories`) as sub_catt  from users where mobile='".$data['mobile']."' and otp='".$data['otp']."'    ";
        $result = $this->getSingleResult($usql);
        if(!empty($result)){
            $category = $this->getResultAsArray("SELECT `category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$result['catt'].") ");
            $sub_category = $this->getResultAsArray("SELECT `sub_cat_name` from sub_category where sub_cat_id IN (".$result['sub_catt'].") ");
            $temp = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'mobile' => $result['mobile'],
                // 'reviews' => $result['reviews'],
                // 'description' => $result['description'],
                // 'jobs_done' => $result['jobs_done'],
                // 'experience' => $result['experience'],
                'categories' => $category,
                'sub_categories' => $sub_category,
                'status' => $result['status'],
                'is_verify' => $result['is_verify'],
                'is_subscription' => $result['is_subscription'],
                'user_type' => $result['user_type'],
                'image' => ($result['image']== 'no_image.png' || empty($result['image']))  ? '': $result['image']  ,
            );
            return $temp;
        }else{
            return '';
        }    
    }

    public function sign_up($data){
        $res= array('check' => 'failed', 'msg'=> '-');
        $check_mobile =  $this->getAffectedRowCount("SELECT `id` from users where  `mobile` = '".$data['mobile']."'");
        if($check_mobile > 0){
            $error_note = "Mobile No already exist";
        }
        $check_email =  $this->getAffectedRowCount("SELECT `id` from users where  `email` = '".$data['email']."'");
        if($check_email > 0){
            $error_note = "Email id already exist";
        }
        if(!isset($error_note)){
            $image_flag = 0;
            if(isset($_FILES['image']) && !empty(($_FILES['image']['name']) )){
                $imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']),PATHINFO_EXTENSION));
                $valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType; 
                if(in_array($imageFileType, VALID_IMG_EXT)){
                    $image_flag = 1;
                }else{
                    //echo $msg  = "Accept only .png, .jpg, .jpeg Extension Image only";
                }   
            }
            //'../../resources/image/users/'
            if($image_flag == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], UPLOAD_USER_IMAGE_PATH.$valid_imgname)) {
                    //echo "image uploaded";   
                }else{
                    //echo "can,t upload Image"; 
                }
            }
            $data['modify_date'] = date("Y-m-d H:i:s");
            if(!empty($_FILES['image']['name'])){
                $data['image'] = !empty($valid_imgname) ? $valid_imgname : 'no_image.png' ;
            }

            $data['create_date'] = date("Y-m-d H:i:s");
            $data['is_verify'] = 1;
            $result = $this->executeInsert('users',$data);
            if(!empty($result)){
                $res['check'] = 'success';
            }
        }else{
            $res['msg'] = $error_note;
        }
        return $res;
    }
    public function category_list($data){
        $total_records=0;
        // print_R($data);
        if(!empty($data['current_page'])){ //pagination
            $c_page=$data['per_page'] * ($data['current_page']-1);  
        }else{
            $c_page=0;
        }
        $per_page = $data['per_page'];
        $total_records = $this->getAffectedRowCount("select `id` from category");

        $cat = $this->executeSelect('category',array(),array(),'category_name',array());//$c_page => $per_page
        if(count($cat) > 0){
            $map_cat = array_map(function($item){
                $item['category_image'] = !empty($item['category_image']) ? CATEGORY_IMAGE_PATH.$item['category_image'] : '';
                return $item;
            },$cat);

            // $response['current_page'] = $data['current_page'];
			// $response['per_page'] = $per_page;
			// $response['total_page'] = ceil($total_records/$per_page);
			// $response['total_records']=$total_records;
			// $response['data']=$map_cat;
            return $map_cat ;

        }else{
            // $response['current_page'] = $data['current_page'];
			// $response['per_page'] = $per_page;
			// $response['total_page'] = 0;
			// $response['total_records'] = 0 ;
            return '';
        }    
    }
    public function sub_category_list($data){
       
        $total_records = $this->getAffectedRowCount("select `id` from category");
        
		$sql="SELECT sc.sub_cat_id,sc.category_id,sc.sub_cat_name from sub_category as sc inner join category c on c.id = sc.category_id where sc.category_id = '".$data['category_id']."' ";
        $result = $this->getResultAsArray($sql);

        if(count($result) > 0){
            return $result ;
        }else{
            return '';
        }    
    }
    public function category_recent_list(){
        $cat = $this->executeSelect('category',array(),array(),'category_name',array('0'=>'4'));
        if(count($cat) > 0){
            $map_cat = array_map(function($item){
                $item['category_image'] = !empty($item['category_image']) ? CATEGORY_IMAGE_PATH.$item['category_image'] : '';
                return $item;
            },$cat);
            return $map_cat;
        }else{
            return '';
        }    
    }
    public function get_expertise_profile($data){
        // $exp = $this->executeSelect('expertise',array(),array('id'=>$data['id']));
        $uid = $data["uid"];
        $exp = $this->getResultAsArray("SELECT e.*, 
        CASE
            WHEN (select `id` from bookmark b where b.expertise_id= `e`.id  and b.uid = ".$data['uid'].") > 0 THEN '1' 
            ELSE '0'
        END AS `is_bookmark`,
        CASE
            WHEN (select `id` from expertise_book eb where eb.expertise_id= `e`.id  and eb.uid = ".$data['uid'].") > 0 THEN '1'
            ELSE '0'
        END AS is_booked
         from expertise e  where e.`id`= '".$data['id']."' ");
        if(count($exp) > 0){
            $map_exp = array_map(function($item) use ($uid){
                //get all worklings
                $wSql = "SELECT worklink_name,worklink_url from expertise_worklink where expertise_id = '".$item['id']."' ";

                $item['user_image'] = !empty($item['user_image']) ? EXPERTISE_IMAGE_PATH.$item['user_image'] : '';
                $item['categories'] = !empty($item['categories']) ? $this->getResultAsArray("SELECT `category_name` from category where id IN ( ".$item['categories']." )") : array();
                // $item['work_links'] = $this->separator_to_array($item['work_links']);
                $item['work_links'] = array();
                $item['new_work_links'] = $this->getResultAsArray($wSql);
                return $item;
            },$exp);
            return $map_exp;
        }else{
            return '';
        }
    }
    public function expertise_list(){
        $exp = $this->executeSelect('expertise',array('id','name','user_image','categories','is_verify'),array(),'name');
        if(count($exp) > 0){
            $map_exp = array_map(function($item){
                $item['user_image'] = !empty($item['user_image']) ? EXPERTISE_IMAGE_PATH.$item['user_image'] : '';
                    $item['categories'] = !empty($item['categories']) ? $this->getResultAsArray("SELECT `category_name` from category where id IN ( ".$item['categories']." )") : array();
               
                return $item;
            },$exp);
            return $map_exp;
        }else{
            return '';
        }
    }
    public function recent_expertise_list(){
        $exp = $this->executeSelect('expertise',array('id','name','user_image','categories','is_verify'),array(),'name',array('0'=>'3'));
        if(count($exp) > 0){
            $map_exp = array_map(function($item){
                $item['user_image'] = !empty($item['user_image']) ? EXPERTISE_IMAGE_PATH.$item['user_image'] : '';
                    $item['categories'] = !empty($item['categories']) ?  $this->getResultAsArray("SELECT `category_name` from category where id IN ( ".$item['categories']." )") : array();
                return $item;
            },$exp);
            return $map_exp;
        }else{
            return '';
        }
    }
    
    public function forgot_password($data){
        $user = $this->executeSelect('users',array(),array('mobile'=>$data['mobile']));
        $otp = str_pad(substr(str_shuffle(mt_rand(111111,999999)),0,6), 6, '0', STR_PAD_LEFT);
        if(count($user) > 0){
            $temp = array(
                'otp' => $otp,
            );
            return $temp;
        }else{
            return '';
        }  
    }
    public function reset_password($data){
        $res['check'] = 'failed';
        $user = $this->executeSelect('users',array(),array('mobile'=>$data['mobile']));
        if(count($user) > 0){
            $result = $this->executeUpdate('users',array('password'=>$data['new_password']),array('id'=>$user['id']));
            if($result){
                $res['check'] = 'success';
                $res['msg'] = 'Password reset Sucessfully';
            }else{
                $res['msg'] = 'Something Error';
            }
            return $res;
        }else{
            $res['msg'] = 'Please check mobile no.';
        }  
        return $res;
    }
    public function change_password($data){
        $res['check'] = 'failed';
        $user = $this->executeSelectSingle('users',array('id'),array('id'=>$data['id'],'password'=>$data['old_password']));
        if(!empty($user)){
            $result = $this->executeUpdate('users',array('password'=>$data['new_password']),array('id'=>$user['id']));
            if($result){
                $res['check'] = 'success';
                $res['msg'] = 'Password Changed Sucessfully';
            }else{
                $res['msg'] = 'Something Error';
            }
            return $res;
        }else{
            $res['msg'] = 'old Password not matched';
        }  
        return $res;
    }
    public function get_profile($data){
        $res['check'] = 'failed';
        $usql = "SELECT * ,CONCAT('".USER_IMAGE_PATH."', `image`) as image,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,     IF(`sub_categories` = '', '0', `sub_categories`) as sub_catt  from users where id='".$data['id']."'";
        $user = $this->getSingleResult($usql);
        
        if(!empty($user)){
            $category =!empty($user)? $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$user['catt'].") ") : array() ;
            $sub_category =!empty($user)?  $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$user['sub_catt'].") ") : array();

            $user_worklink =!empty($user)?  $this->getResultAsArray("SELECT worklink_name,worklink_url from users_worklink where uid ='".$user['id']."' ") : array();
                    // $this->debugSql();  
            $user['categories'] = $category;       
            $user['sub_categories'] = $sub_category; 
            $user['work_links'] = $user_worklink; 
        }
        $trim_user = array_map(function($it){
            return is_null($it) ? '' : $it;
        },$user);

        if(!empty($trim_user)){
            return $trim_user;
        }else{
            return '';
        }  
    }
    public function update_profile($data){
        $res= array('check' => 'failed', 'msg'=> 'Error Happend');
        $check_mobile =  $this->getAffectedRowCount("SELECT `id` from users where  `mobile` = '".$data['mobile']."' and id != '".$data['id']."'");
        if($check_mobile > 0){
            $error_note = "Mobile No already exist";
        }
        $check_email =  $this->getAffectedRowCount("SELECT `id` from users where  `email` = '".$data['email']."' and id != '".$data['id']."'");
        if($check_email > 0){
            $error_note = "Email id already exist";
        }
        if(!isset($error_note)){
            $image_flag = 0;
            if(isset($_FILES['image']) && !empty(($_FILES['image']['name']) )){
                $imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']),PATHINFO_EXTENSION));
                $valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType; 
                if(in_array($imageFileType, VALID_IMG_EXT)){
                    $image_flag = 1;
                }else{
                    //echo $msg  = "Accept only .png, .jpg, .jpeg Extension Image only";
                }   
            }
            //'../../resources/image/users/'
            if($image_flag == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], UPLOAD_USER_IMAGE_PATH.$valid_imgname)) {
                    //echo "image uploaded";   
                }else{
                    //echo "can,t upload Image"; 
                }
            }
            // $data['modify_date'] = date("Y-m-d H:i:s");
            $currentDateTime = new DateTime();
            $data['modify_date']  = $currentDateTime->format('Y-m-d H:i:s');
            if(!empty($_FILES['image']['name'])){
                $data['image'] = !empty($valid_imgname) ? $valid_imgname : 'no_image.png' ;
            }
            

            $uid= $data['id'];
            $work_links =$data['worklinks'];
            unset($data['id']);
            

            // echo $data['worklinks'];

            if(!empty($data['worklinks'])){
                $worklinkArr = json_decode($data['worklinks'],1);
                $this->executeDelete('users_worklink',array('uid'=>$uid));
                foreach($worklinkArr as $val){
                    $this->executeInsert('users_worklink',array('uid'=>$uid,'worklink_name'=>$val['worklink_name'],'worklink_url'=>$val['worklink_url'],'date_added'=>date('Y-m-d H:i:s')));
                }
            }

            unset($data['worklinks']);
            $result = $this->executeUpdate('users',$data,array('id'=>$uid));
            
            // $user = $this->executeSelectSingle('users',array('*,CONCAT("'.USER_IMAGE_PATH.'", `image`) as image'),array('id'=> $uid));

            $user = $this->getSingleResult("SELECT *,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,
            IF(`sub_categories` = '', '0', `sub_categories`) as sub_catt  from users where id='".$uid."'");
            if(!empty($user)){
    
                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$user['catt'].") ");
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$user['sub_catt'].") ");

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$uid."' ";

                $user['image'] = !empty($user['image']) ? USER_IMAGE_PATH.$user['image'] : '';
                
                $user['work_links'] = $this->getResultAsArray($wSql);

                $user['categories'] = $category;
                $user['sub_categories'] = $sub_category;
                unset($user['sub_categories']);
            }    
                $trim_user = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$user);
            
            // $this->debugSql;
            if($result){
                $res['check'] = 'success';
                $res['result'] = $trim_user;
            }
        }else{
            $res['msg'] = $error_note;
        }
        return $res;
    }
    public function banner_list(){
        $cat = $this->getResultAsArray("SELECT CONCAT('".BANNER_IMAGE_PATH."', `banner_image`)as banner_image from banners where status = 1");
        if(count($cat) > 0){
            return $cat;
        }else{
            return '';
        }    
    } 
    /*public function all_bookmark($data){
        $cat = $this->getResultAsArray("SELECT expertise_id,e.name,e.is_verify,
        CASE
            WHEN e.user_image = '' THEN ''
            WHEN e.user_image != '' THEN CONCAT('".EXPERTISE_IMAGE_PATH."',e.user_image) 
            ELSE ''
        END AS `user_image`
        from bookmark as b INNER JOIN expertise e ON b.expertise_id = e.id INNER JOIN users ON  users.id = b.uid where b.uid = '".$data['id']."' ");
        // $this->debugSql();
        if(count($cat) > 0){
            return $cat;
        }else{
            return '';
        }    
    }*/
    /*public function mod_bookmark($data){
        $response = array('check' => 'failed', 'msg'=> 'Error Happend');
        if($data['bookmark_mode'] == 1){
            $res = $this->getAffectedRowCount("SELECT * from bookmark where `uid`='".$data['uid']."' and expertise_id = '".$data['expertise_id']."' ");
            if($res < 1){  
                $this->executeInsert('bookmark', array('uid'=>$data['uid'],'expertise_id'=>$data['expertise_id'],'date_added'=>date('Y-m-d H:i:s')));
            }
            $response['check'] = 'success';
            $response['msg'] = 'Bookmarked Successfully';
        }elseif($data['bookmark_mode'] == 2){
            $this->executeDelete('bookmark', array('uid'=>$data['uid'],'expertise_id'=>$data['expertise_id']));
            $response['check'] = 'success';
            $response['msg'] = 'Removed Successfully';
        }
        return $response;
    }*/
    public function expertise_book($data){
        $response = array('check' => 'failed', 'msg'=> 'Error Happend');
        $res = $this->getAffectedRowCount("SELECT * from expertise_book where `uid`='".$data['uid']."' and expertise_id = '".$data['expertise_id']."' ");
        if($res < 1){  
            $this->executeInsert('expertise_book', array('uid'=>$data['uid'],'expertise_id'=>$data['expertise_id'],'date_added'=>date('Y-m-d H:i:s')));
        }
        $response['check'] = 'success';
        $response['msg'] = 'Booked Successfully';
        
        return $response;
    }
    public function all_booked_expertise($data){
        $cat = $this->getResultAsArray("SELECT expertise_id,e.name,e.is_verify,
        CASE
            WHEN e.user_image = '' THEN ''
            WHEN e.user_image != '' THEN CONCAT('".EXPERTISE_IMAGE_PATH."',e.user_image) 
            ELSE ''
        END AS `user_image`
        from expertise_book as eb INNER JOIN expertise e ON eb.expertise_id = e.id INNER JOIN users ON  users.id = eb.uid where eb.uid = '".$data['id']."' ");
        // $this->debugSql();
        if(count($cat) > 0){
            return $cat;
        }else{
            return '';
        } 
    }
    public function all_subscription_plans(){
        $cat = $this->getResultAsArray("SELECT * from subscription_plan");
        // $this->debugSql();
        if(count($cat) > 0){
            return $cat;
        }else{
            return '';
        } 
    }
    public function check_subscription($data){
        $response['is_subscription'] = '0';
        $total_records = $this->getAffectedRowCount("SELECT `id` from users where is_subscription = '1' and id='".$data['uid']."' ");
        if($total_records > 0){
            $response['is_subscription'] = '1';
            return $response;
        }else{
            return $response;
        }    
    }
    public function cms_readme_list($data){
		$sql="SELECT `type`,`description` from cms_readme where type = '".$data['type']."' ";
        $result = $this->getResultAsArray($sql);
        if(count($result) > 0){
            return $result ;
        }else{
            return '';
        }    
    }
    public function all_users_list($data){
        $exp = $this->getResultAsArray("SELECT *,IF(`categories` = '' || `categories` IS NULL, '0', `categories`) as catt ,
        IF(`sub_categories` = '' || `sub_categories` IS NULL, '0', `sub_categories`) as sub_catt  from users where id!='".$data['uid']."' ");
        $uid = $data['uid'];
        if(count($exp) > 0){
            $map_exp = array_map(function($item) use($uid){

                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$item['catt'].") ");
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$item['sub_catt'].") ");
                // $this->debugSql();      

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$item['id']."' ";

                $item['image'] = !empty($item['image']) ? USER_IMAGE_PATH.$item['image'] : '';
                
                

                $is_bookmarked = $this->getAffectedRowCount("SELECT id from users_bookmark where uid = '".$uid."' AND  bookmark_uid = '".$item['id']."' ");
                $is_booking = $this->getAffectedRowCount("SELECT id from users_booking where uid = '".$uid."' AND  booking_uid = '".$item['id']."' ");

                $item['is_bookmarked'] = ($is_bookmarked > 0) ? 1 : 0 ;
                $item['is_book'] =  ($is_booking > 0) ? 1 : 0 ;
                $item['categories'] = $category;
                $item['sub_categories'] = $sub_category;
                $item['work_links'] = $this->getResultAsArray($wSql);
                   
                return $item;
            },$exp);

            foreach($map_exp as $val){
                $trim_exp[] = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }
    }
    public function recent_users_list($data){
        $exp = $this->getResultAsArray("SELECT *,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,
        IF(`sub_categories` = ''|| `sub_categories` IS NULL , '0', `sub_categories`) as sub_catt  from users where id!='".$data['uid']."' limit 3 ");
        $uid = $data['uid'];
        if(count($exp) > 0){
            $map_exp = array_map(function($item) use($uid){

                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$item['catt'].") ");
                
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$item['sub_catt'].") ");
                // $this->debugSql();      

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$item['id']."' ";
                $item['image'] = !empty($item['image']) ? USER_IMAGE_PATH.$item['image'] : '';
                

                $is_bookmarked = $this->getAffectedRowCount("SELECT id from users_bookmark where uid = '".$uid."' AND  bookmark_uid = '".$item['id']."' ");
                $is_booking = $this->getAffectedRowCount("SELECT id from users_booking where uid = '".$uid."' AND  booking_uid = '".$item['id']."' ");

                $item['is_bookmarked'] = ($is_bookmarked > 0) ? 1 : 0 ;
                $item['is_book'] = ($is_booking > 0) ? 1 : 0 ;

                $item['categories'] = $category;
                $item['sub_categories'] = $sub_category;
                $item['work_links'] = $this->getResultAsArray($wSql);
                   
                return $item;
            },$exp);
            foreach($map_exp as $val){
                $trim_exp[] = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }
    }
    public function mod_booking($data){
        $response = array('check' => 'failed', 'msg'=> 'Error Happend');
            $data['date_added'] = date('Y-m-d H:i:s');
            $res = $this->getAffectedRowCount("SELECT * from users_booking where `uid`='".$data['uid']."' and category_id = '".$data['category_id']."' and `booking_uid`='".$data['booking_uid']."' ");
            if($res <1){  
                $in = $this->executeInsert('users_booking', $data);
                if($in > 0){
                    $response['check'] = 'success';
                    $response['msg'] = 'Booking Successfully';
                    // $result = $this->getResultAsArray("SELECT users.name,ub.id as booking_id,ub.uid,ub.w_mobile,ub.purpose,ub.booking_date from users_booking as ub Inner join users ON ub.uid=users.id where ub.uid='".$data['uid']."'");

                    // $response['result'] = $result;
                }
            } else{
                $response['msg'] = 'Already Booked';
            }   
        return $response;
    }
    /*public function all_booking($data){
        $exp = $this->getResultAsArray("SELECT *,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,
        IF(`sub_categories` = ''|| `sub_categories` IS NULL , '0', `sub_categories`) as sub_catt  from users where id ='".$data['uid']."'");
        if(count($exp) > 0){
            $map_exp = array_map(function($item){

                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$item['catt'].") ");
             
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$item['sub_catt'].") ");
                // $this->debugSql();      

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$item['id']."' ";

                $item['image'] = !empty($item['image']) ? USER_IMAGE_PATH.$item['image'] : '';
                
                $item['work_links'] = $this->getResultAsArray($wSql);
                // echo "SELECT 'w_mobile',purpose,category_id from users_booking where uid='".$item['id']."'  group by category_id";
                $booking = $this->getResultAsArray("SELECT w_mobile,purpose,category_id from users_booking where uid='".$item['id']."' ");

                $item['categories'] = $category;
                $item['sub_categories'] = $sub_category;
                $item['booking'] = $booking;
                   
                return $item;
            },$exp);
            foreach($map_exp as $val){
                $trim_exp = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }
    }*/
    public function all_booking($data){
        $exp = $this->getResultAsArray("SELECT users.*,ub.w_mobile,ub.purpose,c.category_name,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,
        IF(`sub_categories` = ''|| `sub_categories` IS NULL , '0', `sub_categories`) as sub_catt 
        from users 
        INNER JOIN users_booking ub ON users.id= ub.booking_uid 
        LEFT JOIN category c ON ub.category_id= c.id 
        where users.id !='".$data['uid']."'  AND ub.uid='".$data['uid']."' ");

        $uid = $data['uid'];
        if(count($exp) > 0){
            $map_exp = array_map(function($item) use ($uid){

                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$item['catt'].") ");
             
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$item['sub_catt'].") ");
                // $this->debugSql();      

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$item['id']."' ";

                $item['image'] = !empty($item['image']) ? USER_IMAGE_PATH.$item['image'] : '';

                $is_bookmarked = $this->getAffectedRowCount("SELECT id from users_bookmark where uid = '".$uid."' AND  bookmark_uid = '".$item['id']."' ");
                $is_booking = $this->getAffectedRowCount("SELECT id from users_booking where uid = '".$uid."' AND  booking_uid = '".$item['id']."' ");

                $item['categories'] = $category;
                $item['sub_categories'] = $sub_category;
                $item['is_bookmarked'] = ($is_bookmarked > 0) ? 1 : 0 ;
                $item['is_book'] = ($is_booking > 0) ? 1 : 0 ;
                
                $item['work_links'] = $this->getResultAsArray($wSql);

                

                unset($item['catt']);
                unset($item['sub_catt']);
                // $item['booking'] = $booking;
                   
                return $item;
            },$exp);
            foreach($map_exp as $val){
                $trim_exp[] = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }
    }
    public function mod_bookmark($data){
        $response = array('check' => 'failed', 'msg'=> 'Error Happend');
        if($data['bookmark_mode'] == 1){
            $res = $this->getAffectedRowCount("SELECT * from users_bookmark where `uid`='".$data['uid']."' and bookmark_uid = '".$data['bookmark_uid']."' ");
            if($res < 1){  
                $this->executeInsert('users_bookmark', array('uid'=>$data['uid'],'bookmark_uid'=>$data['bookmark_uid'],'date_added'=>date('Y-m-d H:i:s')));
            }
            $response['check'] = 'success';
            $response['msg'] = 'Bookmarked Successfully';
        }elseif($data['bookmark_mode'] == 2){
            $this->executeDelete('users_bookmark', array('uid'=>$data['uid'],'bookmark_uid'=>$data['bookmark_uid']));
            $response['check'] = 'success';
            $response['msg'] = 'Removed Successfully';
        }
        return $response;
    }
    public function all_bookmark($data){
        $exp = $this->getResultAsArray("SELECT users.*,ub.w_mobile,ub.purpose,c.category_name,IF(`categories` = '' || `categories` IS NULL , '0', `categories`) as catt ,
        IF(`sub_categories` = ''|| `sub_categories` IS NULL , '0', `sub_categories`) as sub_catt
        from users 
        LEFT JOIN users_booking ub ON users.id= ub.uid
        LEFT JOIN category c ON ub.category_id= c.id 
        INNER JOIN users_bookmark ub_mark ON ub_mark.bookmark_uid= users.id   
        
        where users.id !='".$data['uid']."' AND ub_mark.uid='".$data['uid']."' ");
        //join only bookmarked person
        $uid = $data['uid'];
        if(count($exp) > 0){
            $map_exp = array_map(function($item) use ($uid) {
                $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$item['catt'].") ");
             
                $sub_category = $this->getResultAsArray("SELECT sub_cat_id,category_id,`sub_cat_name` from sub_category where sub_cat_id IN (".$item['sub_catt'].") ");
                // $this->debugSql();      

                $wSql = "SELECT worklink_name,worklink_url from users_worklink where uid = '".$item['id']."' ";
                $item['image'] = !empty($item['image']) ? USER_IMAGE_PATH.$item['image'] : '';
                $item['work_links'] = $this->getResultAsArray($wSql);

                $bookmark = $this->getResultAsArray("SELECT uid,bookmark_uid from users_bookmark where bookmark_uid ='".$item['id']."' ");

                $is_bookmarked = $this->getAffectedRowCount("SELECT id from users_bookmark where uid = '".$uid."' AND  bookmark_uid = '".$item['id']."' ");
               
                $is_booking = $this->getAffectedRowCount("SELECT id from users_booking where uid = '".$uid."' AND  booking_uid = '".$item['id']."' ");

                $item['categories'] = $category;
                $item['sub_categories'] = $sub_category;
                $item['is_bookmarked'] = ($is_bookmarked > 0) ? 1 : 0 ;
                $item['is_book'] = ($is_booking > 0) ? 1 : 0 ;
                if(!empty($is_bookmarked)){
                    $item['bookmark'] = $bookmark;
                }
                
                unset($item['catt']);
                unset($item['sub_catt']);
                   
                return $item;
            },$exp);
            foreach($map_exp as $val){
                $trim_exp[] = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }   
    }
    public function all_casting(){
        
        $exp = $this->getResultAsArray("SELECT * from casting where 1 ");
        if(count($exp) > 0){
            $map_exp= array_map(function($item){
                unset($item['create_date']);
                unset($item['modify_date']);
                return $item;
            },$exp);
            foreach($map_exp as $val){
                $trim_exp[] = array_map(function($it){
                    return is_null($it) ? '' : $it;
                },$val);
            }
            return $trim_exp;
        }else{
            return '';
        }   
    }
    
}