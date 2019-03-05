<?php 
  session_start();

  error_reporting(E_ALL); 
  ini_set('display_errors', TRUE); 
  ini_set('display_startup_errors', TRUE); 

  include("../conn/conn.php");
  include("../control/functions.php");
  $title_pg='Transaksi';


  if($_SESSION['status'] !="login")
  {
    header("location:http://localhost/SIP_GKP_BDG/main/login.php");
  }

  $user = $_SESSION['username'];
  $usrid = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user'";
  $login    = mysqli_query($conn,$get_user);
  $row = mysqli_fetch_array($login,MYSQLI_ASSOC);
  
    $role = $row['role_id'];
    $ktgdiv =$row['ktgdiv_id'];
    $bidang = $row['bid_id'];
    $divi = $row['div_id'];
    $id_usr = $row['usr_id'];
  

  $filt="";
  if($role != '1') 
  {
    if($ktgdiv != '1' || $ktgdiv != '3')
    {
      if($bidang != '1')
      {
        $filt = "WHERE a.div_id = '$divi' AND a.bid_id = '$bidang'";
      }
      else
      {
        $filt = "WHERE a.div_id = '$divi'";
      }
    }
  }

  function clean($data) 
  {
      return $data;
  }

   $bidLap=$blnLap=$thnLap=$nama_keg=$tgl_keg=$tmp_keg=$urai_keg=$ket_keg=$tgl_keu=$ket_keu=$nom_keu="";
  $errorLap=array();

  $id_trans="";
  if(!empty($_POST))
  {
    $id_trans = $_POST['transid'];
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      if(empty($_POST['lapBid'])){
          $errorLap[] = "Tentukan Bidang";
      }else {
          $bidLap = clean($_POST['lapBid']);
      }
      if(empty($_POST['lapMonth'])){
          $errorLap[] = "Tentukan Bulan";
      }else {
          $blnLap = clean($_POST['lapMonth']);
      }
      if(empty($_POST['lapYear'])){
          $errorLap[] = "Tentukan Bidang";
      }else {
          $thnLap = clean($_POST['lapYear']);
      }
      if(empty($_POST['keg_name'])){
          $errorLap[] = "Masukan jenis kegiatan";
      }else {
          $nama_keg = clean($_POST['keg_name']);
      }
      if(empty($_POST['tgl_keg'])){
          $errorLap[] = "Masukan Tanggal kegiatan";
      }else {
          $tgl_keg = clean($_POST['tgl_keg']);
      }
      if(empty($_POST['tem_keg'])){
          $errorLap[] = "Masukan Tempat kegiatan";
      }else {
          $tmp_keg = clean($_POST['tem_keg']);
      }
      if(empty($_POST['urai_keg'])){
          $errorLap[] = "Tuliskan uraian kegiatan";
      }else {
          $urai_keg = clean($_POST['urai_keg']);
      }
      if(empty($_POST['ket_keg'])){
          $errorLap[] = "Tuliskan keterangan";
      }else {
          $ket_keg = clean($_POST['ket_keg']);
      }

      if(empty($_POST['tgl_keu'])){
          $errorLap[] = "Masukan tanggal pengeluaran";
      }else {
          $tgl_keu = clean($_POST['tgl_keu']);
      }
      if(empty($_POST['ket_keu'])){
          $errorLap[] = "Masukan keterangan pengeluaran";
      }else {
          $ket_keu = clean($_POST['ket_keu']);
      }
      if(empty($_POST['nom_keu'])){
          $errorLap[] = "Masukan nominal pengeluaran";
      }else {
          $nom_keu = clean($_POST['nom_keu']);
      }

      if(isset($_POST['saveLap']) && count($errorLap) < 1)
      {
          $sql = "INSERT INTO tbl_transaksi (div_id,bid_id,usr_id)VALUES ('$divi','$bidLap','$id_usr')";
          //echo $sql;
          $exec = mysqli_query($conn,$sql);

          if ($exec !== TRUE) 
          {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $transid=mysqli_insert_id($conn);

          $sqlkeg ="INSERT INTO tbl_detkeg(trans_id,bln_id,thn_desc,detkeg_nama,detkeg_urai,detkeg_ket,detkeg_tgl,detkeg_tempat)VALUES('$transid','$blnLap','$thnLap','$nama_keg','$urai_keg','$ket_keg','$tgl_keg','$tmp_keg')";
          //echo $sqlkeg;
          $execkeg = mysqli_query($conn,$sqlkeg);

          if ($execkeg !== TRUE) 
          {
              echo "Error: " . $sqlkeg . "<br>" . $conn->error;
          }

          $det_kegid = mysqli_insert_id($conn);
          $count_tgl = count($tgl_keu)-1;
          $x="";
          for($x=0;$x<$count_tgl;$x++)
          {
            $sqlkeu ="INSERT INTO tbl_detkeu(detkeg_id,detkeu_tgl_trans,detkeu_desc,detkeu_nom)VALUES('$det_kegid','$tgl_keu[$x]','$ket_keu[$x]','$nom_keu[$x]')";
            //echo $sqlkeu;
            $execkeu = mysqli_query($conn,$sqlkeu);
            if ($execkeu !== TRUE) 
            {
                echo "Error: " . $sqlkeu . "<br>" . $conn->error;
            }
          }
      }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delTrans']))
  {
      $deleteTrans = "DELETE a.*, b.*, c.* 
                     FROM tbl_transaksi a
                     INNER JOIN tbl_detkeg b  ON a.trans_id = b.trans_id
                     INNER JOIN tbl_detkeu c  ON b.detkeg_id = c.detkeg_id
                     WHERE a.trans_id = '$id_trans'";
      $execDelTrans = mysqli_query($conn,$deleteTrans);

      if ($execDelTrans !== TRUE) 
      {
          echo "Error: " . $deleteTrans . "<br>" . $conn->error;
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
  <script src="../assets/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../assets/dist/js/demo.js"></script>
  <!-- FastClick -->
  <script src="../assets/dist/js/demo.js"></script>
  <script type="text/javascript" src="../assets/plugins/toast/jquery.toast.min.js"></script>
  <script src="../assets/jquery.form.js"></script>
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
        LAPORAN
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Menu</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active">Buat Baru</li>
      </ol>
    </section>
    <section class="content" style="width: 100%;">
        <div class="col-xs-12">
          <div class="box">
            <table width="100%">
              <tr>
                <td>
                    <div class="box-header">
                    <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#addLaporan"><span class="fa fa-plus-square-o"></span> Laporan Baru</a>
                    </div>
                </td>
              </tr>
            </table>
           
            <!-- /.box-header -->
            <?
            if(isset($_POST['saveLap']))
            {
                if(count($errorLap) > 0) 
                { 
                ?>
                    <div class="alert alert-danger" role="alert">
                <?
                    foreach($errorLap as $value) 
                    {
                        echo $value."<br/>";
                    };
                };
                ?>
                    </div>
                <?

                if(count($errorLap) < 1) 
                {
                ?>
                    <div class="alert alert-success" role="alert">
                      Transaksi Sukses !
                    </div>
                <?  
                }
            }
            ?>
            <div class="box-body">
              <table id="laptab" class="table table-sm table-striped" style="font-size:12px;">
                <thead>    
                <tr align="center">
                    <th width="10">No.</th>
                    <th>Divisi</th>
                    <th>Bidang</th>
                    <th>Tanggal Buat</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>User</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                        $i= 0;
                        $get_trans = "SELECT 
                                        a.trans_id,
                                        a.trans_tgl,
                                        b.div_nama,
                                        c.bid_nama,
                                        d.usr_nama,
                                        e.bln_id,
                                        e.thn_desc
                                    FROM 
                                        tbl_transaksi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                      LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                      LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id $filt
                                    ORDER BY e.bln_id DESC, a.trans_tgl ASC";
                                    //echo $get_trans;
                        $exec_trans = mysqli_query($conn,$get_trans);
                        if(mysqli_num_rows($exec_trans) > 0) 
                        {
                            while($row=mysqli_fetch_array($exec_trans,MYSQLI_ASSOC))
                            {
                                
                                $i++;
                                $transId    = $row['trans_id'];
                                //echo $transId;
                                //query nama bulan
                                $bulan      = $row['bln_id'];
                                $get_bln    = "SELECT * FROM tbl_bulan WHERE bln_id = '$bulan'";
                                $exec_bln   = mysqli_query($conn,$get_bln);
                                $row_bln    = mysqli_fetch_array($exec_bln,MYSQLI_ASSOC);
                                $bln        = $row_bln['bln_name'];

                                //query tahun
                                $tahun      = $row['thn_desc'];
                                $get_thn    = "SELECT * FROM tbl_tahun WHERE thn_desc = '$tahun'";
                                $exec_thn   = mysqli_query($conn,$get_thn);
                                $row_thn    = mysqli_fetch_array($exec_thn,MYSQLI_ASSOC);
                                $thn        = $row_thn['thn_desc'];
                                $tgl_keg    = new DateTime($row['trans_tgl']);
                                
                                ?>
                                <tr>
                                    <td><?php echo $i;?>.</td>
                                    <td><?php echo $row['div_nama'];?></td>
                                    <td><?php echo $row['bid_nama'];?></td>
                                    <td align="center"><?php echo date_format($tgl_keg,"Y/m/d");?></td>
                                    <td align="center"><?php echo $bln;?></td>
                                    <td align="center"><?php echo $thn;?></td>
                                    <td align="right"><?php echo $row['usr_nama']?></td>
                                    <td style="text-align:right;">
                                        <input type="hidden" name="transid" id="transid" value="<? echo $transId;?>">
                                        <a class="btn" data-toggle="modal" data-target="#viewLaporan<? echo $transId;?>" ><span class="fa fa-eye"></span></a>
                                        <a class="btn" data-toggle="modal" data-target="#userEdit<? echo $transId;?>"><span class="fa fa-pencil"></span></a>
                                         <a class="btn" data-toggle="modal" data-target="#transDel<? echo $transId;?>"><span class="fa fa-trash"></span></a>
                                        <a class="btn" href="#"><span class="fa fa-refresh"></span></a>
                                    </td>
                                </tr>
                                <!-- Modal View -->
                                <div class="modal fade" id="viewLaporan<? echo $transId;?>" tabindex="-1" role="dialog">
                                  <form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #3C8DBC;">
                                                        <h4 class="modal-title" style="color: white;"><b>DETAIL TRANSAKSI</b></h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="container-fluid">
                                                         <?
                                                            $getdet_trans ="SELECT 
                                                                              a.trans_id,
                                                                              a.trans_tgl,
                                                                              b.div_nama,
                                                                              c.bid_nama,
                                                                              d.usr_nama,
                                                                              e.bln_id,
                                                                              e.thn_desc,
                                                                              e.detkeg_nama,
                                                                              e.detkeg_urai,
                                                                              e.detkeg_ket,
                                                                              e.detkeg_tgl,
                                                                              e.detkeg_tempat,
                                                                              e.detkeg_id
                                                                          FROM 
                                                                              tbl_transaksi a 
                                                                            LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                                                            LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                                                            LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                                                            LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                                                                          WHERE a.trans_id = '$transId'
                                                                          ORDER BY e.bln_id DESC, a.trans_tgl ASC";
                                                            //echo $getdet_trans;
                                                            $execdet_trans = mysqli_query($conn, $getdet_trans);
                                                            $row_trans = mysqli_fetch_array($execdet_trans,MYSQLI_ASSOC);

                                                            $idDetKeg     = $row_trans['detkeg_id'];
                                                            $bulan_det      = $row_trans['bln_id'];

                                                            $getdet_bln    = "SELECT * FROM tbl_bulan WHERE bln_id = '$bulan_det'";
                                                            $execdet_bln   = mysqli_query($conn,$getdet_bln);
                                                            $rowdet_bln    = mysqli_fetch_array($execdet_bln,MYSQLI_ASSOC);
                                                            $bln_det        = $rowdet_bln['bln_name'];
                                                          ?>
                                                        <div class="row" style="width: 100%;padding-left:15px;">
                                                            <div class="row" style="width: 100%;padding-left:15px;">
                                                              <div class="col col-2">Divisi</div>
                                                              <div>: <? echo $row_trans['div_nama'];?></div>
                                                              <div class="col"></div>
                                                              <div>Bulan</div>
                                                              <div class="col col-2">: <? echo $bln_det;?></div>
                                                            </div>
                                                            <div class="row" style="width: 100%;padding-left:15px;">
                                                              <div class="col col-2">Bidang</div>
                                                              <div>: <? echo $row_trans['bid_nama'];?></div>
                                                              <div class="col"></div>
                                                              <div>Tahun</div>
                                                              <div class="col col-2">: <? echo $row_trans['thn_desc'];?></div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <!-- TAB VIEW -->
                                                        <ul class="nav nav-tabs" role="tablist">
                                                          <li class="nav-item">
                                                            <a class="nav-link active" href="#vtranskeg<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Kegiatan</a>
                                                          </li>
                                                          <li class="nav-item">
                                                            <a class="nav-link" href="#vtranskeu<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Pengeluaran</a>
                                                          </li>
                                                        </ul>

                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                          <br/>
                                                          <!-- tab view kegiatan -->
                                                          <div role="tabpanel" class="tab-pane fade show active" id="vtranskeg<? echo $idDetKeg;?>">
                                                           
                                                              <div class="row">
                                                                <div class="col col-2 no-gutters">Nama Kegiatan</div>
                                                                <div class="col">: <? echo $row_trans['detkeg_nama'];?></div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col col-2 no-gutters" >Tanggal</div>
                                                                <div class="col">: <? echo tgl_indo($row_trans['detkeg_tgl']);?></div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col col-2 no-gutters" >Tempat</div>
                                                                <div class="col">: <? echo $row_trans['detkeg_tempat'];?></div>
                                                              </div>
                                                              <br/>
                                                              <div class="row">
                                                                  <div class="col col-2 no-gutters"><b>Uraian</b></div>
                                                              </div>
                                                              <div class="row" style="padding-left:15px; width: 100%;">
                                                                <span class="border border-secondary rounded col">
                                                                  <div class="col" style="padding-left: 5px;"><pre><? echo $row_trans['detkeg_urai'];?></pre></div>
                                                                </span>
                                                              </div>
                                                              <div class="row">
                                                                  <div class="col col-2 no-gutters"><b>Keterangan</b></div>
                                                              </div>
                                                              <div class="row" style="padding-left:15px; width: 100%;">
                                                                  <span class="border border-secondary rounded col">
                                                                    <div class="col" style="padding-left: 5px;"><pre><? echo $row_trans['detkeg_ket'];?></pre></div>
                                                                  </span>
                                                              </div>
                                                          </div>

                                                          <!-- tab view keuangan/pengeluaran -->
                                                          <div role="tabpanel" class="tab-pane show fade" id="vtranskeu<? echo $idDetKeg;?>">
                                                            <?
                                                              $get_keu = "SELECT detkeg_id, detkeu_desc, detkeu_tgl_trans, detkeu_nom FROM tbl_detkeu
                                                                          WHERE detkeg_id = '$idDetKeg'";
                                                              $exec_keu = mysqli_query($conn,$get_keu);
                                                              while($row_keu = mysqli_fetch_array($exec_keu,MYSQLI_ASSOC))
                                                              {
                                                            ?>
                                                                <div class="row">
                                                                  <div class="col col-2 no-gutters">Biaya</div>
                                                                  <div class="col">: <? echo $row_keu['detkeu_desc'];?></div>
                                                                </div>
                                                                <div class="row">
                                                                  <div class="col col-2 no-gutters" >Tanggal</div>
                                                                  <div class="col">: <? echo tgl_indo($row_keu['detkeu_tgl_trans']);?></div>
                                                                </div>
                                                                <div class="row">
                                                                  <div class="col col-2 no-gutters" >Nominal</div>
                                                                  <div class="col">: Rp. <? echo split2curr($row_keu['detkeu_nom']);?></div>
                                                                </div>
                                                            <?
                                                            }
                                                            ?>
                                                          </div>
                                                        </div>
                                                    </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                  </form>
                                </div>
                                <!-- Modal Delete-->
                                <div class="modal fade" id="transDel<? echo $transId;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header" style="background-color: #3C8DBC;">
                                              <h4 class="modal-title" id="myModalLabel">Hapus Transaksi</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          </div>
                                          <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                              <input type="hidden" name="transid" id="transid" value="<? echo $transId;?>">
                                              <?php
                                                $del=mysqli_query($conn,"select * from tbl_transaksi where trans_id='".$transId."'");
                                                $drow=mysqli_fetch_array($del);
                                              ?>
                                                <div class="container-fluid">
                                                  <h5><center>Konfirmasi hapus Transaksi ?</center></h5> 
                                                </div> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                                                <button type="submit" class="btn btn-danger" id="delUser" name="delTrans"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                                            </div>
                                        </form>
                                      </div>
                                  </div>
                              </div>
                              <?
                            }
                        }
                        else
                        {
                            ?>
                            <tr>
                               <td colspan="8"><?php echo "Belum ada laporan";?></td> 
                            </tr>
                            <?php
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

<!-- Modal Input -->
<div class="modal fade" id="addLaporan" tabindex="-1" role="dialog">
  <form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3C8DBC;">
                        <h4 class="modal-title" style="color: white;"><b>LAPORAN BARU</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                              <table cellpadding="0" cellspacing="0"width="100%">
                                <tr>
                                  <td>
                                      Bidang : <select class="form-control-sm" id="lapBid" name="lapBid">
                                          <option value="">- Bidang  -</option>
                                          <?php
                                          $get_bid = "SELECT * FROM tbl_bidang ORDER BY bid_id";
                                          $query = mysqli_query($conn,$get_bid);
                                          while ($row = mysqli_fetch_array($query)) 
                                          {
                                          ?>
                                              <option value="<?php echo $row['bid_id']; ?>">
                                                  <?php echo $row['bid_nama']; ?>
                                              </option>
                                          <?php
                                          }
                                          ?>
                                      </select>
                                  </td>                       
                                  <td>Bulan : <select class="form-control-sm" id="lapMonth" name="lapMonth">
                                        <?php
                                          $today_month = date('m');
                                          $get_bln = "SELECT * FROM tbl_bulan ORDER BY bln_id";
                                          $query = mysqli_query($conn,$get_bln);
                                          while ($row = mysqli_fetch_array($query)) 
                                          {
                                          ?>
                                              <option value="<?php echo $row['bln_id']; ?>" <?if($row['bln_id'] == $today_month) { echo "selected";}?>>
                                                  <?php echo $row['bln_name']; ?>
                                              </option>
                                          <?php
                                          }
                                          ?>
                                      </select></td>
                                  <td>Tahun : <select class="form-control-sm" id="lapYear" name="lapYear">
                                        <?php
                                          $today_year = date('Y');
                                          $get_thn = "SELECT * FROM tbl_tahun ORDER BY thn_id";
                                          $query = mysqli_query($conn,$get_thn);
                                          while ($row = mysqli_fetch_array($query)) 
                                          {
                                          ?>
                                              <option value="<?php echo $row['thn_desc']; ?>" <?if($row['thn_desc'] == $today_year) { echo "selected";}?>>
                                                  <?php echo $row['thn_desc']; ?>
                                              </option>
                                          <?php
                                          }
                                          ?>
                                      </select></td>
                                </tr>
                              </table>
                          </div>
                      <div class="card card-header text-white bg-primary" style="font-size: 24px;">
                          KEGIATAN
                      </div>
                      <div class="card card-body" ><br/>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <table cellpadding="3" cellspacing="4" >
                                <tr>
                                  <td width="120">Nama Kegiatan </td>
                                  <td> <input type="text" name="keg_name" id="keg_name" class="form-control form-control-sm" id="keg_name" maxlength="30" size="30" placeholder="Nama Kegiatan"></td>
                                </tr>
                                <tr>
                                  <td width="120">Tanggal  </td>
                                  <td> <input type="date" name="tgl_keg" id="tgl_keg" class="form-control form-control-sm" id="tgl_keg" placeholder="Tanggal"></td>
                                </tr>
                                <tr>
                                  <td width="120">Tempat  </td>
                                  <td> <input type="text" name="tem_keg" id="tem_keg" class="form-control form-control-sm" id="tem_keg" placeholder="Tempat"></td>
                                </tr>
                              </table> 
                            </div>  
                          </div>
                          <div class="form-group">
                              <label for="inputUserName" class="col-sm-4 control-label">Uraian</label>
                              <div class="col-sm-12">
                                  <textarea name="urai_keg" id="urai_keg" class="form-control" rows="5"></textarea>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputUserName" class="col-sm-4 control-label">Keterangan</label>
                              <div class="col-sm-12">
                                  <textarea name="ket_keg" id="ket_keg" class="form-control"></textarea>
                              </div>
                          </div>
                          <div class="form-group">                           
                              <label for="inputPassword3" class="col-sm-4 control-label">Foto Kegiatan</label>
                                <div class="col-sm-7">
                                  <form id="upFoto" name="upFoto" method="POST" action="control/uploadImg.php"  enctype="multipart/form-data">
                                    <input type="file" name="upFtKeg[]" id="upFtKeg" multiple="multiple" /> 
                                  </form>
                                </div>
                              <div id="resultFtKeg"></div>
                          </div>
                    </div><br/>
                    <div class="card card-header text-white bg-primary" style="font-size: 24px;">
                          PENGELUARAN
                    </div>
                    <div class="card card-body" >
                      <br/>
                        <div class="table-responsive fieldGrp">
                          <div class="form-group">
                            <table width="100%" cellpadding="3" cellspacing="4">
                              <tr>
                                <td>Tanggal</td>
                                <td> <input type="date" name="tgl_keu[]" id="tgl_keu" class="form-control form-control-sm col-3" id="tgl_keu">
                              </tr>
                              <tr>
                                <td>Keterangan</td>
                                <td> <input type="text" name="ket_keu[]" id="ket_keu" class="form-control form-control-sm col-8" id="ket_keu">
                              </tr>
                              <tr>
                                <td>Nominal</td>
                                <td>
                                      <label>Rp &nbsp;</label>
                                      <input type="text" class="uang" name="nom_keu[]">
                                </td>  
                              </tr>
                                <tr>
                                <td>Bukti Pengeluaran</td>
                                <td><input type="file" name="upFtKeg[]" id="upFtKeg"></td>
                              </tr>
                            </table>
                        </div>
                      </div>
                        <div class="table-responsive fieldGrpCpy" style="display: none;">
                            <table width="100%" cellpadding="3" cellspacing="4">
                              <tr>
                                <td>Tanggal</td>
                                <td> <input type="date" name="tgl_keu[]" id="tgl_keu" class="form-control form-control-sm col-3" id="tgl_keu">
                              </tr>
                              <tr>
                                <td>Keterangan</td>
                                <td> <input type="text" name="ket_keu[]" id="ket_keu" class="form-control form-control-sm col-8" id="ket_keu">
                              </tr>
                              <tr>
                                <td>Nominal</td>
                                  <td>
                                        <label>Rp &nbsp;</label>
                                        <input type="text" class="uang" name="nom_keu[]">
                                  </td>  
                                </tr>
                                <tr>
                                  <td>Bukti Pengeluaran</td>
                                  <td><input type="file" name="upFtKeu[]" id="upFtKeu"></td>
                              </tr>
                              <tr>
                                <td colspan="2" align="right"><a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></td>
                              </tr>
                            </table>
                        </div>
                      <div class="input-group-addon" align="right"> 
                          <a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> + pengeluaran</a>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary btn-flat" id="saveLap" name="saveLap">Simpan</button>
                    </div>
            </div>
  </form>
</div>

<!-- ./wrapper -->
<script type="text/javascript">
  $(document).ready(function(){
    //group add limit
    var maxGroup = 5;
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldGrp').length < maxGroup){
            var fieldHTML = '<div class="form-group fieldGrp">'+$(".fieldGrpCpy").html()+'</div>';
            $('body').find('.fieldGrp:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldGrp").remove();
    });
});
</script>

</form>
</body>
</html>
