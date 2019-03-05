<?
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

function msg($text)
{   $text = '<>';
    return $text;
}


/*............................................................. FUNCTION UNTUK DIVISI........................................................*/
function selectKtgDiv()
{
    global $conn;
    $getKtgDiv = "SELECT ktgdiv_id, ktgdiv_nama FROM tbl_ktgdiv WHERE ktgdiv_id >= '1' AND ktgdiv_id <= '2' ORDER BY ktgdiv_id ASC";
    $execKtgDiv = mysqli_query($conn, $getKtgDiv);
    ?>
    <option>- Kategori -</option>
    <?
    while($row = mysqli_fetch_array($execKtgDiv, MYSQLI_ASSOC))
    {
        ?>
            <option value="<? echo $row['ktgdiv_id'];?>"><? echo $row['ktgdiv_nama'];?></option>
        <?
    }
}

function selectKtgDivEdit($iddiv)
{
    global $conn;
    $getKtgDiv = "SELECT a.ktgdiv_id,a.ktgdiv_nama FROM tbl_ktgdiv a LEFT JOIN tbl_divisi b ON a.ktgdiv_id = b.ktgdiv_id WHERE b.div_id ='$iddiv'";
    $execKtgDiv = mysqli_query($conn, $getKtgDiv);
    while($row = mysqli_fetch_array($execKtgDiv, MYSQLI_ASSOC))
    {
        ?>
            <option value="<? echo $row['ktgdiv_id'];?>"><? echo $row['ktgdiv_nama'];?></option>
        <?
    }
}

function insertDiv($a,$b,$c)
{
    global $conn;
    $query ="INSERT INTO tbl_divisi(ktgdiv_id,div_nama,div_desc)VALUES('$a','$b','$c')";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Divisi baru berhasil ditambahkan";
    }
    echo msg($msg);
}

function updateDiv($a,$b,$divi)
{
    global $conn;
    $query ="UPDATE tbl_divisi SET div_nama='$a',div_desc='$b' WHERE div_id='$divi'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Divisi berhasil diupdate";
    }
    echo msg($msg);
}

function deleteDiv($divi)
{
    global $conn;
    $query ="DELETE FROM tbl_divisi WHERE div_id='$divi'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Divisi telah dihapus";
    }
    echo msg($msg);
}

function selectDiv()
{
    global $conn;
    $getDiv = "SELECT div_id, div_nama FROM tbl_divisi ORDER BY div_id ASC";
    $execDivisi = mysqli_query($conn, $getDiv);
    while($row = mysqli_fetch_array($execDivisi, MYSQLI_ASSOC))
    {
        ?>
            <option value="<? echo $row['div_id'];?>"><? echo $row['div_nama'];?></option>
        <?
    }
}

function DisplayDiv()
{
    global $conn;
    ?>
    <table id="divtab" class="table table-condensed table-striped" style="font-size:14px;" width="60%" cellspacing="0" cellpadding="0">
      <thead>    
          <tr align="Left">
              <th width="10">No.</th>
              <th>Kategori</th>
              <th>Divisi</th>
              <th>Deskripsi</th>
              <th style="text-align:center;">Aksi</th>
          </tr>
      </thead>
      <tbody>
    <?
      $getDivisi = "SELECT 
                      a.div_id,a.div_nama,a.div_desc, b.ktgdiv_nama 
                    FROM tbl_divisi a LEFT JOIN tbl_ktgdiv b ON a.ktgdiv_id = b.ktgdiv_id";
      $execDiv = mysqli_query($conn,$getDivisi);
      if (!$execDiv) 
      {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
      }
      $i=0;
      while($row=mysqli_fetch_array($execDiv,MYSQLI_ASSOC))
      {
          $i++;
          $divId = $row['div_id'];
          ?>
              <tr>
                  <td align="right"><? echo $i;?>.</td>
                  <td align="center"><? echo $row['ktgdiv_nama'];?></td>
                  <td><? echo $row['div_nama'];?></td>
                  <td><? echo $row['div_desc'];?></td>
                  <td align="center">
                      <a class="btn" data-toggle="modal" data-target="#editDiv<? echo $divId;?>"><span class="fa fa-pencil"></span></a>
                      <a class="btn" data-toggle="modal" data-target="#delDiv<? echo $divId;?>"><span class="fa fa-trash"></span></a>
                  </td>
              </tr>
              <? echo modalEditDiv($divId);?>
              <? echo modalDeleteDiv($divId);?>
          <?
      }
    ?>
      </tbody>
   </table>
  <?
}

