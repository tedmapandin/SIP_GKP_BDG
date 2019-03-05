<?php 
  session_start();

  error_reporting(E_ALL); 
  ini_set('display_errors', TRUE); 
  ini_set('display_startup_errors', TRUE); 

  include("../conn/conn.php");
  include('../control/functions.php');
  $title_pg='Jabatan';

  if($_SESSION['status'] !="login")
  {
    header("location:http://localhost/SIP_GKP_BDG/main/login.php");
  }

  $user = $_SESSION['username'];
  $usrid = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usrid'";
  //echo $get_user;
  $login    = mysqli_query($conn,$get_user);
  while($row = mysqli_fetch_array($login,MYSQLI_ASSOC))
  {
    $role = $row['role_id'];
  }
  // /echo $role;

  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    if(isset($_POST['saveJab']))
    {
      $jabNama = $_POST['jabNama'];
      $jabDesc = $_POST['jabDesc'];

      insertJab($jabNama,$jabDesc);
    }
  }

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
     if(isset($_POST['updJab']))
      {
        $jabId = $_POST['jabid'];
        $jabNamaEdt = $_POST['jabNamaEdt'];
        $jabDescEdt = $_POST['jabDescEdt'];
        updateJab($jabNamaEdt,$jabDescEdt,$jabId);
      }
  }

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
     if(isset($_POST['delJab']))
      {
        $jabId = $_POST['jabid'];
        deleteJab($jabId);
      }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GKP | <?php echo $title_pg;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="shorcut icon" type="text/css" href="../assets/images/favicon.png">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- jvectormap -->
  <link rel="stylesheet" href="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../assets/switch_btn.css">
  <link rel="stylesheet" href="../assets/plugins/datatables/jquery.datatables.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<form method="post" action="?">
<div class="wrapper">

  <!--Header-->
  <?php require_once("../main/header.php");?>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menu Utama</li>
        <li class="active">
          <a href="../index.php">
            <i class="fa fa-home"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        <?php if($role == '1') { ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i>
              <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="../main/divisi.php"><i class="fa fa-list"></i> Divisi </a></li>
              <li><a href="../main/bidang.php"><i class="fa fa-list"></i> Bidang</a></li>
              <li><a href="../main/jabatan.php"><i class="fa fa-list"></i> Jabatan</a></li>
              <li><a href="#"><i class="fa fa-list"></i> No. Akun</a></li>
              <li><a href="../main/user.php"><i class="fa fa-group"></i> User</a></li>
              <li><a href="../main/tahun.php"><i class="fa fa-calendar"></i> Tahun</a></li>
            </ul>
          </li>
        <?php } ?>
         <li>
          <a href="../main/transaksi.php">
            <i class="fa fa-sign-out"></i> <span>Transaksi</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-list"></i> Rekap Kegiatan </a></li>
            <li><a href="#"><i class="fa fa-list"></i> Rekap Keuangan</a></li>
          </ul>
        </li>
        
        <li>
          <a href="#">
            <i class="fa fa-envelope"></i> <span>Inbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>

         <li>
          <a href="../main/logout.php">
            <i class="fa fa-sign-out"></i> <span>Sign Out</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="konten">
  <section class="content-header" style="width: 100%;">
      <h1>
        JABATAN
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
        <li><a href="#">Jabatan</a></li>
      </ol>
    </section>
    <section class="content" style="width: 100%;">
      <div class="col-xs-12">
        <div class="box">
          <table width="100%">
              <tr>
                <td>
                    <div class="box-header">
                    <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#addJabatan"><span class="fa fa-plus-square-o"></span> Jabatan Baru</a>
                    </div>
                </td>
              </tr>
            </table>
        </div>
        <div class="box-body" align="center">
           <? echo DisplayJab();?>
        </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
  <?php require_once('../main/footer.php');?>
    <div class="modal fade" id="addJabatan" tabindex="-1" role="dialog">
      <form id="div" class="form-horizontal" method="post" action="">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
               <div class="modal-header" style="background-color: #3C8DBC;">
                    <h4 class="modal-title" style="color: white;"><b>JABATAN BARU</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <table cellpadding="0" cellspacing="0"width="100%">
                            </tr>
                                <td>
                                   <label for="inputJabatanNama" class="col-sm-2 control-label">Jabatan</label> : &nbsp; 
                                   <input type="text" class="form-control-sm" name="jabNama" maxlength="40" size="40" placeholder="Nama Jabatan" required />
                                </td>
                            </tr>
                            </tr>
                                <td>
                                   <label for="inputJabatanDesc" class="col-sm-2 control-label">Deskripsi</label> : &nbsp; 
                                   <input type="text" class="form-control-sm" name="jabDesc" maxlength="40" size="40" placeholder="Deskripsi" required/>
                                </td>
                            </tr>
                        </table>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="saveJab" name="saveJab">Simpan</button>
                </div>
          </div>
        </div>
      </form>
    </div>
<div class="control-sidebar-bg"></div>
</div>

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../assets/jquery-3.3.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Datatable JS -->
<script src="../assets/plugins/datatables/jquery.datatables.js"></script>
<!-- FastClick -->
<script src="../assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<!-- <script src="../assets/dist/js/app.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<script type="text/javascript" src="../assets/plugins/toast/jquery.toast.min.js"></script>
<script>
  jQuery(function($) {
    $('#usertab').Datatable({
      "bSort":true,
      "bFilter":true,
    });
  });
</script>

</form>
</body>
</html>
