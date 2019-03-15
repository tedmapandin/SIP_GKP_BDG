<?
/*................................................FUNCTION UNTUK JABATAN.........................................*/
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
