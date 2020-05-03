<?php
    // echo "진입";
    session_start();
    require('../dbconnect.php');
    // 아이디를 유지시키기 위한 세션 생성
    // post로 보낸 변수들을 받아서 지정하고, 데이터베이스에 연결하기 위한 값들을 변수화 함.
    $uemail = $_POST["uemail"];
    $upw = $_POST["upw"];


    // sql문을 만듦. 유저리스트에서 입력된 이메일과 비밀번호를 찾는 것.
    // $sql = "SELECT * FROM userlist";
    $sql = "SELECT * FROM userlist WHERE uemail = '$uemail' AND upw = '$upw'";
        // echo "select". $sql;
    //sql 쿼리를 보내고 결과값을 리절트 변수에 담음
    $result = mysqli_query($conn, $sql);

      //결과값이 있는지 없는지 확인.. todo 나중에 삭제해야함.
      if(mysqli_num_rows == 0){
          // echo "no result";
      }else{
          // echo "yes!";
      }
    // if(!$result){
    //     echo mysqli_error();
    // }

    // $result = $conn -> query($sql);

    //아이디 비밀번호 검사하고 맞으면 넘어가는 부분.. 예외처리를 모두 해줬음.
    if($uemail==null||$upw==null){
      echo "<script>alert(\"아이디와 비밀번호를 입력해주세요.\");  history.back(); </script>";
    }else{
      if($result === false ){
          // echo "연결 실패: " . mysqli_error($conn);
      }else{
          // echo "연결 성공";

          $row = mysqli_fetch_assoc($result);
          // echo "결과까지 나옴 :". $row;

          if($row != null){
              // echo "로그인 하러 옴";
              $_SESSION['ses_uemail']=$row['uemail'];
              $_SESSION['ses_uname']=$row['uname'];
              echo "<script>alert(\"환영합니다.\");  document.location.href='http://192.168.122.1/main.php'; </script>";
          }else {
              echo "<script>alert(\"아이디 혹은 비밀번호가 일치하지 않습니다.\");  history.back(); </script>";
          }

          // if(mysqli_num_rows($result) ==1 ){
          //     $row = mysqli_fetch_assoc($result);
          //     if($row['pw']==$upw){
          //         $_SESSION['ses_uemail']=$uemail;
          //         if(isset($_SESSION['ses_uemail'])){
          //             echo "<script>alert(\"로그인 되었습니다.\");  document.location.href='../main.php'; </script>";
          //         }else{
          //             echo "세션이 일치하지 않습니다.";
          //         }
          //     }else{
          //         echo "<script>alert(\"아이디 혹은 비밀번호가 일치하지 않습니다.\");  history.back(); </script>";
          //     }
          // }else{
          //     echo "<script>alert(\"존재하지 않는 아이디입니다.\");  history.back(); </script>";
          // }
      }
    }


    $conn->close();

    ?>
