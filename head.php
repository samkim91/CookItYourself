<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Cook It Yourself</title>
    <link rel="stylesheet" type="text/css" href="http://192.168.122.1/menu-css.css">
    <link href="//fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <style>
      /* #search {float : left; display : block ; background-color : #FFDAB9 ; padding : 12px ;} */
      /* #wrapper{
          width:1000px;
          margin: 0 auto;
      } */
      /* #login {float : right;} */
      body { width: 1000px; margin: 0 auto;}
      #header{
        display : block; width: 100%; margin: 4px;
      }
      #nav{
        display : inline; width: 100%; margin: 4px;
      }

      #searching {
        margin-right: -4px;
        border: 1px solid;
        background-color: rgb(224, 137, 20);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 5px;
      }
      #category {
        margin-left: -3px;
        border: 1px solid;
        background-color: rgb(224, 137, 20);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
      }
      #searching:hover, #category:hover{
        background-color: rgb(221, 181, 13);
        cursor: pointer;
      }
      #subject{
        font-family: 'Lobster';
        color: rgb(224, 137, 20);
      }
      .chat_btn{
        width: 70px;
        height: 40px;
        position: fixed;
        right: 50%;
        top: 120px;
        margin-right: -680px;
        text-align:center;
        border: 1px solid rgb(224, 137, 20);
        border-radius: 5px;
        background-color: rgb(224, 137, 20);
        color: white;
      }
      .chat_btn:hover{
        background-color: rgb(221, 181, 13);
        border: 1px solid rgb(221, 181, 13);
        cursor: pointer;
      }
      .floatingmenu{
        position: fixed;
        right: 50%;
        top: 180px;
        margin-right: -750px;
        text-align:center;
        width: 180px;
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        background-color: rgb(224, 137, 20);
        padding: 10px;
      }
      #recent{
        cursor: pointer;
        border: 1px solid rgb(224, 137, 20);
        background-color: #fff;
        border-radius: 5px;
        padding: 5px;
      }
      #cookie_text{
        color: #fff;
      }
      #title{
        color: rgb(224, 137, 20);
      }
      .scrapclass{
        margin-top: -20px;
      }
      #scrapimg{
        width: 15px;
        display: inline-block;
      }
      /* 검색 부분 */
      #select{
        width: 100px;
        height: 35px;
        background-color: #fff;
        background: url('http://192.168.122.1/image/selectimg.jpeg') no-repeat 95% 50%;
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        appearance:none; /* 기본 스타일 없애기 */
	      -webkit-appearance:none;
	      -moz-appearance:none;
	      -o-appearance:none;
        cursor: pointer;
      }
      #textbox{
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        height: 35px;
      }

    </style>
  </head>

  <body>
    <div id ="header">
      <a href="http://192.168.122.1/main.php" style="text-decoration:none">
        <h1 id="subject">Cook It Yourself</h1>
      </a>

    </div><!-- header -->

    <div class="menubar">
      <ul>
        <li style="margin-left : 2%"><a href="http://192.168.122.1/main.php">홈</a></li>
        <li><a href="http://192.168.122.1/post/posts.php">레시피 목록</a></li>
        <li><a href="http://192.168.122.1/crawling/news.php">음식/맛집뉴스</a></li>

        <!-- 세션이 유지되고 있을 때, 즉 로그인이 되어 있을 때 뜨는 부분 -->
        <?php
          if(isset($_SESSION['ses_uemail'])){
        ?>
        <li style="margin-left : 35%"><a href="http://192.168.122.1/post/postrecipe.php">내 레시피 등록</a></li>
        <li><a href="#" id="current">내 정보</a>
          <ul>
            <li><a href="http://192.168.122.1/mypage/mypage.php">마이페이지</a></li>
            <li><a href="http://192.168.122.1/login/logout.php">로그아웃</a></li>
          </ul>
        </li>
        <!-- 세션이 유지 되지 않을 때, 즉 로그인이 되어 있지 않을 때 뜨는 부분 -->
        <?php }else{ ?>
          <li style="margin-left : 35%"><a href="JavaScript:button1_click();">내 레시피 등록</a></li>
          <!-- <button class="btn btn-default" type="button" onclick="button1_click();">내 레시피 등록하기</button> -->
            <script>
            function button1_click(){
              alert("먼저 로그인을 해주세요.");
              document.location.href='http://192.168.122.1/login/login.php';
            }

            </script>

          <li><a href="http://192.168.122.1/login/login.php">로그인</a></li>
          <!-- <button class="btn btn-default" type="button" onclick="location.href='http://192.168.122.1/login/login.php'">로그인</button> -->
        <?php } ?>
      </ul>
    </div>

    <div id = "nav">
      <form id="search-form" method = "GET" action="http://192.168.122.1/post/posts.php">
        <select name = "searchby" id="select">
          <option value="all">전체</option>
          <option value="reptitle">제목</option>
          <option value="repexplain">한줄설명</option>
          <option value="foodname">음식이름</option>
          <option value="cookname">작성자</option>
        </select>
        <input type="search" name="searching" id="textbox" placeholder="검색내용..." required>
        <input id="searching" type="submit" name="onclick" value = "검색">
          <!-- <button id="category" type="button">카테고리</button> -->
      </form>

    </div><!-- nav -->

    <!-- 채팅 버튼 -->
    <button class = "chat_btn" onclick="window.open('http://192.168.122.1:8080','CIY 채팅','width=550,height=850,location=no, status=no,scrollbars=yes');">채팅</button>

    <div class = "floatingmenu">
      <p id ="cookie_text">최근 본 레시피</p>
      <?php
      if(isset($_COOKIE['recent'])){
        $num = $_COOKIE['recent'];
        // echo $num;
        include('dbconnect.php');
        $sql = "SELECT * FROM posts where num = $num";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $content = $row['content'];
        //이미지 소스로 되어 있는 부분을 추출함
        $strforimg = strstr($content, "<img src=\"");
        // echo $strforimg;
        //이미지 소스의 마지막 부분의 정수를 확인함
        $strforimgend = strpos($strforimg, "\" title=");
        // echo $strforimgend;
        //이미지 소소의 첫 부분 중 9칸 이후와, 마지막 부분-8 칸을 하여 원하는 스트링을 얻음.
        $strimg = substr($strforimg, 9, $strforimgend-8);
        // echo $strimg;

        $title = $row['title'];
        $foodname = $row['foodname'];
        $cook = $row['uname'];
        $scraped = $row['scraped'];

        ?>
        <div id = "recent" onclick="location.href='http://192.168.122.1/post/postdetail.php?num=<?php echo $num;?>'">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
          <p id="title"><?php echo $title;?></p>
          <p id="shorttext">"<?php echo $foodname;?>"</p>
          <p id="cook">만든이 : <?php echo $cook;?></p>
          <div class="scrapclass">
            <img src="http://192.168.122.1/image/hearts.png" id="scrapimg">
            <p style="color:red; display:inline-block;"><?= $scraped?></p>
          </div>
        </div><!--n1-->
      <?php }?>
    </div> <!--floatmenu-->

 </body>
</html>
