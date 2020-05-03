<?php

echo "DB connection test";

$db = mysqli_connect("localhost", "root", "1234qwer", "test");

if($db){
echo "success";
}else{
echo "failed";
}

phpinfo();
?>
