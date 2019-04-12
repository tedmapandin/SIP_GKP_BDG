<?
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      if(!empty($_POST['progid']))
      {
        $id_trans = $_POST['progid'];
      }
      if(!empty($_POST['keg_id']))
      {
        $id_keg = $_POST['keg_id'];
      }
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
      }

      if(isset($_POST['editProg']) && count($errorLap) < 1)
      {
          $sql = "UPDATE 
                    tbl_transaksi 
                  SET 
                    bid_id='$bidLap',usr_id='$id_usr' 
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
          }
      }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delProg']))
  {
      $deleteTrans = "UPDATE tbl_transaksi SET trans_stat=9 WHERE trans_id = '$id_trans'";
      $execDelTrans = mysqli_query($conn,$deleteTrans);

      if ($execDelTrans !== TRUE) 
      {
          echo "Error: " . $deleteTrans . "<br>" . $conn->error;
      }
  }
?>