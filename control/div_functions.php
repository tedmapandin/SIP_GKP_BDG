<?
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
?>