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
        $sql = "SELECT * from users where status=1 $check_sql ";
        $result = $this->getSingleResult($sql);
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
        }
        return '';
    }
    public function send_otp($data){
        $user = $this->executeSelectSingle('users',array(),array('id' => $data['uid']));
        if(count($user) > 0){
            $temp = array(
                'otp' => 111222,
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
}