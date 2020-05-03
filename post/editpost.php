<?php
include('../head.php');
require('../dbconnect.php');

//넘겨받은 게시글 키값(아이디)를 선언함.
$number=$_GET['num'];

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
  $splitingredients = explode('+++', $ingredients);
  // echo $splitingredients;

  // for($i=0 ; $i<sizeof($splitingredients) ; $i++){
  //
  //
  // }

  $time=$row['time'];
  $content=$row['content'];
  // TODO 나중에 추가할 것들!!
  // $hashtag=$row['hashtag'];
  // $situation=$row['situation'];
  // $country=$row['country'];
  // $things=$row['things'];
  // $howto=$row['howto'];


} ?>


<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8"/>
      <script type="text/javascript" src="../smarteditor2/js/HuskyEZCreator.js" charset="utf-8">
      </script>
      <script>

      // 재료정보에 대한 초기값을 만드는데 실패한 구문이다... 성공한 구문은 아래 html 재료부분에 있음.
      // function ini_div(){
      //   var test = "<?= $each[0];?>";
      //
      //   for(var i = 0 ; i< <?= sizeof($splitingredients)?> ; i++){
      //     alert(test);
      //     var div = document.createElement('div');
      //     div.innerHTML = document.getElementById('adding_ingredient').innerHTML;
      //     document.getElementById('field').appendChild(div);
      //   }
      // }

      //재료항목을 동적으로 추가하는 부분. 추가하는 부분을 클래스명으로 가져와서 디브를 만들고, 그 밑으로 추가해준다.
      function add_div(){
        var div = document.createElement('div');
        div.innerHTML = document.getElementById('adding_ingredient1').innerHTML;
        document.getElementById('div_ingredient').appendChild(div);
      }
      //추가한 재료항목을 삭제하는 부분.
      function remove_div(obj){
        document.getElementById('div_ingredient').removeChild(obj.parentNode);
      }
      </script>
      <style>
        #div_post{
          width: 70%;
          margin: 0 auto;
          border: 3px solid rgb(224, 137, 20);
          border-radius: 5px;
          padding: 10px;
        }

        #edit, #back {
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 10px;
          border-radius: 5px;
        }
        #edit{
          margin-left: 78%;
        }
        #edit:hover, #back:hover{
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        .nse_content{
          width: 97%;
          height: 400px;
        }
        #addbtn, #delbtn{
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 5px;
          border-radius: 5px;
        }
        #addbtn:hover, #delbtn:hover{
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }


      </style>
    </head>

    <body>
      <div id="div_post">
        <h1>레시피 수정하기</h1>
        <form name="post_form" method="POST" style="display:inline!important;">
        <!-- <form name="post_form" method="POST" action="posttest.php"> -->
            <div id = div_subject>
                <p>제목</p>
                <input type="text" name="subject" size="35px" placeholder="레시피의 제목을 입력해주세요." required value="<?php echo $title;?>">
            </div>
            <div id = div_explainline>
                <p>한줄 설명</p>
                <input type="text" name="explainline" size="35px" placeholder="레시피를 소개하는 한줄 설명을 입력해주세요." required value="<?php echo $shorttext;?>">
            </div>
            <div id = div_foodname>
                <p>음식이름</p>
                <input type="text" name="foodname" size="35px" placeholder="음식 이름을 입력하세요" required value="<?php echo $foodname;?>">
            </div>
            <?php $ingredient = array(); $amount = array(); ?>
            <div id = div_ingredient>
                <p>재료정보</p>
                <?php
                $fromdb = true;
                for($i=0 ; $i<sizeof($splitingredients) ; $i++){
                  $each = explode('///', $splitingredients[$i]);
                  //이부분은 디비에서 가져온 값을 나눠서 다시 뿌려주는 역할을 한다. 재료 갯수만큼 반복문을 돌려서 초기값을 설정해줌.
                  ?>
                <div id = adding_ingredient>
                  <input type="text" id="ingre" name="ingredient[]" placeholder="재료이름" required value="<?= $each[0];?>">
                  <input type="text" id="amt" name="amount[]" size="10px" placeholder="분량" required value="<?= $each[1];?>">
                  <input id="delbtn" type="button" value="삭제" onclick="remove_div(this)">
                </div><!--adding_ingredient-->
              <?php } ?>
                <!-- <div id="field"></div> -->
                <div id = adding_ingredient1>
                  <input type="text" id="ingre" name="ingredient[]" placeholder="재료이름" required>
                  <input type="text" id="amt" name="amount[]" size="10px" placeholder="분량" required>
                  <input id="delbtn" type="button" value="삭제" onclick="remove_div(this)">
                </div><!--adding_ingredient-->
            </div><!--div ingredient-->
            <input id="addbtn" name="addButton" type="button" onClick="add_div()" value="추가">
            <div id = div_time>
                <p>조리시간</p>
                <input type="text" name="time" size="35px" placeholder="총 조리시간" required value="<?php echo $time;?>"><p style="display:inline"> 분</p>
            </div>

              <p>레시피</p>
              <textarea name="ir1" id="ir1" class="nse_content" required><?php echo $content;?></textarea>
                <script type="text/javascript">
                  var oEditors = [];
                    nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors,
                    elPlaceHolder: "ir1",
                    sSkinURI: "../smarteditor2/SmartEditor2Skin.html",
                    fCreator: "createSEditor2"
                  });
                  function submitContents(elClickedObj) {
                    // 에디터의 내용이 textarea에 적용됩니다.
                    oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
                    // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

                    try {
                      elClickedObj.form.submit();
                    } catch(e) {}
                  }
                  </script>
              <input id="edit" name="edit" type="submit" value="수정완료" onclick="submitContents(this)" />
        </form>
        <button id="back" onclick="click_list();">뒤로</button>
        <script>
        //리스트로 돌아가는 기능을 가진 함수 선언
        function click_list(){
          history.back();
        }
        </script>

        <?php
        if(isset($_POST['edit'])){
          $subject=$_POST['subject'];
          $explainline=$_POST['explainline'];
          $foodname=$_POST['foodname'];

          //포스트로 받아온 재료의 정보를 모두 불러내어서 데이터베이스에 저장하기 위해 하나의 변수로 합쳐주는 것이다.
          for($i=0 ; $i<sizeof($_POST['ingredient']) ; $i++){
            $ingredient = $_POST['ingredient'][$i];
            $amount = $_POST['amount'][$i];


            if($i==sizeof($_POST['ingredient'])-1){
              $totalingredient .= $ingredient."///".$amount;
            }else{
              $totalingredient .= $ingredient."///".$amount."+++";
            }
          }

          $time=$_POST['time'];
          $content=$_POST['ir1'];

          $sql = "UPDATE posts SET title = '$subject', shorttext = '$explainline', foodname ='$foodname',
          ingredient='$totalingredient', time='$time', content='$content' WHERE num = '$number' LIMIT 1";

          $result = mysqli_query($conn, $sql);

          if($result){
            echo "<script>alert(\"수정이 완료되었습니다.\"); document.location.href='http://192.168.122.1/post/postdetail.php?num=$number'; </script>";
          }else{
            echo "수정 실패: " . mysqli_error($conn);
          }
          $conn->close();
        }
         ?>

      </div>
    </body>
  </html>
