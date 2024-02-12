<?php
   /* Online PHP Compiler (Interpreter) and Editor */
  $a = [
      'a'=>1,
       'b'=>2,
        'c'=>3,
    ];
    $arr = array();
    echo "<pre>";
     print_r($a);
    foreach($a as $key => $val){
        
        $arr[$val] = $key;
        
    }
    print_r($arr);
?>