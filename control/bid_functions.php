<?
/*................................................FUNCTION UNTUK BIDANG.........................................*/
function insertBid($a,$b)
{
    global $conn;
    $query ="INSERT INTO tbl_bidang(bid_nama,bid_desc)VALUES('$a','$b')";
    $exec = mysqli_query($conn,$query);
    if ($exec !== TRUE) 
    {
        $msg= "Error: " . $query . "<br>" . $conn->error;
        exit();
        echo msg_failed($msg);
    }
    else
    {
        $msg="Bidang baru berhasil ditambahkan";
        echo msg($msg);
    }
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