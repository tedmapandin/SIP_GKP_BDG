<?
function clean($text)
{
  return $text;
}

function selectBid($bid)
{
  global $conn;
  if($bid != '1')
  {
    $fBid = "WHERE bid_id = '$bid'";
  }

  ?>
   Bidang : <select class="form-control-sm" id="filterBid" name="filterBid">
              <option value="">- Bidang  -</option>
              <?php
              if($bid == '1'){
                echo '<option value="all">Semua</option>';
              }
              $get_bid = "SELECT * FROM tbl_bidang $fBid ORDER BY bid_id";
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
          </select>&nbsp;
  <?
}

function split2curr($nilai) 
{  
    $split=explode('.',$nilai);
    $result="$split[0]";
    $len=strlen("$result");
    if ($split[1] !="00" and $split[1] !="")    {   
        $split[1]=".$split[1]"; 
    }   else    {
        $split[1]="";
    };
    /*
    $count=1;
    $stat=0;
    while ($len >3) {
        $dist=$count*3+$stat;   
        $result=substr_replace($result, ',', -$dist,0);                                         
        $len=$len-3;
        $stat++;
        $count++;
    };
    return "$tit $result$split[1]";
    */
    //if ($split[1] >0) {
    //  return number_format($nilai,2);
    //} else    {
        return number_format($nilai);
    //};     
};

function tgl_indo($tanggal){
    $date = $tanggal;
    $day = date('D', strtotime($date));
    $hari = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );

    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
 
    return $hari[$day] . ', ' .$pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function DisplayDay($val){
    $tanggal = $val;
    $day = date('D', strtotime($tanggal));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    return $dayList[$day];
}

function DisplayDate($val){ 
    $date = new DateTime($val);
    $datefull = date_format($date,"d F Y"); 
    return $datefull;
}

function refresh()
{
  if(isset($_SERVER['HTTPS']) &&  
            $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
    else
        $link = "http"; 
    $link .= "://"; 
    $link .= $_SERVER['HTTP_HOST']; 
    $link .= $_SERVER['PHP_SELF']; 

    return($link);
}

function msg($text)
{   
    $text   =    '<div class="alert alert-success"><strong>Sukses! </strong>'.$text.'</div>';
    return $text;
}

function msg_failed($text)
{
    $text = '<div class="alert alert-warning">'.$text.'</div>';
    return $text;
}

function sidebar()
{
  global $conn;

  $user       = $_SESSION['username'];
  $usrid      = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usrid'";
  $login      = mysqli_query($conn,$get_user);
  while($row = mysqli_fetch_array($login,MYSQLI_ASSOC))
  {
    $role = $row['role_id'];
  }
  ?>
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
        <?php if($role == '1') 
        { 
          ?>
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
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i>
              <span>Program</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="../main/program.php"><i class="fa fa-list"></i> Program Baru </a></li>
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
            <li><a href="../main/kegiatan.php"><i class="fa fa-list"></i> Rekap Kegiatan </a></li>
            <li><a href="#"><i class="fa fa-list"></i> Rekap Keuangan</a></li>
          </ul>
        </li>
        
        <li>
          <a href="#">
            <i class="fa fa-envelope"></i><span>Inbox</span>
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
  <?
}

function sidebarIdx()
{
  global $conn;

  $user       = $_SESSION['username'];
  $usrid      = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usrid'";
  $login      = mysqli_query($conn,$get_user);
  while($row = mysqli_fetch_array($login,MYSQLI_ASSOC))
  {
    $role = $row['role_id'];
  }
  ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Menu Utama</li>
        <li class="active">
          <a href="../SIP_GKP_BDG/index.php">
            <i class="fa fa-home"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right"></small>
            </span>
          </a>
        </li>
        <?php if($role == '1') 
        { 
          ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i>
              <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="../SIP_GKP_BDG/main/divisi.php"><i class="fa fa-list"></i> Divisi </a></li>
              <li><a href="../SIP_GKP_BDG/main/bidang.php"><i class="fa fa-list"></i> Bidang</a></li>
              <li><a href="../SIP_GKP_BDG/main/jabatan.php"><i class="fa fa-list"></i> Jabatan</a></li>
              <li><a href="#"><i class="fa fa-list"></i> No. Akun</a></li>
              <li><a href="../SIP_GKP_BDG/main/user.php"><i class="fa fa-group"></i> User</a></li>
              <li><a href="../SIP_GKP_BDG/main/tahun.php"><i class="fa fa-calendar"></i> Tahun</a></li>
            </ul>
          </li>
           <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i>
              <span>Program</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="../SIP_GKP_BDG/main/program.php"><i class="fa fa-list"></i> Program Baru </a></li>
            </ul>
          </li>
        <?php } ?>
         <li>
          <a href="../SIP_GKP_BDG/main/transaksi.php">
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
            <li><a href="../SIP_GKP_BDG/main/kegiatan.php"><i class="fa fa-list"></i> Rekap Kegiatan </a></li>
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
          <a href="../SIP_GKP_BDG/main/logout.php">
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
  <?
}

if(isset($_POST["btnSubmit"]))
{     
        $errors = array();
         
        $extension = array("jpeg","jpg","png","gif");
         
        $bytes = 1024;
        $allowedKB = 100;
        $totalBytes = $allowedKB * $bytes;
         
        if(isset($_FILES["files"])==false)
        {
            echo "<b>Please, Select the files to upload!!!</b>";
            return;
        }
         
        $conn = mysqli_connect("localhost","root","","phpfiles");   
         
        foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name)
        {
            $uploadThisFile = true;
             
            $file_name=$_FILES["files"]["name"][$key];
            $file_tmp=$_FILES["files"]["tmp_name"][$key];
             
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
 
            if(!in_array(strtolower($ext),$extension))
            {
                array_push($errors, "File type is invalid. Name:- ".$file_name);
                $uploadThisFile = false;
            }               
             
            if($_FILES["files"]["size"][$key] > $totalBytes){
                array_push($errors, "File size must be less than 100KB. Name:- ".$file_name);
                $uploadThisFile = false;
            }
             
            if(file_exists("Upload/".$_FILES["files"]["name"][$key]))
            {
                array_push($errors, "File is already exist. Name:- ". $file_name);
                $uploadThisFile = false;
            }
             
            if($uploadThisFile){
                $filename=basename($file_name,$ext);
                $newFileName=$filename.$ext;                
                move_uploaded_file($_FILES["files"]["tmp_name"][$key],"Upload/".$newFileName);
                 
                $query = "INSERT INTO UserFiles(FilePath, FileName) VALUES('Upload','".$newFileName."')";
                 
                mysqli_query($conn, $query);            
            }
        }
         
        mysqli_close($conn);
         
        $count = count($errors);
         
        if($count != 0){
            foreach($errors as $error){
                echo $error."<br/>";
            }
        }       
}

?>