function modalEditDiv($div)
{
    global $conn;
    ?>
        <div class="modal fade" id="editDiv<? echo $div;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3C8DBC;">
                    <h4 class="modal-title" style="color: white;"><b>EDIT DIVISI</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                </div>
                  <form id="div" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="divid" id="divid" value="<? echo $div;?>">
                    <?
                      $editDiv=mysqli_query($conn,"select * from tbl_divisi where div_id='".$div."'");
                      $drowDiv=mysqli_fetch_array($editDiv,MYSQLI_ASSOC);
                    ?>
                <div class="modal-body">
                  <div class="form-group" align="left">
                      <label for="DivisiKat" class="col-sm-2 control-label">Kategori</label> : &nbsp; 
                      <select class="form-control-sm" name="ktgDiv" disabled><? echo selectKtgDivEdit($div); ?></select>
                  </div>      
                  <div class="form-group" align="left">
                     <label for="DivisiNama" class="col-sm-2 control-label">Divisi</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="divNamaEdt" maxlength="40" size="40" placeholder="Nama Divisi" value="<?echo $drowDiv['div_nama']?>" required />
                  </div>
                  <div class="form-group" align="left">
                     <label for="DivisiDesc" class="col-sm-2 control-label">Deskripsi</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="divDescEdt" maxlength="40" size="40" placeholder="Deskripsi" value="<?echo $drowDiv['div_desc']?>" required/>  
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="updDiv" name="updDiv">Update</button>
                </div>
                </form>
          </div>
        </div>
    </div>
    <?
}

function modalDeleteDiv($div)
{
    global $conn;
    ?>
    <div class="modal fade" id="delDiv<? echo $div;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" id="myModalLabel">HAPUS DIVISI</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <input type="hidden" name="divid" id="divid" value="<? echo $div;?>">
                    <?
                      $delDiv=mysqli_query($conn,"select * from tbl_divisi where div_id='".$div."'");
                      $drowDiv=mysqli_fetch_array($delDiv,MYSQLI_ASSOC);
                    ?>
                  <div class="container-fluid">
                    <h5><center>Konfirmasi hapus divisi : <strong><?php echo $drowDiv['div_nama']; ?></strong> ?</center></h5> 
                  </div> 
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                  <button type="submit" class="btn btn-danger" id="delDiv" name="delDiv"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
              </div>
            </form>
          </div>
      </div>
    </div>
    <?
}



/*........................................................................FUNCTION UNTUK JABATAN............................................................................*/
function insertJab($a,$b)
{
    global $conn;
    $query ="INSERT INTO tbl_jabatan(jab_nama,jab_desc)VALUES('$a','$b')";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Jabatan baru berhasil ditambahkan";
    }
    echo msg($msg);
}

function updateJab($a,$b,$jab)
{
    global $conn;
    $query ="UPDATE tbl_jabatan SET jab_nama='$a',jab_desc='$b' WHERE jab_id='$jab'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Jabatan berhasil diupdate";
    }
    echo msg($msg);
}

