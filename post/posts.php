<?php
include('../head.php');
require('../dbconnect.php');

$searching=$_GET["searching"];
$searchby=$_GET["searchby"];
$sorted=$_GET["sorted"];
$layout=$_GET["layout"];

//이 부분은 검색으로 이 페이지를 여는지, 그냥 기본 열리는건지 확인을 하는 조건문을 통해
//다른 결과를 보여주기 위한 부분이다. 안의 내용은 sql문을 날리고 결과를 받아온다는 것은 동일하다.
if($searching != null){
  // echo "범주 : " . $searchby;
  echo "  검색어 : ".$searching . "<br>";
  if($searchby == 'all'){
    $sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' OR uname LIKE '%$searching%' ORDER BY num DESC";
  }else if($searchby == 'reptitle'){
    $sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' ORDER BY num DESC";
  }else if($searchby == 'repexplain'){
    $sql = "SELECT * FROM posts WHERE shorttext LIKE '%$searching%' ORDER BY num DESC";
  }else if($searchby == 'foodname'){
    $sql = "SELECT * FROM posts WHERE foodname LIKE '%$searching%' ORDER BY num DESC";
  }else if($searchby == 'cookname'){
    $sql = "SELECT * FROM posts WHERE uname LIKE '%$searching%' ORDER BY num DESC";
  }
  $result = mysqli_query($conn, $sql);
  $totalCount = mysqli_num_rows($result);   //총 데이터 수
}else{
  $sql = "SELECT * FROM posts ORDER BY num DESC";
  $result = mysqli_query($conn, $sql);
  $totalCount = mysqli_num_rows($result);   //총 데이터 수
}

if($result === false ){
    echo "연결 실패: " . mysqli_error($conn);
}else{
    // echo "연결 성공";
    // $row = mysqli_fetch_assoc($result);
    // if($row == null){
    //     echo "<script>alert(\"게시물이 없습니다..\");  history.back(); </script>";
    // }else {

    // }
}

// if(isset($_GET['page'])){
//   $page = $_GET['page'];
// }else {
//   $page = 1;
// }

// $no_of_recodes_per_page = 10;
// $offset = ($pageno-1) * $no_of_recodes_per_page;

$page = ($_GET['page'])?$_GET['page']:1;
$list = 9;  //페이지 당 데이터 수
$block = 10;   //하단에 몇 개의 페이지를 보일지 정하는 블록 당 페이지 수

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

// $conn->close();
?>

