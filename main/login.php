<?php
error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE);

include ('../conn/conn.php');
function clean($data) 
{
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
}

$uname=$pass="";
$error=array();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(!empty($_POST['username']))
  {
    $uname = clean($_POST['username']);
  }
  if(!empty($_POST['password']))
  {
    $pass = clean($_POST['password']);
    $pass = md5($pass);
  }
  if(isset($_POST['login'])) 
  {
    $get_user   = "SELECT * FROM tbl_user where usr_nama='$uname' and usr_pswd='$pass'";
    //echo $get_user;
    $login    = mysqli_query($conn,$get_user);
    $cek    = mysqli_num_rows($login);
    while($row = mysqli_fetch_array($login,MYSQLI_ASSOC))
    {
      $role = $row['role_id'];
      $username = $row['usr_nama'];
      $userid = $row['usr_id'];
    }

    if($cek > 0)
    {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['status'] = "login";
      $_SESSION['role_id'] = $role;
      $_SESSION['usr_id'] = $userid;
      header("location:http://localhost/SIP_GKP_BDG/index.php");
    }
    else if($cek < 1)
    {
      $msg = "Username/Password salah !";
    }
  }
}

if(isset($msg))
{
  ?>
  <div class="alert alert-danger" role="alert"><? echo $msg;?></div>
  <?
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GKP | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="shorcut icon" type="text/css" href="../assets/images/favicon.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../assets/plugins/iCheck/square/blue.css">
    <script src="../assets/plugins/jQuery/jquery-2.2.3.min.js'?>"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../assets/bootstrap/js/bootstrap.min.js'?>"></script>
    <!-- iCheck -->
    <script src="../assets/plugins/iCheck/icheck.min.js'?>"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- <p class="login-box-msg"> <img src="assets/images/mylogo.png"></p><hr/> -->
    <label style="text-align: center;"><h4><b>SISTEM INFORMASI PELAPORAN<br/>GKP JEMAAT BANDUNG</b></h4></label>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div> 
      <div class="form-control">
         <div class="col-xs-8">
          <div class="icheck-primary icheck-inline">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <div class="col-xs">
          <button type="submit" id="login" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
    <hr/>
    <p><center>Copyright <?php echo date('Y');?> by Bayu Kristiadhi Muliasetia <br/> All Right Reserved</center></p>
  </div>
</div>
</body>
</html>