function deleteJab($jab)
{
    global $conn;
    $query ="DELETE FROM tbl_jabatan WHERE jab_id='$jab'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE){
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else{
        $msg="Jabatan telah dihapus";
    }
    echo msg($msg);
}
function DisplayJab()
{
    global $conn;
    ?>
    <table id="jabtab" class="table table-condensed table-striped" style="font-size:14px;" width="60%" cellspacing="0" cellpadding="0">
      <thead>    
          <tr align="Left">
              <th width="10">No.</th>
              <th>Nama Jabatan</th>
              <th>Deskripsi</th>
              <th style="text-align:center;">Aksi</th>
          </tr>
      </thead>
      <tbody>
    <?
      $getJabatan = "SELECT * FROM tbl_jabatan ORDER BY jab_id";
      $execJab = mysqli_query($conn,$getJabatan);
      if (!$execJab) 
      {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
      }
      $i=0;
      while($row=mysqli_fetch_array($execJab,MYSQLI_ASSOC))
      {
          $i++;
          $jabId = $row['jab_id'];
          ?>
              <tr>
                  <td align="right"><? echo $i;?>.</td>
                  <td><? echo $row['jab_nama'];?></td>
                  <td><? echo $row['jab_desc'];?></td>
                  <td align="center">
                      <a class="btn" data-toggle="modal" data-target="#editJab<? echo $jabId;?>"><span class="fa fa-pencil"></span></a>
                      <a class="btn" data-toggle="modal" data-target="#delJab<? echo $jabId;?>"><span class="fa fa-trash"></span></a>
                  </td>
              </tr>
              <? echo modalEditJab($jabId);?>
              <? echo modalDeleteJab($jabId);?> 
          <?
      }
    ?>
      </tbody>
   </table>
  <?
}

function modalEditJab($jab)
{
    global $conn;
    ?>
        <div class="modal fade" id="editJab<? echo $jab;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3C8DBC;">
                    <h4 class="modal-title" style="color: white;"><b>EDIT JABATAN</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                </div>
                  <form id="jab" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="jabid" id="jabid" value="<? echo $jab;?>">
                    <?
                      $editJab=mysqli_query($conn,"select * from tbl_jabatan where jab_id='".$jab."'");
                      $drowJab=mysqli_fetch_array($editJab,MYSQLI_ASSOC);
                    ?>
                <div class="modal-body">    
                  <div class="form-group" align="left">
                     <label for="jabatanNama" class="col-sm-2 control-label">Jabatan</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="jabNamaEdt" maxlength="40" size="40" placeholder="Nama Jabatan" value="<?echo $drowJab['jab_nama']?>" required />
                  </div>
                  <div class="form-group" align="left">
                     <label for="jabatanDesc" class="col-sm-2 control-label">Deskripsi</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="jabDescEdt" maxlength="40" size="40" placeholder="Deskripsi" value="<?echo $drowJab['jab_desc']?>" required/>  
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="updJab" name="updJab">Update</button>
                </div>
                </form>
          </div>
        </div>
    </div>
    <?
}

function modalDeleteJab($jab)
{
    global $conn;
    ?>
    <div class="modal fade" id="delJab<? echo $jab;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" id="myModalLabel">HAPUS JABATAN</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <input type="hidden" name="jabid" id="jabid" value="<? echo $jab;?>">
                    <?
                      $delJab=mysqli_query($conn,"select * from tbl_jabatan where jab_id='".$jab."'");
                      $drowJab=mysqli_fetch_array($delJab,MYSQLI_ASSOC);
                    ?>
                  <div class="container-fluid">
                    <h5><center>Konfirmasi hapus jabatan: <strong><?php echo $drowJab['jab_nama']; ?></strong> ?</center></h5> 
                  </div> 
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                  <button type="submit" class="btn btn-danger" id="delJab" name="delJab"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
              </div>
            </form>
          </div>
      </div>
  </div>
  <?
}



/*..................................................FUNCTION UNTUK BIDANG............................................*/
function insertBid($a,$b)
{
    global $conn;
    $query ="INSERT INTO tbl_bidang(bid_nama,bid_desc)VALUES('$a','$b')";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Bidang baru berhasil ditambahkan";
    }
    echo msg($msg);
}

function updateBid($a,$b,$bid)
{
    global $conn;
    $query ="UPDATE tbl_bidang SET bid_nama='$a',bid_desc='$b' WHERE bid_id='$bid'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else
    {
        $msg="Bidang berhasil diupdate";
    }
    echo msg($msg);
}

