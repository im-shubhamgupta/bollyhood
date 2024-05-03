<?php
include_once(__DIR__.'/../include/constant.php');
class message_Controller extends DB_Function{
    
    private $functions = NULL;
		private $conn = NULL;

    public function __construct() {
        // $this->conn = new DB();
        // $this->functions = new functions($this->db);
    }
    public function send_message($data){
        $temp = array();
        $file_arr = array();
        if (!empty($data['image'][0]['name'])) {
            
                //upload video
                $image = isset($data['image']) ? $data['image'] : '';
                $params = array();
                
                $params['file_upload'] = UPLOAD_CHATTING_IMAGE_PATH;
                $params['file_type'] = VALID_IMG_EXT;
                $img_data = $this->uploadCustomFile($image, $params);

                if($img_data['check'] == 1){
                    $temp['image'] = $img_data['file_name'];
                }else{
                    $temp['image'] = '';
                }
        }else{
            $temp['image'] = '';
        }
 
        $temp['uid'] = $data['uid'];
        $temp['other_uid'] = $data['other_uid'];
        $temp['text'] = $data['text'];
        $temp['added_on'] = date('Y-m-d H:i:s');
        $user = $this->executeSelectSingle('users',array(),array('id'=>$data['uid']));

        $this->push_notification_android($user['fcmtoken'],'BollyHood',substr($temp['text'],0,30));
        
        $in= $this->executeInsert('users_chatting',$temp);
        if($in > 0){
            return  array('check' => 'success', 'msg'=> 'Send Msg. Sucessfully');
        }else{
            return '';
        }
    } 
    public function chat_list($data){
        
        $chats = $this->getResultAsArray("SELECT * from users_chatting where uid IN (".$data['uid'].",".$data['other_uid'].") and other_uid IN (".$data['other_uid'].",".$data['uid'].") order by id desc ");
        $uid = $data['uid'];
        $temp = array_map(function($item) use($uid){
            $item['image'] = !empty($item['image']) ? CHATTING_IMAGE_PATH.$item['image'] : '';
            $item['user_type'] = ($item['uid'] == $uid) ? 1 : 2 ;//sender or receiver
            return $item;
            },$chats);
            
        
        if(!empty($temp)){
            return $temp;
        }else{
            return '';
        }
        
    }    
}


// SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting_apply';
                // $all_columns = $this->getSingleResult("SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting'");
                // SELECT * , (SELECT CONCAT('id' ) FROM casting LIMIT 1) as casting_data from casting_apply ca inner join users u on u.id =ca.uid where 1;
                // $this->echoPrint($all_columns);