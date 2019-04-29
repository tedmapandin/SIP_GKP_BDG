<?php 
  session_start();

 /* error_reporting(E_ALL); 
  ini_set('display_errors', TRUE); 
  ini_set('display_startup_errors', TRUE); */

  include("../conn/conn.php");
  include("../control/functions.php");
  include("../control/prog_functions.php");
  include("../assets/PHPMailer/src/PHPMailer.php");
  include("../assets/PHPMailer/src/SMTP.php");
  include("../assets/PHPMailer/src/OAuth.php");
  $title_pg='Program';
// Program to display complete URL          
// Display the link 

  if($_SESSION['status'] !="login")
  {
    header("location:http://localhost/SIP_GKP_BDG/main/login.php");
  }

  $user = $_SESSION['username'];
  $usrid = $_SESSION['usr_id'];
  $get_user   = "SELECT a.*, b.* 
                 FROM tbl_user a LEFT JOIN tbl_divisi b ON a.div_id = b.div_id 
                 WHERE 
                  a.usr_nama='$user'";
  $login    = mysqli_query($conn,$get_user);
  $row = mysqli_fetch_array($login,MYSQLI_ASSOC);
  
  $role = $row['role_id'];
  $ktgdiv =$row['ktgdiv_id'];
  $bidang = $row['bid_id'];
  $divi = $row['div_id'];
  $id_usr = $row['usr_id'];
  $div_name = $row['div_nama'];

  
  $filt="";
  if($ktgdiv != '1' || $ktgdiv != '3')
  {
      if($bidang != '1')
      {
        $filt = " WHERE a.div_id = '$divi' AND a.bid_id = '$bidang'";
      }
      else
      {
        $filt = " WHERE a.div_id = '$divi'";
      }
  }
  else
  {
    $filt = "WHERE a.trans_stat = '1'";
  }

 $bidLap=$blnLap=$thnLap=$nama_keg=$jenis_keg=$tgl_keg=$tmp_keg=$urai_keg=$ket_keg=$tgl_keu=$ket_keu=$nom_keu="";
  $errorLap=array();

  if ($_SERVER["REQUEST_METHOD"] == "POST"  && (isset($_POST['aprvProg']) || isset($_POST['rejProg']) || isset($_POST['saveProg']))) 
  {
      if(!empty($_POST['progid']))
      {
        $id_trans = $_POST['progid'];
      }
      if(!empty($_POST['keg_id']))
      {
        $id_keg = $_POST['keg_id'];
      }
      if(empty($_POST['filterBid'])){
          $errorLap[] = "Tentukan Bidang";
      }else {
          $bidLap = clean($_POST['filterBid']);
      }
      if(empty($_POST['lapMonth'])){
          $errorLap[] = "Tentukan Bulan";
      }else {
          $blnLap = clean($_POST['lapMonth']);
      }
      if(empty($_POST['lapYear'])){
          $errorLap[] = "Tentukan Tahun";
      }else {
          $thnLap = clean($_POST['lapYear']);
      }
      if(empty($_POST['keg_name'])){
          $errorLap[] = "Masukan nama kegiatan";
      }else {
          $nama_keg = clean($_POST['keg_name']);
      }
       if(empty($_POST['jenis_keg'])){
          $errorLap[] = "Masukan jenis kegiatan";
      }else {
          $jenis_keg = clean($_POST['jenis_keg']);
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
      if(empty($_POST['nom_keu'])){
          $errorLap[] = "Masukan nominal anggaran";
      }else {
          $nom_keu = clean($_POST['nom_keu']);
      }

      foreach($errorLap as $key=>$value)
      {
        echo '<div class="alert alert-warning">'.$value.'</div>';
      }

      if(isset($_POST['saveProg']) && count($errorLap) < 1)
      {
          $sql = "INSERT INTO tbl_transaksi (div_id,bid_id,usr_id,trans_stat)VALUES ('$divi','$bidLap','$id_usr',1)";
          //echo $sql;
          $exec = mysqli_query($conn,$sql);

          if ($exec !== TRUE) 
          {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $progid=mysqli_insert_id($conn);

          $sqlkeg ="INSERT INTO tbl_detkeg(trans_id,bln_id,thn_desc,detkeg_nama,detkeg_jenis,detkeg_urai,detkeg_ket,detkeg_tgl,detkeg_tempat)VALUES('$progid','$blnLap','$thnLap','$nama_keg','$jenis_keg','$urai_keg','$ket_keg','$tgl_keg','$tmp_keg')";
          //echo $sqlkeg;
          $execkeg = mysqli_query($conn,$sqlkeg);

          if ($execkeg !== TRUE) 
          {
              echo "Error: " . $sqlkeg . "<br>" . $conn->error;
          }

          $det_kegid = mysqli_insert_id($conn);

          $sqlkeu ="INSERT INTO tbl_detkeu(detkeg_id,detkeu_nom)VALUES('$det_kegid','$nom_keu')";
          //echo $sqlkeu;
          $execkeu = mysqli_query($conn,$sqlkeu);
          if ($execkeu !== TRUE) 
          {
              echo "Error: " . $sqlkeu . "<br>" . $conn->error;
          }
          //header("location:http://localhost/SIP_GKP_BDG/main/program.php");

          $mail = new PHPMailer\PHPMailer\PHPMailer();
          $mail->IsSMTP(); // enable SMTP

          //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
          $mail->SMTPAuth = true; // authentication enabled
          $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
          $mail->Host = "smtp.gmail.com";
          $mail->Port = 465; // or 587
          $mail->IsHTML(true);
          $mail->Username = "user.sipgkpbddg@gmail.com";
          $mail->Password = "user.sipgkp@1234";
          $mail->SetFrom("user.sipgkpbddg@gmail.com");
          $mail->Subject = "Program Baru";
          $mail->Body = "Program baru telah diinput.<br/> Divisi : ".$div_name." <br/> Nama Program : ". $nama_keg ."<br/><br/><p>Silahkan Cek Program SIP.</p>";

          $mail->AddAddress("mj.sipgkpbdg@gmail.com");
          $mail->AddCC("tedmapandin@gmail.com");
          $mail->AddCC("bayukristiadhimuliasetia@gmail.com");

          if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
          } else {
            echo '<div class="alert alert-success">Program Sukses diupload</div>';
          }

          /*if($m->send()) {
            header('location: http://localhost/SIP_GKP_BDG/main/program.php');
            die();
          } else {
            $errorLap[] = 'Maaf gagal kirim email, silahkan coba lagi';
          }*/

      }

      if(count($errorLap) < 1 && $ktgdiv == 1)
      {
         if(isset($_POST['aprvProg']))
         {
            $stat    = '3';
            $qryStat = " ,trans_stat = '$stat'";
            //send notif
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP(); // enable SMTP

            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "mj.sipgkpbdg@gmail.com";
            $mail->Password = "mj@sipgkp1234";
            $mail->SetFrom("mj.sipgkpbdg@gmail.com");
            $mail->Subject = "Program baru diterima";
            $mail->Body = "Program baru telah direview dan diterima.<br/> Divisi : ".$div_name." <br/> Nama Program : ". $nama_keg ."<br/><br/><p>Silahkan melaksanakan programnya. Untuk info detail bisa dicek di SIP GKP Bandung.</p>";

            $mail->AddAddress("user.sipgkpbddg@gmail.com");
            $mail->AddCC("tedmapandin@gmail.com");
            $mail->AddCC("bayukristiadhimuliasetia@gmail.com");
            if(!$mail->Send()) {
              echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
              echo '<div class="alert alert-success">Program Sukses direview</div>';
            }
         }
         if(isset($_POST['rejProg']))
         {
            $stat    = '4';
            $qryStat = " ,trans_stat = '$stat'";
            //send notif
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP(); // enable SMTP

            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "mj.sipgkpbdg@gmail.com";
            $mail->Password = "mj@sipgkp1234";
            $mail->SetFrom("mj.sipgkpbdg@gmail.com");
            $mail->Subject = "Program baru ditolak";
            $mail->Body = "Program baru telah direview dan ditolak.<br/> Divisi : ".$div_name." <br/> Nama Program : ". $nama_keg ."<br/><br/><p>Silahkan hubungi majelis bidang. <br/>Untuk info detail bisa dicek di SIP GKP Bandung.</p>";

            $mail->AddAddress("user.sipgkpbddg@gmail.com");
            $mail->AddCC("tedmapandin@gmail.com");
            $mail->AddCC("bayukristiadhimuliasetia@gmail.com");
            if(!$mail->Send()) {
              echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
              echo '<div class="alert alert-success">Program Sukses direview</div>';
            }
         }

          $sql = "UPDATE 
                    tbl_transaksi 
                  SET 
                    bid_id='$bidLap',usr_id='$id_usr' $qryStat
                  WHERE trans_id='$id_trans'";
          //echo $sql.'<br/>';
          $exec = mysqli_query($conn,$sql);

          if ($exec !== TRUE) 
          {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $sqlkeg ="UPDATE 
                      tbl_detkeg 
                    SET 
                      bln_id='$blnLap', 
                      thn_desc='$thnLap', 
                      detkeg_nama='$nama_keg', 
                      detkeg_jenis='$jenis_keg', 
                      detkeg_urai='$urai_keg', 
                      detkeg_tempat='$tmp_keg',
                      detkeg_ket='$ket_keg'
                    WHERE 
                      trans_id='$id_trans'";
          //echo $sqlkeg.'<br/>';
          $execkeg = mysqli_query($conn,$sqlkeg);

          if ($execkeg !== TRUE) 
          {
              echo "Error: " . $sqlkeg . "<br>" . $conn->error;
          }
          else if ($execkeg === TRUE) {
            
          }

          $sqlkeu ="UPDATE
                      tbl_detkeu
                    SET
                      detkeu_nom = '$nom_keu'
                    WHERE
                      detkeg_id = '$id_keg'";
          //echo $sqlkeu;
          $execkeu = mysqli_query($conn,$sqlkeu);
          if ($execkeu !== TRUE) 
          {
              echo "Error: " . $sqlkeu . "<br>" . $conn->error;
          }/* else if($execkeu === TRUE) 


          /*if($execkeg === TRUE && $execkeu === TRUE)
          {
            header("location:http://localhost/SIP_GKP_BDG/main/program.php");
          }*/
      }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delProg']))
  {
      if(!empty($_POST['progid']))
      {
        $id_trans = $_POST['progid'];
      }

      $deleteTrans = "UPDATE tbl_transaksi SET trans_stat=9 WHERE trans_id = '$id_trans'";
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
  <link rel="shorcut icon" type="text/css" href="../assets/images/favicon.png">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../assets/switch_btn.css">
  <link rel="stylesheet" href="../assets/plugins/datatables/jquery.datatables.min.css">
  <script src="../assets/jquery-3.3.1.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/dist/js/app.min.js"></script>
  <script src="../assets/dist/js/demo.js"></script>
  <script src="../assets/dist/js/demo.js"></script>
  <script type="text/javascript" src="../assets/plugins/toast/jquery.toast.min.js"></script>
  <script src="../assets/jquery.form.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<form method="post" action="">
<div class="wrapper">

  <!--Header-->
  <?php require_once("../main/header.php");?>

  <!-- Left side column. contains the logo and sidebar -->
  <? echo sidebar();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="konten">
    <section class="content-header" style="width: 100%;">
      <h1>
        Program
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Program</a></li>
        <li><a href="#">Program Baru</a></li>
      </ol>
    </section>
    <section class="content" style="width: 100%;">
        <div class="col-xs-12">
          <div class="box">
            <?if($ktgdiv != '1'){?>
              <table width="100%" cellspacing="5"width="100%" border="0">
                <tr>
                  <td width="50">
                      <div class="box-header">
                      <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#addProgram"><span class="fa fa-plus-square-o"></span> Program Baru</a>
                      </div>
                  </td>
                  <td width="180">
                      <? selectMonth();?> &nbsp;
                  </td>
                  <td width="150">
                      <? selectYear();?> &nbsp;
                  </td>
                  <td width="150">
                    Status : &nbsp;
                    <select id="status" name="status">
                      <option value="1">All</option>
                      <option value="1">Review</option>
                      <option value="3">Disetujui</option>
                      <option value="4">Ditolak</option>
                      <option value="2">Dilaporkan</option>
                    </select>
                  </td>
                  <td align="left" width="55%">
                    <input type="submit" class="btn btn-primary btn-sm" name="prog"  id="prog" value="FILTER">
                  </td>
                </tr>
              </table>

            <? } else if ($ktgdiv == '1') 
            {
              ?>
              <div class="form-group" style="width: 100%;">
                  <table cellpadding="5" cellspacing="5"width="100%" border="0">
                    <tr>
                      <td width="250">
                          <? selectDiv();?> &nbsp;
                      </td>
                      <td width="180">
                          <? selectMonth();?> &nbsp;
                      </td>
                      <td width="150">
                          <? selectYear();?> &nbsp;
                      </td>
                      <td align="left">
                        <input type="submit" class="btn btn-primary btn-sm" name="prog" id="progMJ" value="FILTER">
                      </td>
                    </tr>
                  </table>
                </div>
            <? } ?>
            
            <!-- /.box-header -->
            <?
            if(isset($_POST['saveLap'])) 
            {
                if(count($errorLap) > 0)  { 
                ?>
                    <div class="alert alert-danger" role="alert">
                <?
                    foreach($errorLap as $value){
                      echo $value."<br/>";
                    };
                };
                ?>
                    </div>
                <?

                if(count($errorLap) < 1) {
                ?>
                    <div class="alert alert-success" role="alert">
                      Sukses.
                    </div>
                <?  
                }
            }
            if($ktgdiv == '1')
            {
                echo displayMJ_view();
            }
            else if($ktgdiv == '2')
            {
              echo displayView();
            }
            ?>
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
<div class="modal fade" id="addProgram" tabindex="-1" role="dialog">
  <? echo modalInputProg(); ?>
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
