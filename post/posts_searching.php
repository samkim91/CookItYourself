<?php
include('../head.php');
require('../dbconnect.php');
include('simple_html_dom.php');

$searching=$_GET["searching"];

  echo "검색어 : ".$searching . "<br>";
  $sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' ORDER BY num DESC";
  $result = mysqli_query($conn, $sql);
  $totalCount = mysqli_num_rows($result);   //총 데이터 수


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
$list = 2;  //페이지 당 데이터 수
$block = 3;   //하단에 몇 개의 페이지를 보일지 정하는 블록 당 페이지 수

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
        float: left;
      }
      .btn{
        text-decoration: none;
        background: rgb(224, 137, 20);
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
      .container{
        display: inline-block;
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

    </style>

  </head>
  <body>
    <div class="container">
      <?php
        $real_sql = "SELECT * FROM posts WHERE title LIKE '%$searching%' OR shorttext LIKE '%$searching%' OR foodname LIKE '%$searching%' ORDER BY num DESC LIMIT $s_point, $list";
        $real_result = mysqli_query($conn, $real_sql);

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
        $conn->close();
        ?>
        <div id="card">
          <div id="img_div">
            <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
          </div><!--img-->
          <div class="card-body">
            <h3 class="card-title"><?php echo $row['title'];?></h5>
            <p class="card-text"><?php echo $row['shorttext'];?></p>
            <a href="http://192.168.122.1/post/postdetail.php?num=<?php echo $row['num'];?>" class="btn">더보기</a>
          </div><!-- card-body -->
        </div><!-- card -->
      <?php }?>
    </div><!-- container -->
    <div class="center">
      <div class="pagination">
        <a href="<?php echo $PHP_SELF;?>?searching=<?php echo $searching;?>&onclick=검색&page=<?php echo 1;?>">처음</a>
        <a href="<?php echo $PHP_SELF;?>?searching=<?php echo $searching;?>&onclick=검색&page=<?php if($s_page-1 < 1){echo 1;}else{echo $s_page-1;}?>">이전</a>
        <!-- <a href="#" class="active">1</a> -->
        <?php
          for($p=$s_page; $p<=$e_page; $p++){?>
            <a <?php if($p==$_GET['page']){?>class="active"<?php }?> href="<?php echo $PHP_SELF;?>?searching=<?php echo $searching;?>&onclick=검색&page=<?php echo $p;?>"><?php echo $p;?></a>
        <?php
          }
        ?>
        <a href="<?php echo $PHP_SELF;?>?searching=<?php echo $searching;?>&onclick=검색&page=<?php if($e_page+1 > $pageNum){echo $pageNum;}else{echo $e_page+1;}?>">다음</a>
        <a href="<?php echo $PHP_SELF;?>?searching=<?php echo $searching;?>&onclick=검색&page=<?php echo $pageNum;?>">끝</a>
      </div><!--pagination-->
    </div><!--center-->

  </body>
</html>
