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
        $sql = "SELECT *,CONCAT('".USER_IMAGE_PATH."', `image`) as user_image from users where status = 1 $check_sql ";
        $result = $this->getSingleResult($sql);
        $otp = str_pad(substr(str_shuffle(mt_rand(111111,999999)),0,6), 6, '0', STR_PAD_LEFT);
        if(!empty($result)){
            $temp = array(
                'otp' => $otp,
                'image' => $result['user_image'],
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
    public function category_list(){
        $cat = $this->executeSelect('category',array(),array(),'category_name');
        if(count($cat) > 0){
            return $cat;
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
                $valid_imgname = date('Y_m_d_His')."_".rand('1000','9999').".".$imageFileType; 
                if(in_array($imageFileType, VALID_IMG_EXT)){
                    $image_flag = 1;
                }else{
                    //echo $msg  = "Accept only .png, .jpg, .jpeg Extension Image only";
                }   
            }
            if($image_flag == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/users/'.$valid_imgname)) {
                    //echo "image uploaded";   
                }else{
                    //echo "can,t upload Image"; 
                }
            }
            $data['modify_date'] = date("Y-m-d H:i:s");
            $data['image'] = !empty($valid_imgname) ? $valid_imgname : 'no_image.png' ;
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
}