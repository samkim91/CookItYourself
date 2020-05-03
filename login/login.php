<?php
include('../head.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <style type ="text/css">

        label{
          margin-top: 10px;
        }
        input{
          margin-top: 10px;
        }

        #div-login{
            width : 30%;
            margin : 0 auto;
            margin-top : 200px;
            border: 3px solid rgb(224, 137, 20);
            border-radius: 5px;
            padding: 20px;
        }
        p{
            text-align : center;
        }
        #login {
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 10px;
          border-radius: 5px;
        }
        #login:hover {
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        .tag{
          text-decoration: none;
          color: rgb(224, 137, 20);
        }
        .tag:hover{
          color: rgb(221, 181, 13);
        }
        </style>
    </head>

    <body>
      <!-- 로그인 양식을 만들어주는 부분 -->
      <div id="div-login">
        <form id = "login-form" method = "POST" action= "http://192.168.122.1/login/login_select.php">
            <label class="legend">이메일 주소</label><br>
            <input type="email" name="uemail" size="30"><br>
            <label class="legend">비밀번호</label><br>
            <input type="password" name="upw" size="30"><br>

            <input type="submit" id="login" name="login" value="로그인">

        </form>

        <p>
            <a class="tag" href="findpw.php">비밀번호 찾기</a>
            <a class="tag" href="signup.php" style="margin-left:20px">회원가입</a>
        </p>
        <!-- <input type="button" name="signin" value="회원가입" onclick="location.href='signup.php'"> -->
      </div>
    </body>
</html>
