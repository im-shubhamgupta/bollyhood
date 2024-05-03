<?php
include_once(__DIR__.'/../include/constant.php');
class casting_Controller extends DB_Function{
    
    private $functions = NULL;
		private $conn = NULL;

    public function __construct() {
        // $this->conn = new DB();
        // $this->functions = new functions($this->db);
    }
    public function all_casting($data){
        $exp = $this->getResultAsArray("SELECT * from casting where 1 ");
        if(count($exp) > 0){
            $map_exp= array_map(function($item)use($data){
                $item['company_logo'] = !empty($item['company_logo']) ? COMPANY_LOGO_PATH.$item['company_logo'] : '';
                $item['document'] = !empty($item['document']) ? COMPANY_DOC_PATH.$item['document'] : '';

                $castingApply = $this->getAffectedRowCount("select id from casting_apply where casting_id = '".$item['id']."' and uid = '".$data['uid']."'");
                // $this->debugSql();

                $castingBookmark = $this->getAffectedRowCount("select id from casting_bookmark where casting_id = '".$item['id']."' and uid = '".$data['uid']."'");

                $item['is_casting_apply'] = ($castingApply > 0) ? 1 : 0;
                $item['is_casting_bookmark'] = ($castingBookmark > 0) ? 1 : 0;;


                return $item;
            },$exp);
        
           //add color type on existing array
           $i = 0;
            foreach($map_exp as &$val){
                if($i > 3){
                    $i = 0;
                }
                $val['type'] = CASTING_COLOR[$i];
                $i++;
            }
            return $map_exp;
        }else{
            return '';
        }   
    }
    public function casting_apply($data){
        $file_arr = array();
        if (!empty($data['images'][0]['name'])) {
            $uploadedFiles = $data['images'][0];
        
            // Loop through all uploaded files
            foreach ($uploadedFiles['tmp_name'] as $key => $val) {
                $allowedFileTypes = VALID_IMG_EXT;
                
                $fileName = $uploadedFiles['name'][$key];
                $fileTmpName = $uploadedFiles['tmp_name'][$key];
                $fileSize = $uploadedFiles['size'][$key];
                $fileType = $uploadedFiles['type'][$key];

                $imageFileType = strtolower(pathinfo(basename($fileName),PATHINFO_EXTENSION));
				$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType;

                if (!in_array($imageFileType, $allowedFileTypes)) {
                    //echo "Error: File $imageFileType has an invalid file type. Only JPEG, PNG, and GIF files are allowed.<br>";
                    continue;
                }
                $destination = UPLOAD_CASTING_IMAGES_PATH.$valid_imgname;
                if(move_uploaded_file($fileTmpName, $destination)){
                    $file_arr[] = $valid_imgname;
                };
               // echo "File $fileName uploaded successfully.<br>";
            }
        } else {
           // echo "No files were uploaded.";
        }
        if(!empty($file_arr)){
			$temp['images'] = implode(',',$file_arr);
		}else{
			$temp['images'] = '';
		}
        //upload video
		$video = isset($data['video']) ? $data['video'] : '';
		$params = array();
		// $params['file_type'] = VALID_VIDEO_EXT;
		$params['file_upload'] = UPLOAD_CASTING_VIDEO_PATH;
		$video_data = $this->uploadCustomFile($video,$params);

		if($video_data['check'] == 1){
			$temp['video'] = $video_data['file_name'];
		}else{
			$temp['video'] = '';
		}
        unset($data['images']);
        unset($data['video']);
        $data['images'] = $temp['images'];
        $data['video'] = $temp['video'];
        // print_R($data);
        $in= $this->executeInsert('casting_apply',$data);
        if($in > 0){
            return  array('check' => 'success', 'msg'=> 'Applied Sucessfully');
        }else{
            return '';
        }   
    }
    public function mod_casting_bookmark($data){
        $response = array('check' => 'failed', 'msg'=> 'Error Happend');
        if($data['bookmark_mode'] == 1){
            $res = $this->getAffectedRowCount("SELECT id from casting_bookmark where `uid`='".$data['uid']."' and casting_id = '".$data['casting_id']."' ");
            if($res < 1){  
                $this->executeInsert('casting_bookmark', array('uid'=>$data['uid'],'casting_id'=>$data['casting_id'],'date_added'=>date('Y-m-d H:i:s')));
            }
            $response['check'] = 'success';
            $response['msg'] = 'Bookmarked Successfully';
        }elseif($data['bookmark_mode'] == 2){
            $this->executeDelete('casting_bookmark', array('uid'=>$data['uid'],'casting_id'=>$data['casting_id']));
            $response['check'] = 'success';
            $response['msg'] = 'Removed Successfully';
        }
        return $response;
    }
    public function all_casting_bookmark($data){
        // $uids = "SELECT DISTINCT(`uid`) from casting_apply  ";
        
        // $this->debugSql();
        $exp = $this->getResultAsArray("SELECT users.* from casting_bookmark cb inner join users ON cb.uid=users.id where 1");
        if(count($exp) > 0){

            foreach($exp as $k => $val){

                $casting =  $this->getResultAsArray("SELECT * from casting  INNER JOIN casting_apply ca ON casting.id =ca.casting_id   where ca.uid = '".$val['id']."' "); 
                 
                $cast = array(); 
                foreach($casting as $casting_key => $casting_value){
                    // $temp = array();
                    $casting_value['images'] =  !empty($casting_value['images']) 
                            ? array_map(function($img){
                                    return  CASTING_IMAGES_PATH.$img;
                                },explode(',',$casting_value['images'])) 
                            : '';
                    $casting_value['video'] = !empty($casting_value['video']) ? CASTING_DOCUMENT_PATH.$casting_value['video'] :'';

                    array_push($cast,$casting_value);

                }
                $exp[$k]['casting_apply']  = $cast;
            }
            return $exp;
        }else{
            return '';
        } 
    }
    public function all_cating_apply(){
                // SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting_apply';
                // $all_columns = $this->getSingleResult("SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting'");
                // SELECT * , (SELECT CONCAT('id' ) FROM casting LIMIT 1) as casting_data from casting_apply ca inner join users u on u.id =ca.uid where 1;
                // $this->echoPrint($all_columns);
        
                // $exp = $this->getResultAsArray("SELECT u.*,ca.casting_id  from casting_apply ca inner join users u on u.id =ca.uid where 1 group by ca.uid ");
                $uids = "SELECT DISTINCT(`uid`) from casting_apply  ";
                
                // $this->debugSql();
                $exp = $this->getResultAsArray("SELECT * from users where `id` IN ($uids) ");
                if(count($exp) > 0){
        
                    foreach($exp as $k => $val){
                        // unset($exp[$k][$val['create_date']]);
                        // unset($exp[$k][$val['modify_date']]);
                        // $temp['image'] =  !empty($val['images']) 
                        //     ? array_map(function($img){
                        //             return  CASTING_IMAGES_PATH.$img;
                        //         },explode(',',$val['images'])) 
                        //     : '';
                        // $temp['video'] = !empty($val['video']) ? CASTING_DOCUMENT_PATH.$val['video'] :'';  
        
                        $casting =  $this->getResultAsArray("SELECT * from casting  INNER JOIN casting_apply ca ON casting.id =ca.casting_id   where ca.uid = '".$val['id']."' "); 
                        // $casting =  $this->getResultAsArray("SELECT * from casting_apply  where uid = '".$val['id']."' "); 
                        $cast = array(); 
                        foreach($casting as $casting_key => $casting_value){
                            // $temp = array();
                            $casting_value['images'] =  !empty($casting_value['images']) 
                                    ? array_map(function($img){
                                            return  CASTING_IMAGES_PATH.$img;
                                        },explode(',',$casting_value['images'])) 
                                    : '';
                            $casting_value['video'] = !empty($casting_value['video']) ? CASTING_DOCUMENT_PATH.$casting_value['video'] :'';
        
                            array_push($cast,$casting_value);
        
                        }
                        $exp[$k]['casting_apply']  = $cast;
                    }
                    return $exp;
                }else{
                    return '';
                }   
            }
    
}