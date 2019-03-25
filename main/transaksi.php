<?php 
session_start();

error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE); 


include("../conn/conn.php");
include("../control/functions.php");
include("../control/trans_functions.php");

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editProg']))
{
  if(!empty($_POST['lapDiv'])){
    $lapDiv = clean($_POST['lapDiv']);
  }
  if(!empty($_POST['lapBid'])){
    $lapBid = clean($_POST['lapBid']);
  }
  if(!empty($_POST['progid'])){
    $progid = clean($_POST['progid']);
  }
  if(!empty($_POST['keg_id'])){
    $keg_id = clean($_POST['keg_id']);
  }
  if(!empty($_POST['lapMonth'])){
    $lapMonth = clean($_POST['lapMonth']);
  }
  if(!empty($_POST['lapYear'])){
    $lapYear = clean($_POST['lapYear']);
  }
  if(!empty($_POST['keg_name'])){
    $keg_name = clean($_POST['keg_name']);
  }
  if(!empty($_POST['jenis_keg'])){
    $jenis_keg = clean($_POST['jenis_keg']);
  }
  if(!empty($_POST['tem_keg'])){
    $tem_keg = clean($_POST['tem_keg']);
  }
  if(!empty($_POST['urai_keg'])){
    $urai_keg = clean($_POST['urai_keg']);
  }
  if(!empty($_POST['ket_keg'])){
    $ket_keg = clean($_POST['ket_keg']);
  }
  if(!empty($_POST['nom_keu'])){
    $nom_keu = clean($_POST['nom_keu']);
  }
  if(!empty($_POST['urai_keu'])){
    $urai_keu = clean($_POST['urai_keu']);
  }
  if(!empty($_POST['real_keu'])){
    $real_keu = clean($_POST['real_keu']);
  }

  $qrySubmtLap = "INSERT INTO tbl_realisasi
  (div_id,bid_id,usr_id,trans_id,detkeg_id,bln_id,thn_desc,real_anggaran,real_nama,real_jenis,real_urai,real_ket,real_tempt,real_keu,real_keu_urai,real_stat) VALUE 
  ('$lapDiv','$lapBid','$user','$progid','$keg_id','$lapMonth','$lapYear','$nom_keu','$keg_name','$jenis_keg','$urai_keg','$ket_keg','$tem_keg','$real_keu','$urai_keu',2)";
  //echo $qrySubmtLap.'<br/>';
  $execSubmtLap = mysqli_query($conn,$qrySubmtLap);
  if ($execSubmtLap !== TRUE) 
  {
      echo "Error: " . $qrySubmtLap . "<br>" . $conn->error;
  }

  $updTrans = "UPDATE tbl_transaksi SET trans_stat = '2' WHERE trans_id='$progid'";
  $execUpdTrans = mysqli_query($conn,$updTrans);
  //echo $updTrans;
  if ($execUpdTrans !== TRUE) 
  {
      echo "Error: " . $updTrans . "<br>" . $conn->error;
  }
}

if(isset($_POST['progSearch']))
{
  if(!empty($_POST)) 
  {
    $filterBid = $_POST['filterBid'];
    if($filterBid != "all")
    {
      $filter = "WHERE a.bid_id=$filterBid";
    }
    else
    {
      $filter = "";
    }
  }
}

if($bidang != '1')
{
  $fBid = "WHERE bid_id = '$bidang'";
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
  <? echo sidebar();?>
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
              <div class="box-header">
                <div class="form-group" style="width: 70%;">
                  <table cellpadding="5" cellspacing="5"width="100%">
                    <tr>
                      <td>
                          <? echo selectBid($bidang);?> &nbsp;
                          <input type="submit" class="btn btn-primary btn-sm" name="progSearch" value="Submit">
                      </td>
                    </tr>
                  </table>
                </div>
            <? if(isset($_POST['progSearch'])) 
            { 
              ?>
                <div class="box-body">
                  <div align="center"><h2><strong>DAFTAR LAPORAN</strong></h2></div><br/>
                  <table id="laptab" class="table table-sm table-striped" style="font-size:12px;">
                    <thead>    
                    <tr align="center">
                        <th width="10">No.</th>
                        <th>Divisi</th>
                        <th>Bidang</th>
                        <th>Kegiatan</th>
                        <th>Jenis</th>
                        <th>Tempat</th>
                        <th>Anggaran</th>
                        <th>Pembuat</th>
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
                                            e.detkeg_nama,
                                            e.detkeg_jenis,
                                            e.detkeg_tempat,
                                            e.bln_id,
                                            e.thn_desc,
                                            f.detkeu_nom,
                                            a.trans_stat
                                        FROM 
                                            tbl_transaksi a 
                                          LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                          LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                          LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                          LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                                          LEFT JOIN tbl_detkeu f ON e.detkeg_id = f.detkeg_id
                                         $filter
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
                                    $tStat      = $row['trans_stat'];
                                    
                                    ?>
                                    <tr style="vertical-align: middle;">
                                        <td><?php echo $i;?>.</td>
                                        <td><?php echo $row['div_nama'];?></td>
                                        <td><?php echo $row['bid_nama'];?></td>
                                        <td><?php echo $row['detkeg_nama'];?></td>
                                        <td><?php echo $row['detkeg_jenis'];?></td>
                                        <td><?php echo $row['detkeg_tempat'];?></td>
                                        <td align="right"><?php echo split2curr($row['detkeu_nom']);?></td>
                                        <td align="right"><?php echo $row['usr_nama']?></td>
                                        <? 
                                        if($tStat == '1') 
                                        { 
                                            ?>
                                            <td style="text-align:right;">
                                                <a class="btn" data-toggle="modal" data-target="#editLaporan<? echo $transId;?>"><span class="badge badge-info">Submit</span></a>
                                                <a class="btn" href="#"><span class="fa fa-refresh"></span> 
                                                </a>
                                            </td>
                                            <? 
                                        } 
                                        else if($tStat >= '1') 
                                        { 
                                            ?>
                                            <td style="text-align:right;">
                                                <a title="Lihat RK" class="btn" data-toggle="modal" data-target="#viewLaporan<? echo $transId;?>"><span class="badge badge-success">Submited</span></a> 
                                                <a class="btn" href="http://localhost/SIP_GKP_BDG/main/transaksi"><span class="fa fa-refresh"></span> 
                                                </a>
                                            </td>
                                            <? 
                                        } 
                                        ?>
                                    </tr>
                                    <?
                                    echo modalViewTrans($transId);
                                    echo modalEditTrans($transId); 
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
            <? 
            } 
            ?>
          </div>
        </div>
    </section>
  </div>
<?php require_once('../main/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){
    //group add limit
    var maxGroup = 5;
    $(".addMore").click(function(){
        if($('body').find('.fieldGrp').length < maxGroup){
            var fieldHTML = '<div class="form-group fieldGrp">'+$(".fieldGrpCpy").html()+'</div>';
            $('body').find('.fieldGrp:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldGrp").remove();
    });
}); 
</script>
</form>
</body>
</html>
