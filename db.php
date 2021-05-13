<?php
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

if(isset($_POST['submit'])&&!empty($_POST['submit'])){
    
    $sql = "insert into public accounts values('".$_POST['email']."','".md5($_POST['pwd'])."','".$_POST['img']."')";
    $ret = pg_query($dbconn, $sql);
    if($ret){
      
        echo "Data saved Successfully";
    }else{
      
        echo "Something Went Wrong";
  }
}

?>
