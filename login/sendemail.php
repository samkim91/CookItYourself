<?php

//서버세팅. 이메일 보내는 기능을 쓰기 위해 필요한 것들을 선언함.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./PHPMailer/src/PHPMailer.php";
require "./PHPMailer/src/SMTP.php";
require "./PHPMailer/src/Exception.php";

//데이터베이스 접근이 필요하기 때문에 선언해주고, 포스트로 받아온 값을 선언함.
require('../dbconnect.php');
$typedemail = $_POST['uemail'];

//먼저, 디비에서 같은 이메일이 있는지 확인해서 가입된 이메일인지, 아니면 없는 이메일인지 보여줌.

$sql = "SELECT * FROM userlist WHERE uemail='$typedemail'";
$result = mysqli_query($conn, $sql);

$exist = mysqli_num_rows($result);    //만약 result가 있다면 1을 반환(true)이고 없다면 0을 반환(false)한다.

if($exist){
  //가입된 이메일이 확인되었다면 임시 비밀번호를 생성하여 데이터베이스를 업데이트 하고 변경된 비밀번호를 메일로 보내주는 부분

  //8자리의 임시 비밀번호 생성
  function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
  $temppwd = generateRandomString(8);

  //데이터베이스에 있는 기존 비밀번호를 임시비밀번호로 바꾸는 작업.
  $sql_update_pw = "UPDATE userlist SET upw = '$temppwd' WHERE uemail = '$typedemail' LIMIT 1";
  $result_update_pw = mysqli_query($conn, $sql_update_pw);

  //실질적으로 메일을 보내는 부분!
  $mail = new PHPMailer(true);

  try {

  //디버깅 설정을 0 으로 하면 아무런 메시지가 출력되지 않는다.
  $mail -> SMTPDebug = 2; // 디버깅 설정
  $mail -> isSMTP(); // SMTP 사용 설정

  // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
  $mail -> Host = "smtp.naver.com";               // 네이버의 smtp 서버
  $mail -> SMTPAuth = true;                         // SMTP 인증을 사용함
  $mail -> Username = "kimh0000@naver.com";    // 메일 계정 (지메일일경우 지메일 계정)
  $mail -> Password = "525Aud616";                  // 메일 비밀번호
  $mail -> SMTPSecure = "ssl";                       // SSL을 사용함
  $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정

  $mail -> CharSet = "utf-8"; // 문자셋 인코딩

  // 보내는 메일
  $mail -> setFrom("kimh0000@naver.com", "CIY관리자");

  // 받는 메일
  $mail -> addAddress($typedemail, "고객님");

  // 메일 내용
  $mail -> isHTML(true); // HTML 태그 사용 여부
  $mail -> Subject = "Cook It Yourself에서 임시 비밀번호가 도착했습니다.";  // 메일 제목
  $mail -> Body = "임시비밀번호는 ".$temppwd." 입니다. 로그인하신 후에 비밀번호를 즉시 변경하는 것을 권장합니다.";     // 메일 내용

  // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
  // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
  $mail -> SMTPOptions = array(
    "ssl" => array(
    "verify_peer" => false
    , "verify_peer_name" => false
    , "allow_self_signed" => true
    )
  );

  // 메일 전송
  $mail -> send();

  echo "Message has been sent";
  echo "<script>alert(\"해당 이메일로 임시 비밀번호를 발송해드렸습니다.\");  history.back(); </script>";
  } catch (Exception $e) {
  echo "Message could not be sent. Mailer Error : ", $mail -> ErrorInfo;
  }
}else{
  echo "<script>alert(\"존재하지 않는 이메일입니다.\");  history.back(); </script>";
}

$conn->close();
?>