function deleteBid($bid)
{
    global $conn;
    $query ="DELETE FROM tbl_bidang WHERE bid_id='$bid'";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE){
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
    }
    else{
        $msg="Bidang telah dihapus";
    }
    echo msg($msg);
}
function DisplayBid()
{
    global $conn;
    ?>
    <table id="bidtab" class="table table-condensed table-striped" style="font-size:14px;" width="60%" cellspacing="0" cellpadding="0">
      <thead>    
          <tr align="Left">
              <th width="10">No.</th>
              <th>Nama Bidang</th>
              <th>Deskripsi</th>
              <th style="text-align:center;">Aksi</th>
          </tr>
      </thead>
      <tbody>
    <?
      $getBidang = "SELECT * FROM tbl_bidang ORDER BY bid_id";
      $execBid = mysqli_query($conn,$getBidang);
      if (!$execBid) 
      {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
      }
      $i=0;
      while($row=mysqli_fetch_array($execBid,MYSQLI_ASSOC))
      {
          $i++;
          $bidId = $row['bid_id'];
          ?>
              <tr>
                  <td align="right"><? echo $i;?>.</td>
                  <td><? echo $row['bid_nama'];?></td>
                  <td><? echo $row['bid_desc'];?></td>
                  <td align="center">
                      <a class="btn" data-toggle="modal" data-target="#editBid<? echo $bidId;?>"><span class="fa fa-pencil"></span></a>
                      <a class="btn" data-toggle="modal" data-target="#delBid<? echo $bidId;?>"><span class="fa fa-trash"></span></a>
                  </td>
              </tr>
              <? echo modalEditBid($bidId);?>
              <? echo modalDeleteBid($bidId);?> 
          <?
      }
    ?>
      </tbody>
   </table>
  <?
}

function modalEditBid($bid)
{
    global $conn;
    ?>
        <div class="modal fade" id="editBid<? echo $bid;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3C8DBC;">
                    <h4 class="modal-title" style="color: white;"><b>EDIT BIDANG</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                </div>
                  <form id="bid" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="bidid" id="bidid" value="<? echo $bid;?>">
                    <?
                      $editbid=mysqli_query($conn,"select * from tbl_bidang where bid_id='".$bid."'");
                      $drowBid=mysqli_fetch_array($editbid,MYSQLI_ASSOC);
                    ?>
                <div class="modal-body">    
                  <div class="form-group" align="left">
                     <label for="bidangNama" class="col-sm-2 control-label">Bidang</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="bidNamaEdt" maxlength="40" size="40" placeholder="Nama Bidang" value="<?echo $drowBid['bid_nama']?>" required />
                  </div>
                  <div class="form-group" align="left">
                     <label for="bidangDesc" class="col-sm-2 control-label">Deskripsi</label> : &nbsp; 
                     <input type="text" class="form-control-sm" name="bidDescEdt" maxlength="40" size="40" placeholder="Deskripsi" value="<?echo $drowBid['bid_desc']?>" required/>  
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="updBid" name="updBid">Update</button>
                </div>
                </form>
          </div>
        </div>
    </div>
    <?
}

function modalDeleteBid($bid)
{
    global $conn;
    ?>
    <div class="modal fade" id="delBid<? echo $bid;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" id="myModalLabel">HAPUS BIDANG</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <input type="hidden" name="bidid" id="bidid" value="<? echo $bid;?>">
                    <?
                      $delBid=mysqli_query($conn,"select * from tbl_bidang where bid_id='".$bid."'");
                      $drowBid=mysqli_fetch_array($delBid,MYSQLI_ASSOC);
                    ?>
                  <div class="container-fluid">
                    <h5><center>Konfirmasi hapus bidang: <strong><?php echo $drowBid['bid_nama']; ?></strong> ?</center></h5> 
                  </div> 
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                  <button type="submit" class="btn btn-danger" id="delBid" name="delBid"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
              </div>
            </form>
          </div>
      </div>
  </div>
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