<?php
// 디비에 접근하기 위한 구문
$servername = "localhost";
$username = "root";
$password = "1234qwer";
$dbname = "ciydb";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(mysqli_connect_errno($conn)){
    die("Connection failed: " . mysqli_error($conn));
}else{
    // echo "연결 성공";
}

 ?>
