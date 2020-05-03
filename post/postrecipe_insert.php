<?php
    //데이터베이스 연결하는 php파일을 require로 선언하고, Post로 받아온 각종 값들을 선언한다. 이메일과 이름은 세션에서 받아온다.
    require('../dbconnect.php');
    // 레시피 등록을 위해 get으로 보낸 변수들을 선언함.
    session_start();
    $uemail=$_SESSION['ses_uemail'];
    // "kim@naver.com";
    $uname=$_SESSION['ses_uname'];
    // "hahaha";
    $subject=$_POST['subject'];
    $explainline=$_POST['explainline'];
    $foodname=$_POST['foodname'];

    //포스트로 받아온 재료의 정보를 모두 불러내어서 데이터베이스에 저장하기 위해 하나의 변수로 합쳐주는 것이다.
    for($i=0 ; $i<sizeof($_POST['ingredient']) ; $i++){
      $ingredient = $_POST['ingredient'][$i];
      $amount = $_POST['amount'][$i];

      if($i==sizeof($_POST['ingredient'])-1){
        $totalingredient .= $ingredient."///".$amount;
      }else{
        $totalingredient .= $ingredient."///".$amount."+++";
      }
    }
    // echo $totalingredient;
    $time=$_POST['time'];
    $content=$_POST['ir1'];

    // echo "디비 진입<br> $content";
    // // 디비에 접근하기 위한 구문
    // $servername = "localhost";
    // $username = "root";
    // $password = "1234qwer";
    // $dbname = "ciydb";
    // $conn = mysqli_connect($servername, $username, $password, $dbname);
    //
    // if(mysqli_connect_errno($conn)){
    //     die("Connection failed: " . mysqli_error($conn));
    // }else{
    //     // echo "연결 성공";
    // }

    //각종 값들이 비어있는지 확인한다.
    if($subject!=null && $explainline!=null && $foodname!=null && $totalingredient!=null && $time!=null && $content!=null){
      //데이터베이스에 넣기 위한 sql 문을 선언한다.
      for($i = 0 ; $i < 5 ; $i++){
        $sql = "INSERT INTO posts (uemail, uname, title, shorttext, foodname, ingredient, time, content, scraped) values ('$uemail', '$uname', '$subject', '$explainline', '$foodname', '$totalingredient', '$time', '$content', 0)";
            // echo "insert";
        $result = mysqli_query($conn, $sql);
            // echo "결과";
      }

      if($result === false ){
          echo "등록 실패: " . mysqli_error($conn);
      }else{
          echo "<script>alert(\"등록이 완료되었습니다.\");  document.location.href='http://192.168.122.1/post/posts.php'; </script>";
      }


    }else{
      echo "<script>alert(\"빈칸을 채워주세요.\"); history.back(); </script>";
    }

    $conn->close();
?>
