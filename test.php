<head></head>
<body>
<h1>Click here</h1>
<?php

// Data to be stored in JSON format
$data = array(
    "name" => "John Doe",
    "age" => 30,
    "city" => "New York"
);

// Convert data to JSON format
$jsonData = json_encode($data);

// File path where JSON data will be stored
$filePath = "resources/json/example.json";

// Check if the file already exists
if (!file_exists($filePath)) {
    // Write JSON data to the file
    file_put_contents($filePath, $jsonData);
    echo "JSON file '$filePath' has been created.";
} else {
    echo "JSON file '$filePath' already exists.";
}

die();
?>

<button data-target="#my-element">Click me!</button>
<div id="my-element" style="display: none;">This is my element!565656</div>

<form action="#">
  <button type="submit" data-target="#my-modal">Open modal</button>
</form>
</body>
<style>
#my-element:target {
  display: block;
  background-color: red;
  border:2px solid balck;

}

</style>
<script>
// fetch('https://dummyjson.com/products/')
// .then((response)=>{
//    return response.text();
 
//   })
// fetch('https://jsonplaceholder.typicode.com/users',{
fetch('ajax/ajaxHandller.php',{

method : "POST",
body: JSON.stringify({ // convert obj. to json
  ajax_action : 'fetch_category_data'
}),
header:{
  'Content-Type':'application/json; charset=UTF-8', //if json data
  // 'Content-Type' : 'application/x-www-form-urlencoded'  //when send form data
},

})
.then(response=> response.json())
 
  
  .then(function(result){
    
      console.log(result);
      // for(var x in result){
        document.write(`${result.msg}`+'<br>');
        
      // }
  })
  //if found error
  .catch(function(error){//return server error
    document.write(error);
      console.log(error);
  });  
  

</script>







