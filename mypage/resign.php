<?php
session_start();
include('../head.php');
require('../dbconnect.php');

//세션에 저장되어 있는 유저와 같은 값을 불러오는 sql문을 만듦
$thisuser = $_SESSION['ses_uemail'];
$sql = "SELECT * FROM userlist WHERE uemail = '$thisuser'";
// echo $sql;
$result = mysqli_query($conn, $sql);

if($result === false){
echo "연결 실패: " . mysqli_error($conn);
}else{
//불러온 값을 row 에 담음
$row = mysqli_fetch_assoc($result);

//가져온 row가 널인지 아닌지 확인함.
if($row != null){
  $uemail = $row['uemail'];
  $uname = $row['uname'];
  $upw = $row['upw'];
  // $image = $row['image'];    나중에 추가
}else{
  echo "none";
}
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <style type ="text/css">

    #form {
        width : 33%;
        margin : 0 auto;
        margin-top : 5%;
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        padding : 20px;
    }
    #resign {
      margin-top: 15px;
      border: 1px solid;
      background-color: rgb(224, 137, 20);
      color: rgb(255, 255, 255);
      padding: 10px;
      border-radius: 5px;
    }
    #resign:hover {
      background-color: rgb(221, 181, 13);
      cursor: pointer;
    }
    h2{
      text-align: center;
    }
    p, h4{
      color: rgb(224, 137, 20);
    }
    .textline{
      margin-top: 50px;
    }
    #checkbox{
      margin-top: 30px;
    }
    #resign{
      margin-top: 30px;
    }
    </style>

</head>
<body>
  <!-- 회원가입 양식을 만듦. 값은 post로 보냄 -->
    <div id = "form">
        <form id = "resign-form" method = "POST" action = "http://192.168.122.1/mypage/resign_delete.php">
          <h2>회원탈퇴</h2>
          <div class="textline">
            <p>등록된 레시피를 모두 삭제하시겠습니까?</p>
            <p>"아니오"를 클릭하시면 레시피는 남겨집니다.</p>
          </div>
          <input type="radio" name="radio" id="radio" value="yes" required> 예
          <input type="radio" name="radio" id="radio" value="no" required> 아니오
          <h4>비밀번호를 입력해주세요.</h4>
          <input type="password" name="currentpw" size="30" placeholder="현재 비밀번호를 입력해주세요." required><br>
          <input type="checkbox" name="checkbox" id="checkbox" value="chkresign" required> 정말로 탈퇴를 원하시면 체크해주세요.<br>
          <input type="submit" id="resign" name="resign" value="탈퇴하기">
        </form>
    </div>
</body>
</html>
