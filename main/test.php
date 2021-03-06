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

  list($usrRole, $usrKtgDiv, $usrBid, $usrDiv,$usrId) = user($user);
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


  $filt="";
  if(!empty($_POST))
  {
    $id_trans = $_POST['transid'];
  }
  if($role != '1') 
  {
    if($ktgdiv != '1' || $ktgdiv != '3')
    {
        $filt = "WHERE a.div_id = '$divi' AND a.bid_id = '$bidang' AND a.trans_stat = '1'";
    }
  }
  else
  {
    $filt = "WHERE a.trans_stat = '1'";
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
            <table width="100%">
              <tr>
                <td>
                    <div class="box-header">
                      <div class="form-group" style="width: 70%;">
                        <table cellpadding="5" cellspacing="5"width="100%">
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
                                &nbsp;
                                <input type="submit" class="btn btn-primary btn-flat" name="progSearch" value="Submit">
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                </td>
              </tr>
            </table>
           
            <!-- /.box-header -->
<!--             <? //if(isset($_POST['progSearch'])) 
            { 
              ?> -->
                <div class="box-body">
                  <div align="center"><h2><strong>DAFTAR LAPORAN</strong></h2></div><br/>
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
                                            <a class="btn" data-toggle="modal" data-target="#editLaporan<? echo $transId;?>">Lapor</a>
                                             <a class="btn" data-toggle="modal" data-target="#transDel<? echo $transId;?>"><span class="fa fa-trash"></span></a>
                                            <a class="btn" href="#"><span class="fa fa-refresh"></span></a>
                                        </td>
                                    </tr>
                                    <!-- Modal View -->
                                    <?
                                        echo modalViewTrans($transId);
                                        echo modalDelTrans($transId);
                                        //echo modalEditTrans($transId);
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
<!--               <? 
            } 
            ?> -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
