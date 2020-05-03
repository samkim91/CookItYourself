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
            width : 30%;
            margin : 0 auto;
            margin-top : 5%;
            border: 3px solid rgb(224, 137, 20);
            border-radius: 5px;
            padding : 20px;
        }
        #edit {
          margin-top: 15px;
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 10px;
          border-radius: 5px;
        }
        #edit:hover {
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        h2{text-align: center;}
        h3{
          color: rgb(224, 137, 20);
        }
        </style>

    </head>
    <body>
      <!-- 회원가입 양식을 만듦. 값은 post로 보냄 -->
        <div id = "form">
            <form id = "login-form" method = "POST" action = "http://192.168.122.1/mypage/myprofile_update.php">
              <h2>프로필 수정</h2>
              <h3>이메일 주소</h3>
              <p><?php echo $uemail?></p>
              <h3>닉네임</h3>
              <input type="text" name="uname" size="30" placeholder="닉네임을 입력하세요" value=<?php echo $uname?>><br>
              <h3>비밀번호</h3>
              <input type="password" class="pwd" id="upw" name="upw" size="30" placeholder="영문자, 숫자, 특수문자 조합 8~16자리"><br>
              <div id="alert_invalid" style="color:red;">영문자, 숫자, 특수문자 조합 8~16자리로 만들어주세요.</div>
              <div id="alert_valid" style="color:blue;">사용가능한 비밀번호 입니다.</div>
              <h3>비밀번호 확인</h3>
              <input type="password" class="pwd" id="upwconfirm" name="upwconfirm" size="30"><br>
              <div id="alert_unmatch" style="color:red;">비밀번호가 일치하지 않습니다.</div>
              <div id="alert_match" style="color:blue;">비밀번호가 일치합니다.</div>
              <h3>현재 비밀번호</h3>
              <input type="password" name="currentpw" size="30" placeholder="현재 비밀번호를 입력해주세요." required><br>

              <input type="submit" id="edit" name="edit" value="수정완료">
            </form>

            <script>
            $(function(){
              $("#alert_match").hide();
              $("#alert_unmatch").hide();
              $("#alert_invalid").hide();
              $("#alert_valid").hide();
              $("#upw").keyup(function(){
                var upw=$("#upw").val();
                //비밀번호가 정규식을 따르는지 확인하는 곳(영대소문자, 숫자, 특수문자 8~16자리)
                var pwRule = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/.test(upw);
                // if(upw!=""){
                //   $("#alert_invalid").hide();
                // }else{
                //   $("#alert_invalid").show();
                // }
                if(pwRule){
                  $("#alert_valid").show();
                  $("#alert_invalid").hide();
                }else{
                  $("#alert_valid").hide();
                  $("#alert_invalid").show();
                }
                });

                $(".pwd").keyup(function(){
                  //비밀번호 일치 여부를 확인하는 곳
                  var upw=$("#upw").val();
                  var upwconfirm=$("#upwconfirm").val();
                  if(upw != "" || upwconfirm != ""){
                    if(upw == upwconfirm){
                      $("#alert_match").show();
                      $("#alert_unmatch").hide();
                      $("#signup").removeAttr("disabled");
                    }else{
                      $("#alert_match").hide();
                      $("#alert_unmatch").show();
                      $("#signup").attr("disabled", "disabled");
                    }
                  }

                });
            });
            </script>
        </div>
    </body>
</html>
