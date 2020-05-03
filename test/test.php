<HTML>
<HEAD>
<TITLE> GET 방식 예제 </TITLE>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
</HEAD>

<BODY>
<!-- <FORM NAME="form1" ACTION="test.asp" METHOD="get">
이름 : <INPUT TYPE="test" NAME="uname">
<BR>
메일 : <INPUT TYPE="test" NAME="mail">
<BR>
<INPUT TYPE="submit" VALUE="전송">
<INPUT TYPE="reset" VALUE="다시"> -->
<!-- </FORM> -->


<label>비밀번호</label>
<input type="password" name="userPwd" id="pwd1" class="form-control" required /> <br>
<label>재확인</label>
<input type="password" name="reuserPwd" id="pwd2" class="form-control" required /> <br>
<div class="alert alert-success" id="alert-success">비밀번호가 일치합니다.</div>
<div class="alert alert-danger" id="alert-danger">비밀번호가 일치하지 않습니다.</div>​

<script type="text/javascript">
$(function(){
   $("#alert-success").hide();
   $("#alert-danger").hide();
   $("input").keyup(function(){
     var pwd1=$("#pwd1").val();
     var pwd2=$("#pwd2").val();
     if(pwd1 != "" || pwd2 != ""){
       if(pwd1 == pwd2){
         $("#alert-success").show();
         $("#alert-danger").hide();
         $("#submit").removeAttr("disabled");
       }else{
         $("#alert-success").hide();
         $("#alert-danger").show();
         $("#submit").attr("disabled", "disabled");
       }
     }
   });
 });
</script>​

</BODY>
</HTML>

<!-- <HTML>
<HEAD>
<TITLE> POST 방식 예제 </TITLE>
</HEAD>

<BODY>
<FORM NAME="form1" ACTION="test.asp" METHOD="post">
이름 : <INPUT TYPE="test" NAME="uname">
<BR>
메일 : <INPUT TYPE="test" NAME="mail">
<BR>
<INPUT TYPE="submit" VALUE="전송">
<INPUT TYPE="reset" VALUE="다시">
</FORM>

</BODY>
</HTML> -->
