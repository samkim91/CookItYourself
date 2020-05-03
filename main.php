<?php
include('head.php');
require('dbconnect.php');

?>

<!DOCTYPE html>
<html>
  <head>

  <style>
  body{
    width: 1000px;
    margin : 0 auto;
  }
  #images{
    display : block;
    margin : 10px;
  }
  #section {
    text-align : center;
  }

  .title-div{
    background: rgb(224, 137, 20);
    padding: 3px;
    margin-top: 100px;
    /* border-radius: 5px; */
    color: #fff;
  }

  #card{
    width: 28%;
    margin: 10px;
    border: 3px solid rgb(224, 137, 20);
    border-radius: 5px;
    padding: 10px;
    display: inline-block;
  }
  .btn{
    text-decoration: none;
    background: rgb(224, 137, 20);
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    display: block;
    text-align: center;
  }
  .btn:hover{
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


  /* 슬라이드 보여주는 css */

  .mySlides {display: none}
  .mySlidesfamous {display: none}

  /* Slideshow container */
  .slideshow-container, .slideshow-containerfamous {
    max-width: 1000px;
    position: relative;
    margin: auto;
  }

  /* Next & previous buttons */
  .prev, .next, .prevfamous, .nextfamous {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    background-color: rgba(212, 212, 212, 0.8);
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
  }

  /* Position the "next button" to the right */
  .next, .nextfamous {
    right: 0;
    border-radius: 3px 0 0 3px;
  }

  /* On hover, add a black background color with a little bit see-through */
  .prev:hover, .next:hover, .prevfamous:hover, .nextfamous:hover {
    background-color: rgba(0,0,0,0.8);
  }

  /* The dots/bullets/indicators */
  .dot, .dotfamous {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
  }

  .active, .dot:hover, .dotfamous:hover {
    background-color: #717171;
  }

  /* Fading animation */
  .fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
  }

  @-webkit-keyframes fade {
    from {opacity: .4}
    to {opacity: 1}
  }

  @keyframes fade {
    from {opacity: .4}
    to {opacity: 1}
  }

  /* On smaller screens, decrease text size */
  @media only screen and (max-width: 300px) {
    .prev, .next,.text {font-size: 11px}
  }

  </style>

  </head>

<body>
  <div id="images">
    <img src="http://192.168.122.1/image/food1.JPG" alt="내가하는 요리1" style="float:left ; margin : 5px ; width :32% ; margin-top : 50px">
    <img src="http://192.168.122.1/image/food2.jpg" alt="내가하는 요리2" style="float:left ; margin : 5px ; width :32% ; margin-top : 100px">
    <img src="http://192.168.122.1/image/food3.jpg" alt="내가하는 요리3" style="float:left ; margin : 5px ; width :32% ; margin-bottom : 30px">
  </div><!--images-->

  <div id = "section">
    <h2>너도 나도 손쉽게 만들 수 있는 실용적인 레시피!</h2>
  </div><!-- section -->

  <h3 class="title-div">인기 레시피</h3>

  <div class="slideshow-containerfamous">
    <div class="mySlidesfamous fade">
      <?php
      //첫번째 슬라이드로 1에서 3번째 포스트를 가져옴.
      $famous_sql = "SELECT * FROM posts ORDER BY scraped DESC LIMIT 0, 3";
      $famous_result = mysqli_query($conn, $famous_sql);

      while($row = mysqli_fetch_assoc($famous_result)){
        //컨텐츠에서 사진을 가져오는 부분
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
  </div><!--mySlides fade-->

    <div class="mySlidesfamous fade">
      <?php
      //두번째 슬라이드로 4에서 6번째 포스트를 가져옴.
      $famous_sql = "SELECT * FROM posts ORDER BY scraped DESC LIMIT 3, 3";
      $famous_result = mysqli_query($conn, $famous_sql);

      while($row = mysqli_fetch_assoc($famous_result)){
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
    </div><!--mySlides fade-->

    <div class="mySlidesfamous fade">
      <?php
      //세번째 슬라이드로 7에서 9번째 포스트를 가져옴
      $famous_sql = "SELECT * FROM posts ORDER BY scraped DESC LIMIT 6, 3";
      $famous_result = mysqli_query($conn, $famous_sql);

      while($row = mysqli_fetch_assoc($famous_result)){
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
    </div><!--mySlides fade-->

    <a class="prevfamous" onclick="plusSlidesfamous(-1)">&#10094;</a>
    <a class="nextfamous" onclick="plusSlidesfamous(1)">&#10095;</a>

  </div><!--slideshow container-->
  <br>

  <div style="text-align:center">
    <span class="dotfamous" onclick="currentSlidefamous(1)"></span>
    <span class="dotfamous" onclick="currentSlidefamous(2)"></span>
    <span class="dotfamous" onclick="currentSlidefamous(3)"></span>
  </div>

  <script>
  var slideIndexfamous = 1;
  showSlidesfamous(slideIndexfamous);

  function plusSlidesfamous(n) {
  showSlidesfamous(slideIndexfamous += n);
  }

  function currentSlidefamous(n) {
  showSlidesfamous(slideIndexfamous = n);
  }

  function showSlidesfamous(n) {
  var i;
  var slides = document.getElementsByClassName("mySlidesfamous");
  var dots = document.getElementsByClassName("dotfamous");
  if (n > slides.length) {slideIndexfamous = 1}
  if (n < 1) {slideIndexfamous = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndexfamous-1].style.display = "block";
  dots[slideIndexfamous-1].className += " active";
  }
  </script>

  <h3 class="title-div">최근 레시피</h3>
  <div class="slideshow-container">
    <div class="mySlides fade">
      <?php
      //첫번째 슬라이드로 1에서 3번째 포스트를 가져옴.
      $real_sql = "SELECT * FROM posts ORDER BY num DESC LIMIT 0, 3";
      $real_result = mysqli_query($conn, $real_sql);

      while($row = mysqli_fetch_assoc($real_result)){
        //컨텐츠에서 사진을 가져오는 부분
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
  </div><!--mySlides fade-->

    <div class="mySlides fade">
      <?php
      //두번째 슬라이드로 4에서 6번째 포스트를 가져옴.
      $real_sql = "SELECT * FROM posts ORDER BY num DESC LIMIT 3, 3";
      $real_result = mysqli_query($conn, $real_sql);

      while($row = mysqli_fetch_assoc($real_result)){
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
    </div><!--mySlides fade-->

    <div class="mySlides fade">
      <?php
      //세번째 슬라이드로 7에서 9번째 포스트를 가져옴
      $real_sql = "SELECT * FROM posts ORDER BY num DESC LIMIT 6, 3";
      $real_result = mysqli_query($conn, $real_sql);

      while($row = mysqli_fetch_assoc($real_result)){
      $content = $row['content'];
      $strforimg = strstr($content, "<img src=\"");
      $strforimgend = strpos($strforimg, "\" title=");
      $strimg = substr($strforimg, 9, $strforimgend-8);
      ?>
      <div id="card">
        <div id="img_div">
          <img src=<?php echo $strimg;?> alt="음식사진1" style="width:90%"/>
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
    <?php }?>
    </div><!--mySlides fade-->

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

  </div><!--slideshow container-->
  <br>

  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>


  <script>
  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
  showSlides(slideIndex += n);
  }

  function currentSlide(n) {
  showSlides(slideIndex = n);
  }

  function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  }
  </script>




<?php $conn->close();?>
</body>

</html>
