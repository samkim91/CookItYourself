<?php
  session_start();
  $result = session_destroy();

  if($result){
    ?>
    <script>
      alert("로그아웃 되었습니다.");
      location.href="http://192.168.122.1/main.php";
    </script>
  <?php
  }
 ?>
