<?php
  session_start();
  //필요한 헤더와 데이터 베이스 연결하는 php를 인클루드 리콰이어

  //넘겨받은 게시글 키값(아이디)를 선언함.
  $number=$_GET['num'];
  $loginuser = $_SESSION['ses_uemail'];

  // TODO: 쿠키 설정에서 가장 중요한 부분으로 생각됨!!! 어떠한 헤더보다 앞에 나와야한다!!!!
  //이게 개중요한 사실이다. 프로토콜 규약이라고 함!! 그래서 include, require 밑에 선언했다간 작동이 안됨.
  $cookie_name = "recent";
  $cookie_value = $number;
  if(isset($_COOKIE[$cookie_name])){
    // echo "쿠키 있네";
    setcookie($cookie_name, "", time()-3600, "/");
    // echo "삭제하자";
  }
  // echo "그리고 이거추가".$number;
  //쿠키를 설정하고 기간을 1시간 줬다. /는 모든 웹사이트에서 사용 가능하다는 의미
  setcookie($cookie_name, $cookie_value, time()+3600, "/");

  include('../head.php');
  require('../dbconnect.php');

  //디비에서 불러올 sql문을 만듦
  $sql = "SELECT * FROM posts WHERE num ='$number'";

  //쿼리 보냄
  $result = mysqli_query($conn, $sql);

  //쿼리 결과에 따라서 나뉘는 조건문
  if($result === false){
    echo "연결 실패: " . mysqli_error($conn);
  }else {
    // echo "연결 성공";

    //불러내온 값을 로우에 담고 출렦할 각종 변수들을 선언함.
    $row = mysqli_fetch_assoc($result);

    $uemail=$row['uemail'];
    $uname=$row['uname'];
    $title=$row['title'];
    $shorttext=$row['shorttext'];
    $foodname=$row['foodname'];
    $ingredients=$row['ingredient'];
    $scraped=$row['scraped'];

    //재료부분이 문자열을 합쳐서 입력되어 있기 때문에, 이를 잘라주는 구간이다. 먼저 +++를 기준으로 자르고, 그 다음에 ///기준으로 자른다.
    //잘린 문자열을 끝이 아니면 , 로 연결해주고 끝이면 더이상 추가되지 않도록 한다.
    $splitingredients = explode('+++', $ingredients);
    for($i=0 ; $i<sizeof($splitingredients) ; $i++){
      $each = explode('///', $splitingredients[$i]);

      if($i==sizeof($splitingredients)-1){
        $laststatus .= $each[0]." ".$each[1];
      }else{
        $laststatus .= $each[0]." ".$each[1].", ";
      }
    }

    $time=$row['time'];
    $content=$row['content'];

    //이미지 소스로 되어 있는 부분을 추출함
    $strforimg = strstr($content, "<img src=\"");
    //이미지 소스의 마지막 부분의 정수를 확인함
    $strforimgend = strpos($strforimg, "\" title=");
    //이미지 소소의 첫 부분 중 9칸 이후와, 마지막 부분-8 칸을 하여 원하는 스트링을 얻음.
    $strimg = substr($strforimg, 9, $strforimgend-8);

    // TODO 나중에 추가할 것들!!
    // $hashtag=$row['hashtag'];
    // $situation=$row['situation'];
    // $country=$row['country'];
    // $things=$row['things'];
    // $howto=$row['howto'];
  }
  // $conn->close();
 ?>


 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8"/>
   <script type="text/javascript" src="../smarteditor2/js/HuskyEZCreator.js" charset="utf-8">
   </script>

   <style>
     #div_post{
       width: 700px;
       margin: 0 auto;
       border: 3px solid rgb(224, 137, 20);
       border-radius: 5px;
       padding: 10px;
     }
     #scrap, #delete, #edit, #list, #submit {
       display: block;
       border: 1px solid;
       width : 70px;
       background-color: rgb(224, 137, 20);
       color: rgb(255, 255, 255);
       padding: 10px;
       border-radius: 5px;
     }
     #submit{
       display: inline;
       float: right;
     }
     #scrap:hover, #delete:hover, #edit:hover, #list:hover, #submit:hover{
       background-color: rgb(221, 181, 13);
       cursor: pointer;
     }
     .nse_content{
       width: 97%;
     }
     img{
       max-width: 100%;
     }
     .floatingbtn{
       margin-left: 853px;
       position: fixed;
       /* right: 32%; */
       /* right: 23.7%; */
       top: 195px;
       padding: 10px;
     }
     .show_reply{
       margin-top: 20px;
       border-top: 1px solid rgb(224, 137, 20);
     }
     #writer, #time{
       display: inline;
     }
     #writer{
       color: rgb(224, 137, 20);
     }
     #time{
       color: grey;
       margin-left: 30px;
       font-size: 0.8em;
     }
     #comment{
       margin-top: 0px;
       font-size: 0.8em;
     }
     #info, #delete_edit_btn{
       display: inline-block;
     }
     #delete_edit_btn{
       margin-top: 15px;
       float: right;
     }
     #delete_reply {
       display: inline-block;
       border: solid;
       background-color: rgb(224, 137, 20);
       color: rgb(255, 255, 255);
       border-radius: 100px;
       padding-left: 5px;
       padding-right: 5px;
       text-decoration: none;
     }
     #delete_reply:hover{
       background-color: rgb(221, 181, 13);
       cursor: pointer;
     }
     #editimg{
       display: inline-block;
       width: 15px;
       cursor: pointer;
       margin-right: 5px;
     }
     #scrap_div{
       text-align: center;
     }
     #scrapimg{
       width: 15px;
       display: inline-block;
     }

   </style>
 </head>

 <body>
   <div id="div_post">
     <h1><?php echo $title;?></h1>
        <div id = div_subject>
          <p>만든이 : <?php echo $uname;?></p>
       </div>
       <div id = div_explainline>
         <p>한줄 설명 : <?php echo $shorttext;?></p>
       </div>
       <div id = div_foodname>
         <p>음식이름 : <?php echo $foodname;?></p>
       </div>
      <div id = div_ingredient>
         <p>재료정보 : <?php echo $laststatus;?></p>
      </div>
       <div id = div_time>
         <p>조리시간 : <?php echo $time;?> 분</p>
      </div>
        <p>레시피</p>
        <p><?php echo $content;?></p>

      <div id = scrap_div>
        <p style="color:rgb(224, 137, 20); margin-bottom:0px;">스크랩</p>
        <img src="http://192.168.122.1/image/hearts.png" id="scrapimg">
        <p style="color:red; display:inline-block; margin-bottom:3px;"><?= $scraped?></p>
      </div>
      <div class="class_reply">
        <h2>댓글</h2>
        <?php
        //수정 버튼을 클릭하면 댓글 등록 부분이 댓글 수정으로 바뀌게 하는 부분
        if(isset($_GET['editreplynum'])){
          $reply_id = $_GET['editreplynum'];
          $sql_select_reply = "SELECT * FROM replys WHERE id = '$reply_id'";
          $result_select_reply = mysqli_query($conn, $sql_select_reply);
          $row_select_reply = mysqli_fetch_assoc($result_select_reply);
          ?>
          <form method="POST">
            <textarea name="edited_comment" id="reply" cols="60" required rows="3" placeholder="댓글을 남겨주세요."><?= $row_select_reply['comment']?></textarea>
            <input type="submit" id="submit" name="submit" value="수정">
          </form>
        <?php }else{
        ?>
        <form method="POST">
          <textarea name="reply" id="reply" cols="60" required rows="3" placeholder="댓글을 남겨주세요."></textarea>
          <input type="submit" id="submit" name="submit" value="등록">
        </form>
        <?php } ?>
      </div>

      <?php
      //댓글을 등록/수정하는 부분! sql문을 만들어서 쿼리를 보냄! 댓글 넘버(키)와 작성시간은 DBMS가 저장해줌.
      // 일단 포스트로 값을 받아오고, 포스트 셋의 여부를 검사해서 구문을 실행한다.

      if (isset($_POST['submit'])) {
        // 안에 들어가서, 이게 수정으로 이루어지고 있는 것인지, 그냥 등록으로 이루어지고 있는 것인지 검사하는 조건문이 하나 나오고 그 결과에 따라 다른 update, select 등을 실행한다.
        if (isset($_GET['editreplynum'])){
          //댓글을 수정하는 부분!! sql문을 만들어서 쿼리를 보냄!
          $edited_comment = $_POST['edited_comment'];
          $seleted_reply_num = $_GET['editreplynum'];
          $sql_update_reply = "UPDATE replys set comment = '$edited_comment' WHERE id = '$seleted_reply_num' LIMIT 1";
          $result_update_reply = mysqli_query($conn, $sql_update_reply);
          echo "<script>alert(\"댓글이 수정되었습니다.\"); document.location.href='http://192.168.122.1/post/postdetail.php?num=$number'; </script>";
        }else{
          //댓글을 등록하는 부분!! sql문을 만들어서 쿼리를 보냄!
          $comment = $_POST['reply'];
          $sql_reply = "INSERT INTO replys (postnum, uemail, comment) values ('$number', '$loginuser', '$comment')";
          $result_reply = mysqli_query($conn, $sql_reply);
        }

      }

      //댓글을 불러오기 위한 sql문을 만든다. 불러와서 열 값만큼 반복문을 실행하여 댓글을 출력해낸다.
      $sql_load_reply = "SELECT * FROM replys WHERE postnum = '$number'";
      $result_load_reply = mysqli_query($conn, $sql_load_reply);
      $countreplys = mysqli_num_rows($result_load_reply);
      while ($row = mysqli_fetch_assoc($result_load_reply)) {

        //댓글을 작성한 사람을 이메일로 등록했기 때문에, 닉네임을 구해와야함..
        $uemail_for_uname = $row['uemail'];
        $sql_for_uname = "SELECT * FROM userlist WHERE uemail = '$uemail_for_uname'";
        $result_for_uname = mysqli_query($conn, $sql_for_uname);
        $row_for_uname = mysqli_fetch_assoc($result_for_uname);
        ?>

        <!-- 하나의 댓글을 보여주는 곳 -->
      <div class="show_reply">
        <div id="img_sector">
        </div>
        <div id="info">
            <p id="writer"><?=$row_for_uname['uname'];?></p>
            <p id="time"><?=$row['time'];?></p>
            <p id="comment"><?=$row['comment'];?></p>
        </div>
        <?php
        if($loginuser==$row['uemail']){?>
        <!-- 삭제 수정 버튼을 모아둔 디비전 -->
        <div id="delete_edit_btn">
          <a href="http://192.168.122.1/post/postdetail.php?num=<?= $number;?>&editreplynum=<?= $row['id']?>"><img src="http://192.168.122.1/image/imgedit.png" id="editimg"></a>
          <a href="http://192.168.122.1/post/postdetail.php?num=<?= $number;?>&deletereplynum=<?= $row['id']?>" id="delete_reply">x</a>
        </div>
        <?php
        //로그인 유저와 댓글 작성자가 같을 때 버튼이 보이게하는 구문을 닫음
        }?>
      </div>
      <?php
       //댓굴을 모두 뿌릴 수 있게 해주는 반복문을 닫음
      }?>

      <?php
      //댓글의 삭제 버튼을 눌렀을 때 실행되는 부분
      if(isset($_GET['deletereplynum'])){
        $id = $_GET['deletereplynum'];
        // echo "눌러졌!".$id;
        $sql = "DELETE FROM replys WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        echo "<script>alert(\"댓글이 삭제되었습니다.\"); document.location.href='http://192.168.122.1/post/postdetail.php?num=$number'; </script>";
      }
        ?>

   </div><!-- div_post-->
   <!-- 버튼에 관한 선언들이 나오는 부분 -->
   <div class="floatingbtn">
     <?php
     //작성자가 로그인 유저와 일치하지 않을 때에만 스크랩 가능하도록 함.
     if($loginuser!=null&&$loginuser!=$uemail){
       $sql_select_scrap = "SELECT * FROM scrap WHERE postnum = '$number' AND uemail = '$loginuser'";
       $result_select_scrap = mysqli_query($conn, $sql_select_scrap);
       $row_select_scrap = mysqli_num_rows($result_select_scrap);
       // echo "<script>alert(\"이 게시물을 스크랩 하였습니다.$row_select_scrap\"); </script>";
       if($row_select_scrap==0){?>
         <form method="POST">
         <input type="submit" id="scrap" name="scrap" value="스크랩">
         </form>
     <?php }else{ ?>
       <form method="POST">
       <input type="submit" id="scrap" name="cancelscrap" value="스크랩
취소">
       </form>
     <?php }?>
       <?php
       //스크랩을 눌렀을 때 데이터베이스에 접근해서 추가하는 기능
       if(isset($_POST['scrap'])){
       $sql_insert_scrap = "INSERT INTO scrap (postnum, uemail) values ('$number', '$loginuser')";
       $result_insert_scrap = mysqli_query($conn, $sql_insert_scrap);

         if($result_insert_scrap){
           $sql_update_scrap = "UPDATE posts SET scraped = scraped+1 WHERE num = '$number'";
           $result_update_scrap = mysqli_query($conn, $sql_update_scrap);
           echo "<script>alert(\"이 게시물을 스크랩 하였습니다.\"); location.href='http://192.168.122.1/post/postdetail.php?num=$number'</script>";
         }
       }
       if(isset($_POST['cancelscrap'])){
         $sql_delete_scrap = "DELETE FROM scrap WHERE postnum ='$number' AND uemail = '$loginuser' LIMIT 1";
         $result_delete_scrap = mysqli_query($conn, $sql_delete_scrap);
         if($result_delete_scrap){
           $sql_update_scrap = "UPDATE posts SET scraped = scraped-1 WHERE num = '$number'";
           $result_update_scrap = mysqli_query($conn, $sql_update_scrap);
           echo "<script>alert(\"이 게시물을 스크랩 취소하였습니다.\"); location.href='http://192.168.122.1/post/postdetail.php?num=$number'</script>";
         }
       }
       ?>
     <?php }?>
     <?php
     //작성자가 로그인한 유저일 경우에 삭제,수정 기능이 보이도록 하는 부분
     if($_SESSION['ses_uemail']==$uemail){ ?>
       <form method="POST" style="display:inline!important;">
       <input type="submit" id="delete" name="delete" value="삭제">
       </form>
       <?php
       //삭제를 눌렀을 때 실행되는 php 기능 부분
       if(isset($_POST['delete'])){
         //댓글을 삭제하기 위한 sql문
         $sql_delete_reply = "DELETE FROM replys WHERE postnum = $number";
         $result_delete_reply = mysqli_query($conn, $sql_delete_reply);

         //게시물을 삭제하기 위한 sql문
         $sql = "DELETE FROM posts WHERE num = $number";
         $result = mysqli_query($conn, $sql);

         if($result){
           echo "<script>alert(\"삭제되었습니다.\"); history.go(-2); </script>";
         }else{
           echo "ERROR : ".mysqli_error($conn);
         }
         $conn->close();
       } ?>

       <button id="edit" name="edit" onclick="location.href='http://192.168.122.1/post/editpost.php?num=<?php echo $number;?>'">수정</button>
       <!-- <form method="GET" action="http://192.168.122.1/post/editpost.php?num=<?php echo $number;?>"> -->
       <!-- <input type="submit" id="edit" name="edit" value="수정"> -->
       <!-- </form> -->
     <?php }//작성자가 로그인한 유저와 같을 때 삭제,수정 기능 보이게 하는 부분의 끝?>

     <button id="list" onclick="location.href='http://192.168.122.1/post/posts.php'">목록</button>
     <!-- <script>
     //리스트로 돌아가는 기능을 가진 함수 선언
     function click_list(){
       history.back();
     }
     </script> -->

     <!-- 자바스크립으로 카카오톡 공유 기능을 넣기 위한 부분 -->
     <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

     <!-- 공유창을 띄워줄 버튼을 만들어준다. -->
     <a href="javascript:;" id="kakao-link-btn">
       <!-- 링크에 이미지를 씌우는데 기본적인 카카오톡 이미지를 넣었다. -->
       <img src="//developers.kakao.com/assets/img/about/logos/kakaolink/kakaolink_btn_small.png" width="40px" />
     </a>

     <script type="text/javascript">
     //<![CDATA[
     // //사용할 앱의 JavaScript API 키를 설정
     Kakao.init('a7b777fc35b0885e81857e0d1f2256fd');
     // //카카오링크 버튼을 생성. 처음 한번만 호출하면 됨. kakao.link는 피드를 보내기 위한 여러 함수를 가지고 있으며, 이중에 디폴트 버튼을 만든 것임.
     Kakao.Link.createDefaultButton({
       //컨테이너는 위에서 선언한 a태그와 연동되는 기능이라는 것을 의미
       container: '#kakao-link-btn',
       //공유할 때 어떤 식으로 보일 것이냐를 정할 수 있음. 피드형식으로 쓰려고 아래처럼 작성했고 이외에도, list, location, commerce, text 등이 있음.
       objectType: 'feed',
       //공유할 내용을 구성하는 부분
       content: {
         title: '<?= $title;?>',
         description: '<?= $shorttext;?>',
         imageUrl: '<?= $strimg;?>',
         link: {
           webUrl: window.location.href,
           mobileWebUrl: window.location.href
         }
       },
       //피드에 좋아요수나, 댓글수 등을 나타낼 수 있음. 최대 3개까지 가능하고 이외에도 sharedCount, viewCount, subscriberCount 등을 나타낼수 있음
       social: {
         likeCount: <?= $scraped;?>,
         commentCount: <?= $countreplys;?>
       },
       buttons: [
         {
           title: '더 보기',
           link: {
             webUrl: window.location.href,
             mobileWebUrl: window.location.href
           }
         }
       ]
     });

     //]]>
     </script>

   </div><!-- div_buttons-->
 </body>
</html>
