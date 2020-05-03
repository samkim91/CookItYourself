<?php
    require('../dbconnect.php');
    // echo "진입";
    // 회원가입 양식에서 post로 받아온 변수들을 선언함
    $uemail = $_POST["uemail"];
    $uname = $_POST["uname"];
    $upw = $_POST["upw"];
    $upwconfirm = $_POST["upwconfirm"];

    // // 데이터베이스 접속을 위해 필요한 변수들을 선언함.
    // $servername = "localhost";
    // $username = "root";
    // $password = "1234qwer";
    // $dbname = "ciydb";
    //
    // //데이터 베이스 연결 함수 선언
    // $conn = mysqli_connect($servername, $username, $password, $dbname);
    // // echo "변수". $uemail . $uname . $upw;
    //
    // // 데이터베이스 연결 함수에 에러가 있는지 확인
    // if(mysqli_connect_errno($conn)){
    //     die("Connection failed: " . mysqli_error($conn));
    // }else{
    //     // echo "연결 성공";
    // }

    // if ($upw != $upwconfirm){
    //     echo "<script> alert(\"비밀번호가 일치하지 않습니다.\");</script>";
    // }

    // 아이디 중복검사를 위한 sql문 만듦
    $sqlforchk = "SELECT * FROM userlist WHERE uemail = '$uemail'";
        // echo "select". $sql;
    $resultforchk = mysqli_query($conn, $sqlforchk);
    $rowforchk = mysqli_fetch_assoc($resultforchk);
    //sql문 쿼리를 보내고, 받은 것을 $resultforchk에 담음. mysqli_fetch_assoc을 이용해서 이 값을 배열화함.

    //아이디 중복검사 및 각종 예외처리를 하는 부분, 이상이 없으면 회원가입까지 됨.
    if($rowforchk['$uemail']!=null){
      echo "<script>alert(\"이미 존재하는 아이디입니다.\"); history.back(); </script>";
    }else{
      if($uemail==null||$uname==null||$upw==null||$upwconfirm==null){
        echo "<script>alert(\"값을 모두 입력해주세요.\"); history.back(); </script>";
      }else{
        if($upw != $upwconfirm){
          echo "<script>alert(\"비밀번호가 일치하지 않습니다.\"); history.back(); </script>";
        }else{
          $sql = "INSERT INTO userlist (uemail, uname, upw) values ('$uemail', '$uname', '$upw')";
              // echo "insert";
          $result = mysqli_query($conn, $sql);
              // echo "결과";
          if($result === false ){
              echo "회원가입 실패: " . mysqli_error($conn);
          }else{
              echo "<script>alert(\"회원가입이 완료되었습니다.\");  document.location.href='http://192.168.122.1/login/login.php'; </script>";
          }
        }
      }
    }

    $conn->close();

?>
