<?php
$dbconn= pg_connect("host=localhost dbname=filmshare user=postgres password=giorno99");

/*
$query= "SELECT email FROM accounts";
$result= pg_query($query) or die ( "Query failed: ". pg_lasterror());
$emails= array();
echo "<table>\n";
while ( $line = pg_fetch_array ( $result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach( $line as $col_value) {
        echo "\t\t<td>$col_value </td>";
        array_push($emails,  $col_value);
    }
    echo "\t</tr>\n";
}
echo "</table>\n" ;
print_r($emails);
pg_freeresult( $result) ;
pg_close( $dbconn );

*/

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
