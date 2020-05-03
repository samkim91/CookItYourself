<?php
  //필요한 것들을 인클루드 리콰이어 한다. 세션도 스타트 한다
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

    if($row != null){

      $uemail = $row['uemail'];
      $uname = $row['uname'];
      $upw = $row['upw'];
      // $image = $row['image'];    나중에 추가
    }else{
      echo "none";
    }
  }

?>

<!DOCTYPE html>
  <html>
    <head>
      <style>
        #profile{
          margin-top: 3%;
        }
        #img_sector{
          float: left;
          margin-left: 5%;
        }
        #info_sector{
          margin-left: 20%;
          /* float: left; */
        }
        #container {
    			width:96%;
          margin-top: 10%;
    			/* margin:0 auto; */

    		}
    		.tab {
    			list-style: none;
    			margin: 0;
    			padding: 0;
    			overflow: hidden;
    		}
    		/* Float the list items side by side */
    		.tab li {
    			float: left;
          background-color: rgb(221, 181, 13);
    		}
    		/* Style the links inside the list items */
    		.tab li a {
    			display: inline-block;
    			color: #fff;
    			text-decoration: none;
    			padding: 14px 16px;
    			font-size: 17px;
    			transition:0.3s;
    		}
    		/* Style the tab content */
    		.tabcontent {
    			display: none;
    			/* background-color:rgb(224, 137, 20); */
          border: 3px solid rgb(224, 137, 20);
          border-bottom-left-radius: 5px;
          border-bottom-right-radius: 5px;
    			padding: 6px 12px;
    			/* color:#fff; */
    		}
    		ul.tab li.current{
    			background-color: rgb(224, 137, 20);
    			color: #222;
    		}
    		.tabcontent.current {
    			display: block;
    		}
        #card{
          width: 28%;
          margin: 10px;
          border: 3px solid rgb(224, 137, 20);
          border-radius: 5px;
          padding: 10px;
          display: inline-block;
        }
        #edit {
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
        .btn{
          text-decoration: none;
          background: rgb(224, 137, 20);
          display: block;
          text-align: center;
          color: #fff;
          padding: 5px;
          border-radius: 5px;
        }
        .btn:hover{
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        #img_div{
          text-align: center;
          height: 180px;
        }
        .pagination {
          display: inline-block;
        }
        .pagination a {
          color: black;
          float: left;
          padding: 5px 10px;
          text-decoration: none;
          transition: background-color .3s;
          border-radius: 30px;
        }
        .pagination a.active {
          background-color: rgb(224, 137, 20);
          color: white;
          border-radius: 30px;
        }
        .pagination a:hover:not(.active) {background-color: rgb(221, 181, 13);}
        .center{text-align: center; margin-top: 20px;}
        .card-title{
          color: rgb(224, 137, 20);
        }
    	</style>
    	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>

    <body>
      <div id="profile">
        <!-- <div id="img_sector"> -->
          <!-- <img id="mimg" src="http://192.168.122.1/image/profile.png" alt="유저 이미지" style="align:middle ; margin : 10px ; width : 90%"> -->
        <!-- </div> -->
        <div id="info_sector">
          <h2><?php echo $uname;?></h2>
          <h4><?php echo $uemail;?></h2>
          <button id="edit" onclick="location.href='http://192.168.122.1/mypage/myprofile.php'">프로필 수정</button>
          <button id="edit" onclick="location.href='http://192.168.122.1/mypage/resign.php'">회원탈퇴</button>
        </div><!--info_sector-->

      </div><!--proifle-->

      <!-- 탭 기능을 구현한 부분,, 컨테이너 속에 탭이 들어가 있음. -->
      <div id="container">
        <ul class="tab">
          <li class="current" data-tab="tab1"><a href="#">나의 레시피</a></li>
          <li data-tab="tab2"><a href="#">스크랩</a></li>
        </ul>

        <!-- 초기탭 -->
        <div id="tab1" class="tabcontent current">
          <?php
          //페이지네이션을 위해 이 유저가 가지고 있는 총 게시물 수를 구한다.
          $sql_cnt = "SELECT * FROM posts WHERE uemail = '$thisuser' ORDER BY num DESC";
          $result_cnt = mysqli_query($conn, $sql_cnt);
          $totalCount = mysqli_num_rows($result_cnt);   //총 데이터 수

          $page = ($_GET['page'])?$_GET['page']:1;
          $list = 6;  //페이지 당 데이터 수
          $block = 5;   //하단에 몇 개의 페이지를 보일지 정하는 블록 당 페이지 수

          $pageNum = ceil($totalCount/$list); // 총 게시글에서 페이지당 데이터를 나눈 총 페이지 수
          $blockNum = ceil($pageNum/$block);   //총 몇 개의 블록이 필요한지를 선언함.
          $nowBlock = ceil($page/$block);   //현재 블럭

          //s_page는 시작 페이지, e_page는 끝 페이지다. 여기서 하는 것은 시작페이지와 종료페이지에
          //맞게 블록을 설정하기 위해서 하는 것이다.
          $s_page = ($nowBlock * $block) - ($block -1);
          if($s_page <= 1){
            $s_page = 1;
          }
          $e_page = $nowBlock * $block;
          if($pageNum <= $e_page){
            $e_page = $pageNum;
          }
          $s_point = ($page -1) * $list;
          //이후 페이지네이션 번호가 나오는 부분은 아래 html 코드 중간에 넣을 것이다.

          $sql_real = "SELECT * FROM posts WHERE uemail = '$thisuser' ORDER BY num DESC LIMIT $s_point, $list";
          $result_real = mysqli_query($conn, $sql_real);

          while($row = mysqli_fetch_assoc($result_real)){
            //방법이 없어서 어쩔 수 없이 컨텐트에서 받아온 값을 분할하여 스트링에 저장하는 방식을 택함...
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
            ?>
            <div id="card">
              <div id="img_div">
                <img src=<?php echo $strimg;?> alt="등록된 이미지가 없습니다." style="width:90%"/>
              </div>
              <div class="card-body">
                <h3 class="card-title"><?php echo $row['title'];?></h5>
                <p class="card-text">"<?php echo $row['shorttext'];?>"</p>

                <a href="http://192.168.122.1/post/postdetail.php?num=<?php echo $row['num'];?>" class="btn">더보기</a>
              </div><!-- card-body -->
            </div><!-- card -->
          <?php }?>
          <div class="center">
            <div class="pagination">
              <!-- 실제로 보여지는 페이지네이션 숫자들.. 처음/끝/이전/다음 의 버튼에는 href를 달아서 본인 주소를 참고하고, 조건문으로 검색일 경우 그 키워드를 가져오고, 아닐 경우 바로 누른 페이지로 이동하게끔 해놓음 -->
              <a href="<?php echo $PHP_SELF;?>?<?php if($searching!=null){?>searching=<?php echo $searching;?>&onclick=검색&<?php }?>page=<?php echo 1;?>">처음</a>
              <a href="<?php echo $PHP_SELF;?>?<?php if($searching!=null){?>searching=<?php echo $searching;?>&onclick=검색&<?php }?>page=<?php if($s_page-1 < 1){echo 1;}else{echo $s_page-1;}?>">이전</a>
              <!-- <a href="#" class="active">1</a> -->
              <?php
              //페이지(숫자)를 시작페이지부터 끝페이지까지 버튼을 생성할 수 있도록 하는 반복문이며, 버튼은 현재 페이지일 경우 액티브효과를 주고, 자기 주소를 참조하면서 검색일 경우 키워드를 포함, 검색이 아니면 그냥 바로 페이지를 전시
                for($p=$s_page; $p<=$e_page; $p++){?>
                  <a <?php if($p==$page){?>class="active"<?php }?> href="<?php echo $PHP_SELF;?>?<?php if($searching!=null){?>searching=<?php echo $searching;?>&onclick=검색&<?php }?>page=<?php echo $p;?>"><?php echo $p;?></a>
              <?php
                }
              ?>
              <a href="<?php echo $PHP_SELF;?>?<?php if($searching!=null){?>searching=<?php echo $searching;?>&onclick=검색&<?php }?>page=<?php if($e_page+1 > $pageNum){echo $pageNum;}else{echo $e_page+1;}?>">다음</a>
              <a href="<?php echo $PHP_SELF;?>?<?php if($searching!=null){?>searching=<?php echo $searching;?>&onclick=검색&<?php }?>page=<?php echo $pageNum;?>">끝</a>
            </div><!--pagination-->
          </div><!--center-->
        </div><!--tab1-->

        <div id="tab2" class="tabcontent">
          <?php
          //데이터를 가져오는 부분
          $sql_count = "SELECT * FROM scrap WHERE uemail = '$thisuser' ORDER BY scrapnum DESC";
          $result_count = mysqli_query($conn, $sql_count);

          while($row = mysqli_fetch_assoc($result_count)){
            $postnum = $row['postnum'];

            $sql_real = "SELECT * FROM posts WHERE num = '$postnum'";
            $result_real = mysqli_query($conn, $sql_real);
            $row = mysqli_fetch_assoc($result_real);
            //방법이 없어서 어쩔 수 없이 컨텐트에서 받아온 값을 분할하여 스트링에 저장하는 방식을 택함...
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
            ?>
            <div id="card">
              <div id="img_div">
                <img src=<?php echo $strimg;?> alt="등록된 이미지가 없습니다." style="width:90%"/>
              </div>
              <div class="card-body">
                <h3 class="card-title"><?php echo $row['title'];?></h5>
                <p class="card-text">"<?php echo $row['shorttext'];?>"</p>
                <p class="card-cook">만든이 : <?php echo $row['uname'];?></p>
                <a href="http://192.168.122.1/post/postdetail.php?num=<?php echo $row['num'];?>" class="btn">더보기</a>
              </div><!-- card-body -->
            </div><!-- card -->
          <?php }?>
        </div><!--tab2-->
      </div><!--container-->

      <script>
      // 탭에 클릭 기능을 통해, 없어지고 보여지는 것을 구현한 구문
        $(function() {
          $('ul.tab li').click(function() {
            var activeTab = $(this).attr('data-tab');
            $('ul.tab li').removeClass('current');
            $('.tabcontent').removeClass('current');
            $(this).addClass('current');
            $('#' + activeTab).addClass('current');
          })
        });
      </script>

    </body>
  </html>
