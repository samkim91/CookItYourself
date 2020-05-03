<?php
include('../head.php');
?>

<html>
    <head>
        <style type ="text/css">

        #login-form label{
            margin-top : 10px;
        }

        #login-form input{
            margin-top : 5px;
        }

        #login-form{
            margin : 20px;
        }

        #findingform{
            width : 30%;
            margin : 0 auto;
            margin-top : 200px;
            border : 1px solid black;
            border-radius : 5px;
            padding: 20px;
        }
        p{
            text-align : center;
            margin : 10px;
        }
        #confirm, #back{
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 10px;
          border-radius: 5px;
        }
        #confirm:hover, #back:hover {
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }

        </style>

    </head>

    <body>
      <!-- 비밀번호를 찾기 위한 html 양식임.-->
      <div id="findingform">
        <p>"가입하신 이메일 주소를 입력해주시면 임시 비밀번호가 전송됩니다."</p>
        <form id = "login-form" method = "POST" action="http://192.168.122.1/login/sendemail.php">

          <?php // TODO: 입력된 아이디를 데이터베이스에서 검색하여 있는지 확인할 필요가 있고, 있다면 임시 비밀번호를 만들어서 이메일로 전송해주는 과정이 필요.. ?>

            <label class="legend">이메일 주소</label><br>
            <input type="email" id="uemail" name="uemail" size="25" required><br>

            <input type="submit" id="confirm" name="confirm" value="확인">
            <input type="button" id="back" name="back" value="돌아가기" onclick="location.href='http://192.168.122.1/login/login.php'">
        </form>
      </div>
    </body>
  </html>
