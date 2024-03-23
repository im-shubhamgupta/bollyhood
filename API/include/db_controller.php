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
        $result = $this->executeSelectSingle('users',array(),array('mobile' => $data['mobile'],'otp'=>$data['otp']));
        if(!empty($result)){
            $temp = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'mobile' => $result['mobile'],
                'status' => $result['status'],
                'is_verify' => $result['is_verify'],
                'user_type' => $result['user_type'],
                'image' => ($result['image']== 'no_image.png' || empty($result['image']))  ? '': USER_IMAGE_PATH.$result['image']  ,
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
        $user = $this->executeSelectSingle('users',array('*,CONCAT("'.USER_IMAGE_PATH.'", `image`) as image'),array('id'=>$data['id']));
        if(!empty($user)){
            return $user;
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
            $data['modify_date'] = date("Y-m-d H:i:s");
            if(!empty($_FILES['image']['name'])){
                $data['image'] = !empty($valid_imgname) ? $valid_imgname : 'no_image.png' ;
            }
            
            $uid= $data['id'];
            unset($data['id']);
            // print_r($data);
            $result = $this->executeUpdate('users',$data,array('id'=>$uid));
            $user = $this->executeSelectSingle('users',array('*,CONCAT("'.USER_IMAGE_PATH.'", `image`) as image'),array('id'=> $uid));
            
            // $this->debugSql;
            if($result){
                $res['check'] = 'success';
                $res['result'] = $user;
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
    public function all_bookmark($data){
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
    }
    public function mod_bookmark($data){
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
    }
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
    
    
}