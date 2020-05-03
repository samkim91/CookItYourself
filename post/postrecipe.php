<?php
include('../head.php');
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8"/>
      <script type="text/javascript" src="../smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
      <script>
      function add_div(){
        var div = document.createElement('div');
        div.innerHTML = document.getElementById('adding_ingredient').innerHTML;
        document.getElementById('field').appendChild(div);
      }
      function remove_div(obj){
        document.getElementById('field').removeChild(obj.parentNode);
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

        #submit {
          border: 1px solid;
          background-color: rgb(224, 137, 20);
          color: rgb(255, 255, 255);
          padding: 5px;
          border-radius: 5px;
          margin-left: 85%;
        }
        #submit:hover{
          background-color: rgb(221, 181, 13);
          cursor: pointer;
        }
        .nse_content{
          width: 680px;
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
        <h1>레시피 등록하기</h1>
        <form name="post_form" method="POST" action="http://192.168.122.1/post/postrecipe_insert.php">
        <!-- <form name="post_form" method="POST" action="posttest.ph"> -->
            <div id = div_subject>
                <p>제목</p>
                <input type="text" name="subject" size="35px" placeholder="레시피의 제목을 입력해주세요." required >
            </div>
            <div id = div_explainline>
                <p>한줄 설명</p>
                <input type="text" name="explainline" size="35px" placeholder="레시피를 소개하는 한줄 설명을 입력해주세요." required >
            </div>
            <div id = div_foodname>
                <p>음식이름</p>
                <input type="text" name="foodname" size="35px" placeholder="음식 이름을 입력하세요" required >
            </div>
            <?php $ingredient = array(); $amount = array(); ?>
            <div id = div_ingredient>
                <p>재료정보</p>
                <div id = adding_ingredient>
                  <input type="text" name="ingredient[]" placeholder="재료이름" required >
                  <input type="text" name="amount[]" size="10px" placeholder="분량" required >
                  <input id="delbtn" type="button" value="삭제" onclick="remove_div(this)">
                </div><!--adding_ingredient-->
                <div id="field"></div>
                <input id="addbtn" name="addButton" type="button" onClick="add_div()" value="추가">
            </div><!--div ingredient-->
            <div id = div_time>
                <p>조리시간</p>
                <input type="text" name="time" placeholder="총 조리시간" required ><p style="display:inline"> 분</p>
            </div>

              <p>내용</p>
              <textarea name="ir1" id="ir1" class="nse_content" required ></textarea>
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
              <input id="submit" type="submit" value="등록하기" onclick="submitContents(this)" />


        </form>
      </div>
    </body>
  </html>
