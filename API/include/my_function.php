<?php
include_once('constant.php');
class MY_Function {
    function push_notification_android($device_id,$Title, $Remarks,$type=''){
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        //demo fcm api key
        $api_key = 'AAAAkacTpjk:APA91bERLUoJG-lIKT0u5IOa4yNpRf3CHzMWAspXJp1JvkrC_JQlBr9atS4UUbPhcy0sHRE8LV38E6zlbQRT8LLptkMpHsKACHIIqTjNmEFUc8954A0g4G3GnMfKB1UhsyeYK_BbM6vU';

		// $api_key=get_school_details()['fcm_key'];

    
        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "title" => $Title,
                    "body" => $Remarks,
                    "type"=>$type
                )
        );
    
        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
}



}
		