<!doctype html>
<html lang="ko">
  <head>
    <style>
      #card{
        width: 28%;
        margin: 10px;
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        padding: 10px;
        display: inline-block;
      }
      .btn{
        display: block;
        text-align: center;
        text-decoration: none;
        background: rgb(224, 137, 20);
        color: #fff;
        padding: 5px;
        border-radius: 5px;
      }
      .btn:hover, .btn-group a:hover{
        background-color: rgb(221, 181, 13);
        cursor: pointer;
      }
      #card-title{
        color: rgb(224, 137, 20);
      }
      #img_div{
        text-align: center;
        height: 180px;
      }
      .container{
        display: inline-block;
        width: 100%;
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
      .btn-div{
        margin-top: 50px;
        margin-bottom: 20px;
        margin-right: 30px;
        float: right;
      }
      .btn-group{
        text-decoration: none;
        background-color: rgb(224, 137, 20);
        color: #fff;
        padding: 5px;
        border-radius: 5px;
      }
      .btn-group:hover{
        cursor: pointer;
        background-color: rgb(221, 181, 13);
      }
      .opt-group{
        margin-left: 10px;
        float: right;
        margin-top: -5px;
      }
      .opt-group img{
        width: 30px;
        cursor: pointer;
      }
      .listview{
        width: 95%;
        text-align: center;
        table-layout: fixed;
      }
      th{
        background-color: rgb(224, 137, 20);
        color: #fff;
        border-radius: 5px;
        height: 30px;
      }
      tbody tr{
        height: 50px;
      }
      tbody tr:hover{
        height: 60px;
        cursor: pointer;
        background-color: rgb(221, 181, 13);
        border-radius: 5px;
        transition: background-color .3s;
      }
      .card-text, .card-title, .card-cook {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
      }


    </style>

  </head>
  <body>
    <div class="btn-div">
      <a class="btn-group" href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?>sorted=recent&<?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>">최신순</a>
      <a class="btn-group" href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?>sorted=past&<?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>">과거순</a>
      <a class="btn-group" href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?>sorted=popular&<?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>">인기순</a>
      <a class="btn-group" href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?>sorted=unpopular&<?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>">비인기순</a>
      <div class="opt-group">
        <a href="<?=$PHP_SELF;?>?layout=grid&<?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>"><img src="http://192.168.122.1/image/grid.jpg" alt="그리드 보기"></a>
        <a href="<?=$PHP_SELF;?>?layout=list&<?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$page;?>"><img src="http://192.168.122.1/image/list.jpg" alt="리스트 보기"></a>
      </div>
    </div>


    <div class="container">
      <?php
      //검색기능으로 왔을 때, 각각의 검색 조건에 따라 쿼리문을 다르게 하는 부분이다. 또한 정렬기능을 사용했을 때 이 것도 포함시켜준다.
      if($searching!=null){
        if($searchby == 'all'){
          if($sorted == 'recent' || $sorted == null){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' OR uname LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
          }else if($sorted == 'past'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' OR uname LIKE '%$searching%' ORDER BY num ASC LIMIT $s_point, $list";
          }else if($sorted == 'popular'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' OR uname LIKE '%$searching%' ORDER BY scraped DESC LIMIT $s_point, $list";
          }else if($sorted == 'unpopular'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' OR uname LIKE '%$searching%' ORDER BY scraped ASC LIMIT $s_point, $list";
          }
        }else if($searchby == 'reptitle'){
          if($sorted == 'recent' || $sorted == null){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
          }else if($sorted == 'past'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' ORDER BY num ASC LIMIT $s_point, $list";
          }else if($sorted == 'popular'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' ORDER BY scraped DESC LIMIT $s_point, $list";
          }else if($sorted == 'unpopular'){
            $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' ORDER BY scraped ASC LIMIT $s_point, $list";
          }
        }else if($searchby == 'repexplain'){
          if($sorted == 'recent' || $sorted == null){
            $real_sql = "SELECT * FROM posts WHERE shorttext LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
          }else if($sorted == 'past'){
            $real_sql = "SELECT * FROM posts WHERE shorttext LIKE '%$searching%' ORDER BY num ASC LIMIT $s_point, $list";
          }else if($sorted == 'popular'){
            $real_sql = "SELECT * FROM posts WHERE shorttext LIKE '%$searching%' ORDER BY scraped DESC LIMIT $s_point, $list";
          }else if($sorted == 'unpopular'){
            $real_sql = "SELECT * FROM posts WHERE shorttext LIKE '%$searching%' ORDER BY scraped ASC LIMIT $s_point, $list";
          }
        }else if($searchby == 'foodname'){
          if($sorted == 'recent' || $sorted == null){
            $real_sql = "SELECT * FROM posts WHERE foodname LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
          }else if($sorted == 'past'){
            $real_sql = "SELECT * FROM posts WHERE foodname LIKE '%$searching%' ORDER BY num ASC LIMIT $s_point, $list";
          }else if($sorted == 'popular'){
            $real_sql = "SELECT * FROM posts WHERE foodname LIKE '%$searching%' ORDER BY scraped DESC LIMIT $s_point, $list";
          }else if($sorted == 'unpopular'){
            $real_sql = "SELECT * FROM posts WHERE foodname LIKE '%$searching%' ORDER BY scraped ASC LIMIT $s_point, $list";
          }
        }else if($searchby == 'cookname'){
          if($sorted == 'recent' || $sorted == null){
            $real_sql = "SELECT * FROM posts WHERE uname LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
          }else if($sorted == 'past'){
            $real_sql = "SELECT * FROM posts WHERE uname LIKE '%$searching%' ORDER BY num ASC LIMIT $s_point, $list";
          }else if($sorted == 'popular'){
            $real_sql = "SELECT * FROM posts WHERE uname LIKE '%$searching%' ORDER BY scraped DESC LIMIT $s_point, $list";
          }else if($sorted == 'unpopular'){
            $real_sql = "SELECT * FROM posts WHERE uname LIKE '%$searching%' ORDER BY scraped ASC LIMIT $s_point, $list";
          }
        }
        $real_result = mysqli_query($conn, $real_sql);
      }else{
        //이부분은 검색기능 없이 그냥 게시물목록을 열었을 때 실행되는 부분이다. 다만 필터 기능을 포함하려다보니 조건문이 많아졌다.
        if($sorted == 'recent' || $sorted == null){
          $real_sql = "SELECT * FROM posts ORDER BY num DESC LIMIT $s_point, $list";
        }else if($sorted == 'past'){
          $real_sql = "SELECT * FROM posts ORDER BY num ASC LIMIT $s_point, $list";
        }else if($sorted == 'popular'){
          $real_sql = "SELECT * FROM posts ORDER BY scraped DESC LIMIT $s_point, $list";
        }else if($sorted == 'unpopular'){
          $real_sql = "SELECT * FROM posts ORDER BY scraped ASC LIMIT $s_point, $list";
        }
        $real_result = mysqli_query($conn, $real_sql);
      }
      if($layout == 'list'){?>
        <!-- 레이아웃이 리스트 형태일 때 리스트를 뿌려주기 위한 부분 -->
        <table class="listview">
          <thead>
            <tr>
              <th width="150">제목</th>
              <th width="500">한줄설명</th>
              <th width="150">만든이</th>
              <th width="100">스크랩</th>
            </tr>
          </thead>
          <tbody>
      <?php
        while ($row = mysqli_fetch_assoc($real_result)) {
          ?>
            <tr onclick="location.href='http://192.168.122.1/post/postdetail.php?num=<?php echo $row['num'];?>'">
              <td><?=$row['title']?></td>
              <td><?=$row['shorttext']?></td>
              <td><?=$row['uname']?></td>
              <td style="color:red"><?=$row['scraped']?></td>
            </tr>
      <?php } ?>
        </tbody>
      </table>
      <?php
      }else if($layout == 'grid' || $layout == null){
        while($row = mysqli_fetch_assoc($real_result)){
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

        // 리절트에서 사진을 끌어오기 위한 html 돔이었으나, 실패!
        // $content = file_get_html($row['content']);
        // $content->find('img') as $element;
        // echo $element;
        // foreach ($content->find('img') as $element) {
        //   echo $element->src . '<br>';
        // }

        ?>
        <div id="card">
          <div id="img_div">
            <img src=<?php echo $strimg;?> alt="등록된 이미지가 없습니다." style="width:90%"/>
          </div><!--img-->
          <div class="card-body">
            <h3 id="card-title" class="card-title"><?php echo $row['title'];?></h5>
            <p id="card-text" class="card-text">"<?php echo $row['shorttext'];?>"</p>
            <p class="card-cook">만든이 : <?php echo $row['uname'];?></p>
            <div class="scrapclass">
              <img src="http://192.168.122.1/image/hearts.png" id="scrapimg">
              <p style="color:red; display:inline-block;"><?= $row['scraped']?></p>
            </div>
            <a href="http://192.168.122.1/post/postdetail.php?num=<?php echo $row['num'];?>" class="btn">더보기</a>
          </div><!-- card-body -->
        </div><!-- card -->
      <?php }}?>
    </div><!-- container -->
    <div class="center">
      <div class="pagination">
        <!-- 실제로 보여지는 페이지네이션 숫자들.. 처음/끝/이전/다음 의 버튼에는 href를 달아서 본인 주소를 참고하고, 조건문으로 검색일 경우 그 키워드를 가져오고, 아닐 경우 바로 누른 페이지로 이동하게끔 해놓음 -->
        <a href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?><?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?php echo 1;?>">처음</a>
        <a href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?><?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?php if($s_page-1 < 1){echo 1;}else{echo $s_page-1;}?>">이전</a>
        <!-- <a href="#" class="active">1</a> -->
        <?php
        //페이지(숫자)를 시작페이지부터 끝페이지까지 버튼을 생성할 수 있도록 하는 반복문이며, 버튼은 현재 페이지일 경우 액티브효과를 주고, 자기 주소를 참조하면서 검색일 경우 키워드를 포함, 검색이 아니면 그냥 바로 페이지를 전시
          for($p=$s_page; $p<=$e_page; $p++){?>
            <a <?php if($p==$page){?>class="active"<?php }?> href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?><?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$p;?>"><?=$p;?></a>
        <?php
          }
        ?>
        <a href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?><?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?php if($e_page+1 > $pageNum){echo $pageNum;}else{echo $e_page+1;}?>">다음</a>
        <a href="<?=$PHP_SELF;?>?<?php if($layout!=null){?>layout=<?=$layout;?>&<?php }?><?php if($sorted!=null){?>sorted=<?=$sorted;?>&<?php }?><?php if($searching!=null){?>searchby=<?=$searchby;?>&searching=<?=$searching;?>&onclick=검색&<?php }?>page=<?=$pageNum;?>">끝</a>
      </div><!--pagination-->
    </div><!--center-->
    <?php $conn->close();?>
  </body>
</html>
