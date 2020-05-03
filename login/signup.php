<?php
include('../head.php');
?>

<!DOCTYPE html>
<html>
    <head>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>


      <!-- <script>
      $(function(){
          $('#userPw').keyup(function(){
            $('#chkNotice').html('');
          });

          $('#userPwChk').keyup(function(){

              if($('#userPw').val() != $('#userPwChk').val()){
                $('#chkNotice').html('비밀번호 일치하지 않음<br><br>');
                $('#chkNotice').attr('color', '#f82a2aa3');
              } else{
                $('#chkNotice').html('비밀번호 일치함<br><br>');
                $('#chkNotice').attr('color', '#199894b3');
              }

          });
      }); -->

      </script>

        <style type ="text/css">

        #login-form label{
            margin-top : 10px;
        }

        #login-form input{
            margin-top : 5px;
        }

        #form {
            width : 30%;
            margin : 0 auto;
            margin-top : 200px;
            border: 3px solid rgb(224, 137, 20);
            border-radius: 5px;
            padding : 20px;
        }
        #signup {
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 10px;
          border-radius: 5px;
        }
        #signup:hover {
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        </style>

    </head>
    <body>
      <!-- 회원가입 양식을 만듦. 값은 post로 보냄 -->
        <div id = "form">
            <form id = "login-form" method = "POST" action = "http://192.168.122.1/login/signup_insert.php">
                <label class="legend">이메일 주소</label><br>
                <input type="email" name="uemail" size="30" placeholder="이메일을 입력하세요" required><br>
                <label class="legend">닉네임</label><br>
                <input type="text" name="uname" size="30" placeholder="닉네임을 입력하세요" required><br>
                <label class="legend">비밀번호</label><br>
                <input type="password" class="pwd" id="upw" name="upw" size="30" placeholder="영문자, 숫자, 특수문자 조합 8~16자리" required><br>
                <div id="alert_invalid" style="color:red;">영문자, 숫자, 특수문자 조합 8~16자리로 만들어주세요.</div>
                <div id="alert_valid" style="color:blue;">사용가능한 비밀번호 입니다.</div>
                <label class="legend">비밀번호 확인</label><br>
                <input type="password" class="pwd" id="upwconfirm" size="30" name="upwconfirm" required><br>
                  <div id="alert_unmatch" style="color:red;">비밀번호가 일치하지 않습니다.</div>
                  <div id="alert_match" style="color:blue;">비밀번호가 일치합니다.</div>
                <input type="submit" id="signup" name="signup" value="가입하기">
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
                    $("#signup").removeAttr("disabled");
                  }else{
                    $("#alert_valid").hide();
                    $("#alert_invalid").show();
                    $("#signup").attr("disabled", "disabled");
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
                      }else{
                        $("#alert_match").hide();
                        $("#alert_unmatch").show();
                      }
                    }

                  });
              });
            </script>


        </div>
    </body>
</html>
