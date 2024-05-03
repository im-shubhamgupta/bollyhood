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
    /*
    public function all_casting_bookmark($data){
        // $uids = "SELECT DISTINCT(`uid`) from casting_apply  ";
       
        // $exp = $this->getResultAsArray("SELECT users.*,IF(`categories` = '' || `categories` IS NULL, '0', `categories`) as catt from casting_bookmark cb inner join users ON cb.uid=users.id where cb.uid='".$data['uid']."' group by cb.uid");
        // $exp = $this->getResultAsArray("SELECT users.*,IF(`categories` = '' || `categories` IS NULL, '0', `categories`) as catt from users where id IN (SELECT uid from casting_bookmark where uid = ".$data['uid'].") ");
        $exp = $this->getResultAsArray("SELECT users.*,IF(`categories` = '' || `categories` IS NULL, '0', `categories`) as catt from users where id = ".$data['uid']." ");
        if(count($exp) > 0){
            
            foreach($exp as $k => $val){
                $exp[$k]['image'] = !empty($val['image']) ? USER_IMAGE_PATH.$val['image'] : '';

                //join casting with casting_apply and if casting apply is null then pass empty value

                $casting =  $this->getResultAsArray("SELECT casting.*,ca.images,ca.video from casting  LEFT JOIN casting_apply ca ON casting.id =ca.casting_id and ca.uid = ".$val['id']."  where casting.id IN (SELECT casting_id from casting_bookmark where uid = ".$val['id']." ) ");//ca.uid = '".$val['id']."'
                // $this->debugSql();
                 
                $cast = array(); $i=0;
                foreach($casting as $casting_key => $casting_value){
                    if($i == 3) $i = 0;
                    $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$val['catt'].") ");

                    $casting_value['category'] = $category;
                    // $temp = array();
                    $casting_value['document'] = !empty($casting_value['document']) ? CASTING_DOCUMENT_PATH.$casting_value['document'] : '';
                    $casting_value['images'] =  !empty($casting_value['images']) 
                            ? array_map(function($img){
                                    return  CASTING_IMAGES_PATH.$img;
                                },explode(',',$casting_value['images'])) 
                            : array();
                    $casting_value['video'] = !empty($casting_value['video']) ? CASTING_DOCUMENT_PATH.$casting_value['video'] :'';

                    $casting_value['company_logo'] = !empty($casting_value['company_logo']) ? COMPANY_LOGO_PATH.$casting_value['company_logo'] : '';
                    $casting_value['type'] = CASTING_COLOR[$i];

                    array_push($cast,$casting_value);
                    $i++;                
                }
                $exp[$k]['casting_apply']  = $cast;
            }
            return $exp;
        }else{
            return '';
        } 
    }*/
    public function all_casting_bookmark($data){

        $casting =  $this->getResultAsArray("SELECT casting.*,ca.images,ca.video from casting  LEFT JOIN casting_apply ca ON casting.id =ca.casting_id and ca.uid = ".$data['uid']."  where casting.id IN (SELECT casting_id from casting_bookmark where uid = ".$data['uid']." ) ");
            
        $cast = array(); $i=0;
        foreach($casting as $casting_key => $casting_value){
            if($i == 3) $i = 0;
            // $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$val['catt'].") ");

            // $casting_value['category'] = $category;
            
            $casting_value['document'] = !empty($casting_value['document']) ? CASTING_DOCUMENT_PATH.$casting_value['document'] : '';
            $casting_value['images'] =  !empty($casting_value['images']) 
                    ? array_map(function($img){
                            return  CASTING_IMAGES_PATH.$img;
                        },explode(',',$casting_value['images'])) 
                    : array();
            $casting_value['video'] = !empty($casting_value['video']) ? CASTING_DOCUMENT_PATH.$casting_value['video'] :'';

            $casting_value['company_logo'] = !empty($casting_value['company_logo']) ? COMPANY_LOGO_PATH.$casting_value['company_logo'] : '';
            $casting_value['type'] = CASTING_COLOR[$i];

            array_push($cast,$casting_value);
            $i++;                
        }
    return $cast;
       
    }
    public function all_cating_apply(){//getagency
               
        $uids = "SELECT DISTINCT(`uid`) from casting_apply  ";
        $exp = $this->getResultAsArray("SELECT users.*,IF(`categories` = '' || `categories` IS NULL, '0', `categories`) as catt from users where `id` IN ($uids) ");
        if(count($exp) > 0){
            foreach($exp as $k => $val){
                $exp[$k]['image'] = !empty($val['image']) ? USER_IMAGE_PATH.$val['image'] : '';

                $casting =  $this->getResultAsArray("SELECT * from casting  INNER JOIN casting_apply ca ON casting.id =ca.casting_id   where ca.uid = '".$val['id']."' "); 
                
                $cast = array(); $i=0;
                foreach($casting as $casting_key => $casting_value){
                    if($i == 3) $i = 0;
                    $category = $this->getResultAsArray("SELECT id as category_id,`category_name`,`type`,IF(`category_image` = '' , '',CONCAT('".CATEGORY_IMAGE_PATH."',`category_image`)) as `cat_image` from category where id IN (".$val['catt'].") ");

                    $casting_value['category'] = $category;

                    $casting_value['document'] = !empty($casting_value['document']) ? CASTING_DOCUMENT_PATH.$casting_value['document'] : '';

                    $casting_value['images'] =  !empty($casting_value['images']) 
                            ? array_map(function($img){
                                    return  CASTING_IMAGES_PATH.$img;
                                },explode(',',$casting_value['images'])) 
                            : array();
                    $casting_value['video'] = !empty($casting_value['video']) ? CASTING_DOCUMENT_PATH.$casting_value['video'] :'';

                    $casting_value['company_logo'] = !empty($casting_value['company_logo']) ? COMPANY_LOGO_PATH.$casting_value['company_logo'] : '';

                    $casting_value['type'] = CASTING_COLOR[$i];

                    array_push($cast,$casting_value);
                    $i++;
                }
                $exp[$k]['casting_apply']  = $cast;
            }
            return $exp;
        }else{
            return '';
        }   
    }
    
}


// SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting_apply';
                // $all_columns = $this->getSingleResult("SELECT GROUP_CONCAT(column_name SEPARATOR ',') AS all_columns FROM information_schema.columns WHERE table_name = 'casting'");
                // SELECT * , (SELECT CONCAT('id' ) FROM casting LIMIT 1) as casting_data from casting_apply ca inner join users u on u.id =ca.uid where 1;
                // $this->echoPrint($all_columns);