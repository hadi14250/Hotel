<?php
define("db_SERVER", "localhost");
define("db_USER", "root");
define("db_PASSWORD", "");
define("db_DBNAME", "hotel");


$con = mysqli_connect(db_SERVER, db_USER, db_PASSWORD, db_DBNAME);
if ($con) {
    //  echo (" Connection done  ");
} else {

    echo ("Error connecting the server " . mysqli_connect_error());
}




function filteration($data){
  foreach($data as $key => $value){
 $value= trim($value);
 $value= stripslashes($value);
 $value= strip_tags($value);
 $value= htmlspecialchars($value);

 $data[$key] = $value;
 
}
return $data;
}


 function select($sql,$values,$datatypes){

 $con = $GLOBALS['con'];
 if($stmt = mysqli_prepare($con,$sql)){
 mysqli_stmt_bind_param($stmt,$datatypes,...$values);
 if(mysqli_stmt_execute($stmt)){

  $res=mysqli_stmt_get_result($stmt);
  return $res;
 }
 else{
  mysqli_stmt_close($stmt);
  die("Query cannot be executed - Select");
 }
}
 else{

  die("Query cannot be prepared - Select");
 }
 }






 function update($sql,$values,$datatypes){

  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con,$sql)){
  mysqli_stmt_bind_param($stmt,$datatypes,...$values);
  if(mysqli_stmt_execute($stmt)){
 
   $res=mysqli_stmt_affected_rows($stmt);
   return $res;
  }
  else{
   mysqli_stmt_close($stmt);
   die("Query cannot be executed - Update");
  }
 }
  else{
 
   die("Query cannot be prepared - Update");
  }
  }


  function insert($sql,$values,$datatypes){
  $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql)){
    mysqli_stmt_bind_param($stmt,$datatypes,...$values);
    if(mysqli_stmt_execute($stmt)){
   
     $res=mysqli_stmt_affected_rows($stmt);
     return $res;
    }
    else{
     mysqli_stmt_close($stmt);
     die("Query cannot be executed - Insert");
    }
   }
    else{
   
     die("Query cannot be prepared - Insert");
    }
    }



 function selectAll($table){
$con = $GLOBALS['con'];
$res = mysqli_query($con,"SELECT * FROM $table");
return $res;
}




function delete($sql,$values,$datatypes){

  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con,$sql)){
  mysqli_stmt_bind_param($stmt,$datatypes,...$values);
  if(mysqli_stmt_execute($stmt)){
 
   $res=mysqli_stmt_affected_rows($stmt);
   return $res;
  }
  else{
   mysqli_stmt_close($stmt);
   die("Query cannot be executed - Delete");
  }
 }
  else{
 
   die("Query cannot be prepared - Delete");
  }
  }




?>