<?php
include('../head.php');
//크롤링에 필요한 라이브러리를 포함시킴
include('simplehtmldom/simple_html_dom.php');

//네이버 뉴스 생활 파트 중에 맛집/음식 뉴스에 관련 링크를 가져옴
$html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=103&sid2=238');

//필요한 부분을 찾아서 news 변수에 담음
$news = $html->find("ul.type06_headline");

?>

<!DOCTYPE html>
  <html>
    <head>
      <style>
      ul li{
        display: inline-block;
      }
      ul li dl{
        margin-top: 15px;
      }
      li dl dt a{
        text-decoration: none;
        color: black;
        list-style: none;
        float: left;
      }
      li dl dt a:hover{
        color: rgb(224, 137, 20);
      }
      li dl dd span{
        color : grey;
        font-size: 0.9em;
      }
      li dl dd .lede, li dl dd .writing{
        display: inline-block;
        margin-top: 5px;
      }
      /* 주어진 공간을 초과하면 글자를 ... 처리해주는 부분*/
      li dl dd .lede{
        text-overflow: ellipsis;
        width: 90%;
        overflow: hidden;
        white-space: nowrap;
      }
      .photo{
        margin: 10px;
        margin-top: 0px;
        float: left;
      }
      .title-div{
        background: rgb(224, 137, 20);
        padding: 3px;
        margin-top: 30px;
        /* border-radius: 5px; */
        color: #fff;
      }
      .type06_headline{
        border: 3px solid rgb(224, 137, 20);
        border-radius: 5px;
        padding: 20px;
      }

      </style>
    </head>
    <body>

      <h3 class="title-div">음식/맛집 뉴스</h3>
      <?php
      //뉴스를 뿌려주는 곳
      foreach ($news as $show) {
        echo $show;
        echo "<br>";
      }
       ?>
    </body>
  </html>
