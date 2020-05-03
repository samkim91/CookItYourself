<?php
  session_start();
  require('../dbconnect.php');
  echo "진입";
  // 회원가입 양식에서 post로 받아온 변수들을 선언함
  $uemail = $_SESSION['ses_uemail'];
  $uname = $_POST["uname"];
  $upw = $_POST["upw"];
  $upwconfirm = $_POST["upwconfirm"];
  $currentpw = $_POST["currentpw"];
  // 아이디 중복검사를 위한 sql문 만듦
  $sqlforchk = "SELECT * FROM userlist WHERE uemail = '$uemail'";
      echo "select". $sqlforchk;
  $resultforchk = mysqli_query($conn, $sqlforchk);
  $rowforchk = mysqli_fetch_assoc($resultforchk);
  // sql문 쿼리를 보내고, 받은 것을 $resultforchk에 담음. mysqli_fetch_assoc을 이용해서 이 값을 배열화함.
      echo "row". $rowforchk['upw'] . $currentpw;
  // 아이디 중복검사 및 각종 예외처리를 하는 부분, 이상이 없으면 회원가입까지 됨.
  if($uname==null){
    echo "<script>alert(\"닉네임은 설정하셔야 합니다.\"); history.back(); </script>";
  }else{

    if($upw != $upwconfirm){
      echo "<script>alert(\"새로운 비밀번호가 일치하지 않습니다.\"); history.back(); </script>";
    }else{
      if($rowforchk['upw'] != $currentpw){
        echo "<script>alert(\"현재 비밀번호가 일치하지 않습니다.\"); history.back(); </script>";
      }else{
        //내 정보를 수정할 업데이트 sql문 만듦

        //수정할 비밀번호가 있다면 sql문을 패스워드까지 변경하는 것으로 만들고, 아니면 그냥 닉네임만 변경하도록 한다.
        if($upw!="" && $upwconfirm!=""){
          //TODO 비밀번호 정규식??!!
          $pattern = "/^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/";
          if(preg_match($pattern, $upw, $matches)){
            $sql = "UPDATE userlist SET uname ='$uname', upw = '$upw' WHERE uemail = '$uemail' LIMIT 1";
          }else{
            echo "<script>alert(\"어려운 비밀번호로 다시 만들어주세요.\"); history.back(); </script>";
          }
        }else{
          $sql = "UPDATE userlist SET uname ='$uname' WHERE uemail = '$uemail' LIMIT 1";
        }
            // echo "insert";
        $result = mysqli_query($conn, $sql);
            // echo "결과";
        if($result === false ){
            echo "프로필 수정 실패: " . mysqli_error($conn);
        }else{
            //세션의 네임도 수정해줌
            $_SESSION['uname'] = $uname;

            //닉네임 바뀌었으니, 게시글 이름도 다 바꿔줌.
            $sql_posts_update = "UPDATE posts SET uname ='$uname' WHERE uemail = '$uemail'";
            $result_posts_update = mysqli_query($conn, $sql_posts_update);
            echo "<script>alert(\"프로필 수정이 완료되었습니다.\");  document.location.href='http://192.168.122.1/mypage/mypage.php'; </script>";
        }
      }
    }
  }

  $conn->close();

?>
