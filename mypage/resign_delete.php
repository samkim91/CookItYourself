<?php
  session_start();
  require('../dbconnect.php');
  $thisuser = $_SESSION['ses_uemail'];

  //넘겨 받은 값들 초기화
  $radio=$_POST["radio"];
  $checkbox=$_POST["checkbox"];
  $upw=$_POST["currentpw"];

  //값들 확인.. 나중에 주석/삭제

  echo $upw."<br>\n";

  //세션에 저장되어 있는 유저와 같은 값을 불러오는 sql문을 만듦
  $sql = "SELECT * FROM userlist WHERE uemail = '$thisuser'";
  // echo $sql;
  $result = mysqli_query($conn, $sql);

  if($result === false){
  echo "연결 실패: " . mysqli_error($conn);
  }else{
    $row = mysqli_fetch_assoc($result);
  }

  //회원탈퇴를 동의할 때 들어오는 조건문.. 동의하지 않으면 탈퇴가 되지 않음.
  if($checkbox){
    echo $checkbox."<br>\n";
    //비밀번호를 확인하는 곳.
    if($upw==$row['upw']){
      echo "비밀번호 확인완료";
      $sql_delete_user = "DELETE FROM userlist WHERE uemail = '$thisuser'";
      $result_delete_user = mysqli_query($conn, $sql_delete_user);

      if($result === false){
      echo "연결 실패: " . mysqli_error($conn);
      }else{
        echo "<script>alert(\"회원탈퇴가 완료되었습니다.\"); location.href='http://192.168.122.1/main.php'; </script>";
      }
      //레시피 삭제에 동의했으면 들어오는 조건문.. 모든 레시피가 날아가게끔 디비를 작성해놨다. 동의하지 않으면 레시피는 남겨진다.
      if($radio == "yes"){
        echo $radio."<br>\n";
        $sql_delete_posts = "DELETE FROM posts WHERE uemail = '$thisuser'";
        $result_delete_posts = mysqli_query($conn, $sql_delete_posts);
      }
    }else{
      echo "<script>alert(\"비밀번호가 일치하지 않습니다.\");  history.back(); </script>";
    }
  }else{
      echo "<script>alert(\"회원탈퇴에 동의해주세요.\");  history.back(); </script>";
  }

  session_destroy();
  $conn->close();
?>
