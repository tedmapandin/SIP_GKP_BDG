<?php 
  session_start();

  /*error_reporting(E_ALL); 
  ini_set('display_errors', TRUE); 
  ini_set('display_startup_errors', TRUE); */

  include("../conn/conn.php");
  include("../control/functions.php");

  $title_pg='Pengguna';

  if($_SESSION['status'] !="login")
  {
    header("location:http://localhost/SIP_GKP_BDG/main/login.php");
  }

  //cek session
  $user = $_SESSION['username'];
  $usrid = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user'";

  //echo $get_user;
  $login    = mysqli_query($conn,$get_user);
  while($row = mysqli_fetch_array($login,MYSQLI_ASSOC))
  {
    $role = $row['role_id'];
  }
  //echo $role;

  //variabel input untuk insert user baru
  $nama_lengkap=$email=$ktgDiv=$div=$bid=$jab=$username=$pass1=$pass2=$kontak=$usr_role="";
  $error = array();

  if(!empty($_POST['userid']))
  {
    $user_id = $_POST['userid'];
  }

  //fungsi untuk steril input

  //ambil input user baru
  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      if (empty($_POST["xnama"])) {
          $error[] = "Tuliskan Nama Lengkap";
      } else {
          $nama_lengkap = clean($_POST["xnama"]);
      }

      if (empty($_POST["xemail"])) {
          $error[] = "Masukan Email";
      } else {
          $email = clean($_POST["xemail"]);
      }

      if (empty($_POST["ktg_div"])) {
          $error[] = "Silahkan Pilih Kategori Divisi";
      } else {
          $ktgDiv = clean($_POST["ktg_div"]);
      }

      if (empty($_POST["divisi"])) {
          $error[] = "Silahkan Pilih Divisi";
      } else {
          $div= clean($_POST["divisi"]);
      }

      if (empty($_POST["bid"])) {
          $error[] = "Silahkan Pilih Bidang";
      } else {
          $bid= clean($_POST["bid"]);
      }

      if (empty($_POST["jab"])) {
          $error[] = "Silahkan Pilih Jabatan";
      } else {
          $jab = clean($_POST["jab"]);
      }

      if (empty($_POST["xusername"])) {
          $error[] = "Silahkan Masukan Username";
      } else {
          $username = clean($_POST["xusername"]);
      }


      if (empty($_POST["xpassword"])) {
          $error[] = "Masukan Password";
      } else {
          $pass1 = clean($_POST["xpassword"]);
      }

      if (empty($_POST["xpassword2"])) 
      {
          $error[] = "Password tidak sama";
      } 
      else if($_POST["xpassword2"] != $_POST["xpassword"] ) 
      {
          $error[] = "Password tidak sama";
      }
      else 
      {
          $pass2 = clean($_POST["xpassword2"]);
      }

      if (empty($_POST["role"])) {
          $error[] = "Tentukan Level Akses";
      } else {
          $usr_role = clean($_POST["role"]);
      }

      if(!empty($_POST["xkontak"])) 
      {
        $kontak = clean($_POST["xkontak"]);
      }

      //insert user baru
      if(isset($_POST['simpan']) && count($error) < 1)
      {
          $md5=md5($pass1);
          $sql = "INSERT INTO tbl_user (role_id,ktgdiv_id,div_id,bid_id,jab_id,usr_nama,usr_pswd,usr_name_comp,usr_email,usr_phone)VALUES ('$usr_role','$ktgDiv','$div','$bid','$jab','$username','$md5','$nama_lengkap','$email','$kontak')";

          //echo $sql;
          $exec = mysqli_query($conn,$sql);

          if ($exec !== TRUE) 
          {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
  }

  $uuserid=$unama_lengkap=$uemail=$uktgDiv=$udiv=$ubid=$ujab=$uusername=$upass1=$upass2=$ukontak=$uusr_role="";
  $errorUpd = array();
  if (!empty($_POST["user_id"])) {
        $uuserid = clean($_POST["user_id"]);
    }
    echo $uuserid;
  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      if (empty($_POST["unama"])) {
          $errorUpd[] = "Tuliskan Nama Lengkap";
      } else {
          $unama_lengkap = clean($_POST["unama"]);
      }

      if (empty($_POST["uemail"])) {
          $errorUpd[] = "Masukan Email";
      } else {
          $uemail = clean($_POST["uemail"]);
      }

      if (empty($_POST["uktg_div"])) {
          $errorUpd[] = "Silahkan Pilih Kategori Divisi";
      } else {
          $uktgDiv = clean($_POST["uktg_div"]);
      }

      if (empty($_POST["udivisi"])) {
          $errorUpd[] = "Silahkan Pilih Divisi";
      } else {
          $udiv= clean($_POST["udivisi"]);
      }

      if (empty($_POST["ubid"])) {
          $errorUpd[] = "Silahkan Pilih Bidang";
      } else {
          $ubid= clean($_POST["ubid"]);
      }

      if (empty($_POST["ujab"])) {
          $errorUpd[] = "Silahkan Pilih Jabatan";
      } else {
          $ujab = clean($_POST["ujab"]);
      }

      if (empty($_POST["uusername"])) {
          $errorUpd[] = "Silahkan Masukan Username";
      } else {
          $uusername = clean($_POST["uusername"]);
      }


      if (empty($_POST["upassword"])) {
          $errorUpd[] = "Masukan Password";
      } else {
          $upass1 = clean($_POST["upassword"]);
      }

      if (empty($_POST["upassword2"])) 
      {
          $errorUpd[] = "Password tidak sama";
      } 
      else if($_POST["upassword2"] != $_POST["upassword"] ) 
      {
          $errorUpd[] = "Password tidak sama";
      }
      else 
      {
          $upass2 = clean($_POST["upassword2"]);
      }

      if (empty($_POST["urole"])) {
          $errorUpd[] = "Tentukan Level Akses";
      } else {
          $uusr_role = clean($_POST["urole"]);
      }

      if(!empty($_POST["ukontak"])) 
      {
        $ukontak = clean($_POST["ukontak"]);
      }

      //update user
      if(isset($_POST['updUser']) && count($errorUpd) < 1)
      {
          $umd5=md5($upass1);
          $updateUser = "UPDATE 
                    tbl_user 
                  SET 
                    role_id='$uusr_role',ktgdiv_id='$uktgDiv',div_id='$udiv',bid_id='$ubid',jab_id='$ujab',
                    usr_nama='$uusername',usr_pswd='$umd5',usr_name_comp='$unama_lengkap',usr_email='$uemail',usr_phone='$ukontak'
                  WHERE
                    usr_id = '$uuserid'";

          //echo $updateUser;
          $execUpdUser = mysqli_query($conn,$updateUser);

          if ($execUpdUser !== TRUE) 
          {
              echo "Error: " . $updateUser . "<br>" . $conn->error;
          }
      }

  }

  
  //delete user
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delUser']))
  {
      $deleteUser = "UPDATE tbl_user SET usr_stat=0 WHERE usr_id = '$user_id'";
      $execDelUser = mysqli_query($conn,$deleteUser);

      if ($execDelUser !== TRUE) 
      {
          echo "Error: " . $deleteUser . "<br>" . $conn->error;
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

<div class="wrapper">

  <!--Header-->
  <?php require_once("../main/header.php");?>

  <!-- Left side column. contains the logo and sidebar -->
  <? echo sidebar();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="konten">
  <!-- <?php //include('user.php');?> -->
    <section class="content-header" style="width: 100%;">
      <h1>
        Data Pengguna
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Pengguna</a></li>
        <li class="active">Data Pengguna</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="width: 100%;">
        <div class="col-xs-12">
          <div class="box">
            <table width="100%">
              <tr>
                <td>
                    <div class="box-header">
                    <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#addUser"><span class="fa fa-user-plus"></span> Add Pengguna</a>
                    </div>
                </td>
              </tr>
            </table>
           
            <!-- /.box-header -->
            <?
            if(isset($_POST['simpan']))
            {
                if(count($error) > 0) 
                { 
                ?>
                    <div class="alert alert-danger" role="alert">
                <?
                    foreach($error as $value) 
                    {
                        echo $value."<br/>";
                    };
                };
                ?>
                    </div>
                <?

                if(count($error) < 1) 
                {
                ?>
                    <div class="alert alert-success" role="alert">
                      <? echo "Sukses mendaftarkan ".$nama_lengkap;?>
                    </div>
                <?  
                }
            }
            if(isset($_POST['delUser']))
            {
                ?>
                    <div class="alert alert-success" role="alert">
                      <? echo "User dihapus!";?>
                    </div>
                <?  
            }
            if(isset($_POST['updUser']))
            {
                if(count($errorUpd) > 0) 
                { 
                ?>
                    <div class="alert alert-danger" role="alert">
                <?
                    foreach($errorUpd as $value) 
                    {
                        echo $value."<br/>";
                    };
                ?>
                    </div>
                <?
                }
                else if(count($errorUpd) < 1)
                {
                ?>
                    <div class="alert alert-success" role="alert">
                      <? echo "Sukses update user <strong>".$nama_lengkap."</strong>";?>
                    </div>
                <? 
                } 
            }
            ?>
            <div class="box-body">
              <table id="usertab" class="table table-striped" style="font-size:12px;">
                <thead>    
                <tr>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>Bidang</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                        $get_user = "SELECT a.usr_id,f.bid_nama,b.jab_nama,c.ktgdiv_nama,
                                          d.div_nama,e.role_nama, a.usr_name_comp,a.usr_nama,
                                          a.usr_email,a.usr_phone,a.usr_stat
                                    FROM 
                                        tbl_user a LEFT JOIN tbl_jabatan b ON a.jab_id = b.jab_id
                                        LEFT JOIN tbl_ktgdiv c ON a.ktgdiv_id = c.ktgdiv_id
                                        LEFT JOIN tbl_divisi d ON a.div_id = d.div_id
                                        LEFT JOIN tbl_role e ON a.role_id = e.role_id
                                        LEFT JOIN tbl_bidang f ON a.bid_id = f.bid_id
                                    WHERE a.usr_stat = '1'";
                                    //echo $get_user;
                        $exec_user = mysqli_query($conn,$get_user);
                        if(mysqli_num_rows($exec_user) > 0) 
                        {
                            while($row=mysqli_fetch_array($exec_user,MYSQLI_ASSOC))
                            {
                                
                                //echo $userId;
                                  $userId = $row['usr_id'];
                                  //echo $row['div_nama'];
                                ?>
                                <tr>
                                    <td><?php echo $row['usr_name_comp'];?></td>
                                    <td><?php echo $row['div_nama'];?></td>
                                    <td><?php echo $row['bid_nama'];?></td>
                                    <td><?php echo $row['jab_nama'];?></td>
                                    <td><?php echo $row['usr_email'];?></td>
                                    <td><?php echo $row['usr_phone'];?></td>
                                    <td><?php echo $row['usr_nama'];?></td>
                                    <td><?php echo $row['role_nama'];?></td>
                                    <td><?php 
                                            if($row['usr_stat'] == '1')
                                            {
                                                echo "Aktif";
                                            }
                                            else
                                            {
                                                echo "Non-aktif";
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <a class="btn" data-toggle="modal" data-target="#userEdit<? echo $userId;?>"><span class="fa fa-pencil"></span></a>
                                        <a class="btn" href="#"><span class="fa fa-refresh"></span></a>
                                        <a class="btn" data-toggle="modal" data-target="#userDelete<? echo $userId;?>"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>

                                <!-- modal delete user -->
                                <div class="modal fade" id="userDelete<? echo $userId;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header" style="background-color: #3C8DBC;">
                                              <h4 class="modal-title" id="myModalLabel">Hapus User</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          </div>
                                          <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                              <input type="hidden" name="userid" id="userid" value="<? echo $userId;?>">
                                            <?php
                                              $del=mysqli_query($conn,"select * from tbl_user where usr_id='".$userId."'");
                                              $drow=mysqli_fetch_array($del);
                                            ?>
                                              <div class="container-fluid">
                                                <h5><center>Konfirmasi hapus user : <strong><?php echo $drow['usr_name_comp']; ?></strong> ?</center></h5> 
                                              </div> 
                                            </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                                              <button type="submit" class="btn btn-danger" id="delUser" name="delUser"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                                          </div>
                                        </form>
                                      </div>
                                  </div>
                              </div>

                              <!-- modal edit user -->
                              <div class="modal fade" id="userEdit<? echo $userId;?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #3C8DBC;">
                                            <h5 class="modal-title" style="color: white;">Edit Pengguna</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                           <input type="hidden" name="user_id" id="user_id" value="<? echo $userId;?>">

                                         <?php
                                         //echo $userId;
                                            $edit=mysqli_query($conn,"select * from tbl_user where usr_id='".$userId."'");
                                            $drow=mysqli_fetch_array($edit);
                                          ?>
                                        <div class="modal-body">
                                              <div>
                                                  <label for="inputUserName" class="col-sm-4 control-label">Nama</label>
                                                  <div class="col-sm-9">
                                                      <input type="text" name="unama" id="unama" class="form-control form-control-sm" placeholder="Nama Lengkap" value="<? echo $drow['usr_name_comp'];?>">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                                                  <div class="col-sm-7">
                                                      <input type="email" name="uemail" id="uemail" class="form-control form-control-sm" id="uemail" placeholder="Email" value="<? echo $drow['usr_email'];?>">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <div class="col-sm-12">
                                                      <!-- kategori Divisi -->
                                                      <select class="form-control-sm" id="uktg_div" name="uktg_div">
                                                          <option value="">- Divisi -</option>
                                                          <?php
                                                          $get_ktgDiv = "SELECT * FROM tbl_ktgdiv ORDER BY ktgdiv_id";
                                                          $query = mysqli_query($conn,$get_ktgDiv);
                                                          while ($rowUpdKDiv = mysqli_fetch_array($query)) 
                                                          {
                                                          ?>
                                                              <option value="<?php echo $rowUpdKDiv['ktgdiv_id']; ?>" 
                                                                            <?if($rowUpdKDiv['ktgdiv_id'] == $drow['ktgdiv_id']) 
                                                                            { 
                                                                              echo "selected"; 
                                                                            }?>>
                                                                  <?php echo $rowUpdKDiv['ktgdiv_nama']; ?>
                                                              </option>
                                                          <?php
                                                          }
                                                          ?>
                                                      </select>&nbsp;
                                                      <!-- Divisi -->
                                                      <select class="form-control-sm" id="udivisi" name="udivisi">
                                                          <option value="">&nbsp;</option>
                                                          <?php
                                                          $get_div ="SELECT * FROM tbl_divisi INNER JOIN tbl_ktgdiv ON tbl_divisi.ktgdiv_id = tbl_ktgdiv.ktgdiv_id"; 
                                                          $query = mysqli_query($conn,$get_div);
                                                          while ($rowUpdDiv = mysqli_fetch_array($query)) {
                                                          ?>
                                                              <option id="kota" class="<?php echo $rowUpdDiv['ktgdiv_id']; ?>" value="<?php echo $rowUpdDiv['div_id']; ?>"
                                                                            <?if($rowUpdDiv['div_id'] == $drow['div_id']) 
                                                                            { 
                                                                              echo "selected"; 
                                                                            }?>>
                                                                  <?php echo $rowUpdDiv['div_nama']; ?>
                                                              </option>
                                                          <?php
                                                          }
                                                          ?>
                                                      </select>&nbsp;
                                                      <!-- Bidang -->
                                                      <select class="form-control-sm" id="ubid" name="ubid">
                                                          <option value="">- Bidang  -</option>
                                                          <?php
                                                          $get_bid = "SELECT * FROM tbl_bidang ORDER BY bid_id";
                                                          $query = mysqli_query($conn,$get_bid);
                                                          while ($rowUpdBid = mysqli_fetch_array($query)) 
                                                          {
                                                          ?>
                                                              <option value="<?php echo $rowUpdBid['bid_id']; ?>"
                                                                            <?if($rowUpdBid['bid_id'] == $drow['bid_id']) 
                                                                            { 
                                                                              echo "selected"; 
                                                                            }?>>
                                                                  <?php echo $rowUpdBid['bid_nama']; ?>
                                                              </option>
                                                          <?php
                                                          }
                                                          ?>
                                                      </select>&nbsp;
                                                      <!-- Jabatan -->
                                                      <select class="form-control-sm" id="ujab" name="ujab">
                                                          <option value="">- Jabatan  -</option>
                                                          <?php
                                                          $get_jab = "SELECT * FROM tbl_jabatan ORDER BY jab_id";
                                                          $query = mysqli_query($conn,$get_jab);
                                                          while ($rowJabUpd = mysqli_fetch_array($query)) 
                                                          {
                                                          ?>
                                                              <option value="<?php echo $rowJabUpd['jab_id']; ?>"
                                                                            <?if($rowJabUpd['jab_id'] == $drow['jab_id']) 
                                                                            { 
                                                                              echo "selected"; 
                                                                            }?>>
                                                                  <?php echo $rowJabUpd['jab_nama']; ?>
                                                              </option>
                                                          <?php
                                                          }
                                                          ?>
                                                      </select>
                                                  </div>                                      
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputUserName" class="col-sm-4 control-label">Username</label>
                                                  <div class="col-sm-4">
                                                      <input type="text" name="uusername" id="uusername" class="form-control form-control-sm" value="<? echo $drow['usr_nama'];?>" placeholder="Username">
                                                  </div>
                                              </div>
                                              <div class="form-group">                           
                                                  <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                                                  <div class="col-sm-4">
                                                      <input type="password" name="upassword" id="upassword" class="form-control form-control-sm" placeholder="Password"> 
                                                  </div>
                                                  <label for="inputPassword4" class="col-sm-4 control-label">Ulangi Password</label>
                                                  <div class="col-sm-4">
                                                      <input type="password" name="upassword2" id="upassword2" class="form-control form-control-sm" placeholder="Ulangi Password">
                                                      
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputUserName" class="col-sm-4 control-label">No. Telp</label>
                                                  <div class="col-sm-3">
                                                      <input type="text" name="ukontak" id="ukontak" class="form-control form-control-sm" placeholder="No. Telp/HP" value="<? echo $drow['usr_phone'];?>">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputUserName" class="col-sm-4 control-label">Level</label>
                                                  <div class="col-sm-7">
                                                      <select class="form-control-sm" id="urole" name="urole">
                                                          <option value="">- Role  -</option>
                                                          <?php
                                                          $get_bid = "SELECT * FROM tbl_role ORDER BY role_id";
                                                          $query = mysqli_query($conn,$get_bid);
                                                          while ($row = mysqli_fetch_array($query)) 
                                                          {
                                                          ?>
                                                              <option value="<?php echo $row['role_id']; ?>"
                                                                            <?if($row['role_id'] == $drow['role_id']) 
                                                                            { 
                                                                              echo "selected"; 
                                                                            }?>>
                                                                  <?php echo $row['role_nama']; ?>
                                                              </option>
                                                          <?php
                                                          }
                                                          ?>
                                                      </select>
                                                  </div>
                                              </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary btn-flat" id="updUser" name="updUser">Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                              <?
                            }
                        }
                  ?> 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
  <?php require_once('../main/footer.php');?>

<div class="control-sidebar-bg"></div>
</div>

<!-- modal Add New User -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3C8DBC;">
                        <h5 class="modal-title" style="color: white;">Add Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                          <div>
                              <label for="inputUserName" class="col-sm-4 control-label">Nama</label>
                              <div class="col-sm-9">
                                  <input type="text" name="xnama" id="xnama" class="form-control form-control-sm" id="xnama" placeholder="Nama Lengkap">
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                              <div class="col-sm-7">
                                  <input type="email" name="xemail" id="xemail" class="form-control form-control-sm" id="xemail" placeholder="Email">
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-sm-12">
                                  <!-- kategori Divisi -->
                                  <select class="form-control-sm" id="ktg_div" name="ktg_div">
                                      <option value="">- Divisi -</option>
                                      <?php
                                      $get_ktgDiv = "SELECT * FROM tbl_ktgdiv ORDER BY ktgdiv_id";
                                      $query = mysqli_query($conn,$get_ktgDiv);
                                      while ($rowktgDiv = mysqli_fetch_array($query)) 
                                      {
                                      ?>
                                          <option value="<?php echo $rowktgDiv['ktgdiv_id']; ?>">
                                              <?php echo $rowktgDiv['ktgdiv_nama']; ?>
                                          </option>
                                      <?php
                                      }
                                      ?>
                                  </select>&nbsp;
                                  <!-- Divisi -->
                                  <select class="form-control-sm" id="divisi" name="divisi">
                                      <option value="">&nbsp;</option>
                                      <?php
                                      $get_div ="SELECT * FROM tbl_divisi INNER JOIN tbl_ktgdiv ON tbl_divisi.ktgdiv_id = tbl_ktgdiv.ktgdiv_id"; 
                                      $query = mysqli_query($conn,$get_div);
                                      while ($rowDiv = mysqli_fetch_array($query)) {
                                      ?>
                                          <option id="kota" class="<?php echo $rowDiv['ktgdiv_id']; ?>" value="<?php echo $rowDiv['div_id']; ?>">
                                              <?php echo $rowDiv['div_nama']; ?>
                                          </option>
                                      <?php
                                      }
                                      ?>
                                  </select>&nbsp;
                                  <!-- Bidang -->
                                  <select class="form-control-sm" id="bid" name="bid">
                                      <option value="">- Bidang  -</option>
                                      <?php
                                      $get_bid = "SELECT * FROM tbl_bidang ORDER BY bid_id";
                                      $query = mysqli_query($conn,$get_bid);
                                      while ($rowBid = mysqli_fetch_array($query)) 
                                      {
                                      ?>
                                          <option value="<?php echo $rowBid['bid_id']; ?>">
                                              <?php echo $rowBid['bid_nama']; ?>
                                          </option>
                                      <?php
                                      }
                                      ?>
                                  </select>&nbsp;
                                  <!-- Jabatan -->
                                  <select class="form-control-sm" id="jab" name="jab">
                                      <option value="">- Jabatan  -</option>
                                      <?php
                                      $get_bid = "SELECT * FROM tbl_jabatan ORDER BY jab_id";
                                      $query = mysqli_query($conn,$get_bid);
                                      while ($rowJab = mysqli_fetch_array($query)) 
                                      {
                                      ?>
                                          <option value="<?php echo $rowJab['jab_id']; ?>">
                                              <?php echo $rowJab['jab_nama']; ?>
                                          </option>
                                      <?php
                                      }
                                      ?>
                                  </select>
                              </div>                                      
                          </div>
                          <div class="form-group">
                              <label for="inputUserName" class="col-sm-4 control-label">Username</label>
                              <div class="col-sm-4">
                                  <input type="text" name="xusername" id="xusername" class="form-control form-control-sm" placeholder="Username">
                              </div>
                          </div>
                          <div class="form-group">                           
                              <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                              <div class="col-sm-4">
                                  <input type="password" name="xpassword" id="xpassword" class="form-control form-control-sm" placeholder="Password"> 
                              </div>
                              <label for="inputPassword4" class="col-sm-4 control-label">Ulangi Password</label>
                              <div class="col-sm-4">
                                  <input type="password" name="xpassword2" id="xpassword2" class="form-control form-control-sm" placeholder="Ulangi Password">
                                  
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputUserName" class="col-sm-4 control-label">No. Telp</label>
                              <div class="col-sm-3">
                                  <input type="text" name="xkontak" id="xkontak" class="form-control form-control-sm" placeholder="No. Telp/HP">
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputUserName" class="col-sm-4 control-label">Level</label>
                              <div class="col-sm-7">
                                  <select class="form-control-sm" id="role" name="role">
                                      <option value="">- Role  -</option>
                                      <?php
                                      $get_bid = "SELECT * FROM tbl_role ORDER BY role_id";
                                      $query = mysqli_query($conn,$get_bid);
                                      while ($row = mysqli_fetch_array($query)) 
                                      {
                                      ?>
                                          <option value="<?php echo $row['role_id']; ?>">
                                              <?php echo $row['role_nama']; ?>
                                          </option>
                                      <?php
                                      }
                                      ?>
                                  </select>
                              </div>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="simpan" name="simpan">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
</div>

<!-- modal hapus user -->


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
<script src="../assets/jquery.chained.min.js"></script>
<script type="text/javascript">
  $("#divisi").chained("#ktg_div");
  $("#Upddivisi").chained("#Updktg_div");
</script>
</body>
</html>
