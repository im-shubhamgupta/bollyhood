<?php
// make isValidImg()
   
$response = array('check'=>'error' , 'msg'=>'Access Denied');
if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
$submit_action = isset($_POST['submit_action']) ? escapeStringTrim($_POST['submit_action']) : '';
switch($submit_action){
	case 'add_document':
        $msg = 'Something Went Wrong Please try again';
		$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );

        $image = $_FILES['image'];
        $img_names = array();
        $valid_ext = array('png','jpg','jpeg','PNG','JPG','JPEG');
        if (!is_dir(DIR.'/resources/img/doc_img') ) {
            mkdir(DIR.'/resources/img/doc_img'); 
        }
        
        if($_POST['id'] > 0){
            $id = escapeStringTrim($_POST['id']);
        

            $data = executeSelectSingle('document',array(),array('id' => $id));
            

            $temp = array(
                'name' => escapeStringTrim($_POST['name']),
                'category' => escapeStringTrim($_POST['category']),
            );
            if(!empty($_POST['name'])){

                foreach($image['error'] as $key => $val){
                    $imageFileType = strtolower(pathinfo(basename($image['name'][$key]),PATHINFO_EXTENSION));
        
                    $valid_imgname = date('Ymd_His')."_"."doc_img".".".$imageFileType; 
                    if(in_array($imageFileType,$valid_ext)){
                       if( move_uploaded_file($image['tmp_name'][$key], DIR.'/resources/img/doc_img/'.$valid_imgname)){
                            $img_names[] =  $valid_imgname;
                       }
                    }else{
                        $response['msg']  = "Accept only .png, .jpg, .jpeg Extension Image only";
                    }  
                }
                $temp_img =  $data['image'];
                $current_img = !empty($img_names) ? implode(',',$img_names) :'';
                $temp['image'] = $temp_img.','.$current_img;
            }
            

            $update = executeUpdate('document', $temp, array('id' => $id));
            if($update){
                $response['check'] = 'success';
                $response['msg'] = 'Data Updated Successfully';
   
            }
            // debugSql();

        }else{
            foreach($image['error'] as $key => $val){
                $imageFileType = strtolower(pathinfo(basename($image['name'][$key]),PATHINFO_EXTENSION));
    
                $valid_imgname = date('Ymd_His')."_"."doc_img".".".$imageFileType; 
                if(in_array($imageFileType,$valid_ext)){
                   if( move_uploaded_file($image['tmp_name'][$key], DIR.'/resources/img/doc_img/'.$valid_imgname)){
                        $img_names[] =  $valid_imgname;
                   }
                }else{
                    $response['msg']  = "Accept only .png, .jpg, .jpeg Extension Image only";
                }  
            }
            $data = array(
                'name' => escapeStringTrim($_POST['text']),
                'image' => implode(',',$img_names),
                'category' => escapeStringTrim($_POST['category']),
                'create_date' => date("Y-m-d H:i:s")
            );
             
            $insert = executeInsert('document',$data);

            if($insert){
                $response['check'] = 'success';
                $response['msg'] = 'Data Inserted Successfully';
   
            }
        }
		redirect('all_document',$response);
		die;	
	break;
	default : 
		$response['check'] = 'error';
		$response['msg'] = 'Bad Request';
	break;	
}
// 
if(empty($_POST['submit_action'])){
	echo json_encode($response);
}
}
//redirect('home',$msg);//you can set comma paramenter sessio flush


?>