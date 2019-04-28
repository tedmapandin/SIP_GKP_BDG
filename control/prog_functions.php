<?
function modalInputProg() 
{
  global $conn;
  $user = $_SESSION['username'];
  $usr_id = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usr_id'";
  $login    = mysqli_query($conn,$get_user);
  $row = mysqli_fetch_array($login,MYSQLI_ASSOC);

  $role = $row['role_id'];
  $ktgdiv =$row['ktgdiv_id'];
  $bidang = $row['bid_id'];
  $divi = $row['div_id'];
  $id_usr = $row['usr_id'];
?>

<form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3C8DBC;">
                        <h4 class="modal-title" style="color: white;"><b>PROGRAM BARU</b></h4>
                        <? //echo "OK";?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                              <table cellpadding="0" cellspacing="0"width="100%">
                                <tr>
                                  <td>
                                      <? echo selectBid($bidang);?>
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
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" href="#vProg" role="tab" data-toggle="tab">Kegiatan</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#vProgDet" role="tab" data-toggle="tab">Uraian</a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="vProg"><br/>
                            <div class="form-group">
                              <div class="col-sm-12">
                                <table cellpadding="3" cellspacing="4" >
                                  <tr>
                                    <td width="120">Nama Kegiatan </td>
                                    <td> <input type="text" name="keg_name" id="keg_name" class="form-control form-control-sm" id="keg_name" maxlength="30" size="30" placeholder="Nama Kegiatan" required></td>
                                  </tr>
                                  <tr>
                                    <td width="120">Jenis Kegiatan </td>
                                    <td> <input type="text" name="jenis_keg" id="jenis_keg" class="form-control form-control-sm" id="jenis_keg" maxlength="200" size="50" placeholder="Jenis Kegiatan" required></td>
                                  </tr>
                                  <tr>
                                    <td width="120">Tempat  </td>
                                    <td> <input type="text" name="tem_keg" id="tem_keg" class="form-control form-control-sm" id="tem_keg" placeholder="Tempat" required></td>
                                  </tr>
                                  <tr>
                                    <td>Anggaran</td>
                                    <td align="right">Rp &nbsp; <input type="text" class="uang" name="nom_keu" align="right" required>
                                    </td>  
                                </tr>
                                </table> 
                              </div>  
                            </div>
                          </div>
                          <div role="tabpanel" class="tab-pane show fade" id="vProgDet">
                            <div class="form-group">
                                <label for="inputUserName" class="col-sm-4 control-label">Uraian</label>
                                <div class="col-sm-12">
                                    <textarea name="urai_keg" id="urai_keg" class="form-control" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputUserName" class="col-sm-4 control-label">Keterangan</label>
                                <div class="col-sm-12">
                                    <textarea name="ket_keg" id="ket_keg" class="form-control" required></textarea>
                                </div>
                            </div>  
                          </div>
                      </div>
                      <br/>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary btn-flat" id="saveProg" name="saveProg" >Simpan</button>
                    </div>
            </div>
</form>
<?
}

function modalEditProg($prog)
{
global $conn;
$user = $_SESSION['username'];
$usr_id = $_SESSION['usr_id'];
$get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usr_id'";
$login    = mysqli_query($conn,$get_user);
$row = mysqli_fetch_array($login,MYSQLI_ASSOC);

$role = $row['role_id'];
$ktgdiv =$row['ktgdiv_id'];
$bidang = $row['bid_id'];
$divi = $row['div_id'];
$id_usr = $row['usr_id'];
?>
  <div class="modal fade" id="editProgram<? echo $prog;?>" tabindex="-1" role="dialog">
    <form id="prog" class="form-horizontal" method="post" enctype="multipart/form-data">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" style="color: white;"><b>UBAH PROGRAM</b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                   <?
                      $getdet_trans ="SELECT 
                                        a.trans_id,
                                        a.trans_tgl,
                                        b.div_nama,
                                        c.bid_id,
                                        c.bid_nama,
                                        d.usr_nama,
                                        d.ktgdiv_id,
                                        e.bln_id,
                                        e.thn_desc,
                                        e.detkeg_nama,
                                        e.detkeg_jenis,
                                        e.detkeg_urai,
                                        e.detkeg_ket,
                                        e.detkeg_tempat,
                                        e.detkeg_id,
                                        f.detkeu_nom
                                    FROM 
                                        tbl_transaksi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                      LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                      LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                                      LEFT JOIN tbl_detkeu f ON e.detkeg_id = f.detkeg_id
                                    WHERE a.trans_id = '$prog'
                                    ORDER BY e.bln_id DESC, a.trans_tgl ASC";
                      //echo $getdet_trans;
                      $execdet_trans = mysqli_query($conn, $getdet_trans);
                      $row_trans = mysqli_fetch_array($execdet_trans,MYSQLI_ASSOC);

                      $idTrans      = $row_trans['trans_id'];
                      $idDetKeg     = $row_trans['detkeg_id'];
                      $bulan_det    = $row_trans['bln_id'];
                      $transBidId   = $row_trans['bid_id'];
                      $transYr      = $row_trans['thn_desc'];

                      $getdet_bln    = "SELECT * FROM tbl_bulan WHERE bln_id = '$bulan_det'";
                      $execdet_bln   = mysqli_query($conn,$getdet_bln);
                      $rowdet_bln    = mysqli_fetch_array($execdet_bln,MYSQLI_ASSOC);
                      $bln_det        = $rowdet_bln['bln_name'];
                    ?>
                  <input type="hidden" name="keg_id" value="<?echo $idDetKeg;?>">
                  <input type="hidden" name="progid" value="<?echo $idTrans;?>">
                  <div class="row" style="width: 100%;padding-left:15px;">
                      <div class="row" style="width: 100%;padding-left:15px;">
                        <div class="col col-2">Divisi</div>
                        <div>: <? echo $row_trans['div_nama'];?></div>
                        <div class="col"></div>
                        <div>Bulan</div>
                        <div class="col col-3">: 
                            <select class="form-control-sm" id="lapMonth" name="lapMonth">
                                <?php
                                  $get_bln = "SELECT * FROM tbl_bulan ORDER BY bln_id";
                                  $query = mysqli_query($conn,$get_bln);
                                  while ($row = mysqli_fetch_array($query)) 
                                  {
                                    $blnId = $row['bln_id'];
                                  ?>
                                      <option value="<?php echo $row['bln_id']; ?>" <?if($row['bln_id'] == $bulan_det ) { echo "selected";}?>>
                                          <?php echo $row['bln_name']; ?>
                                      </option>
                                  <?php
                                  }
                                  ?>
                              </select>
                        </div>
                      </div>
                      <div class="row" style="width: 100%;padding-left:15px;">
                        <div class="col col-2">Bidang</div>
                        <div>:
                              <select class="form-control-sm" id="filterBid" name="filterBid">
                                  <option value="">- Bidang  -</option>
                                  <?php
                                  $get_bid = "SELECT * FROM tbl_bidang ORDER BY bid_id";
                                  $query = mysqli_query($conn,$get_bid);
                                  while ($row = mysqli_fetch_array($query)) 
                                  {
                                    $bidId = $row['bid_id'];
                                  ?>
                                      <option value="<?php echo $bidId; ?>" <?if($transBidId == $bidId ){ echo "selected"; }?>>
                                          <?php echo $row['bid_nama']; ?>
                                      </option>
                                  <?php
                                  }
                                  ?>
                              </select>
                        </div>
                        <div class="col"></div>
                        <div>Tahun</div>
                        <div class="col col-3">: 
                          <select class="form-control-sm" id="lapYear" name="lapYear">
                            <?php
                              $get_thn = "SELECT * FROM tbl_tahun ORDER BY thn_id";
                              $query = mysqli_query($conn,$get_thn);
                              while ($row = mysqli_fetch_array($query)) 
                              {
                              ?>
                                  <option value="<?php echo $row['thn_desc']; ?>" <?if($row['thn_desc'] == $transYr) { echo "selected";}?>>
                                      <?php echo $row['thn_desc']; ?>
                                  </option>
                              <?php
                              }
                              ?>
                          </select></div>
                      </div>
                  </div>
                  <br/>
                  <!-- TAB VIEW -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="#editProgDet<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#editProgKet<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Uraian</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <br/>
                    <!-- tab view kegiatan -->
                    <div role="tabpanel" class="tab-pane fade show active" id="editProgDet<? echo $idDetKeg;?>">
                     
                        <div class="row" style="padding-left:15px; width: 100%; padding-bottom: 0.5%;">
                          <div class="col col-3">Nama Kegiatan</div>
                          <div>: &nbsp;</div> 
                          <div><input type="text" name="keg_name" id="keg_name" class="form-control form-control-sm" required value="<? echo $row_trans['detkeg_nama'];?>"></div>
                        </div>
                         <div class="row" style="padding-left:15px; width: 100%; padding-bottom: 0.5%;">
                          <div class="col col-3">Jenis Kegiatan</div>
                          <div>: &nbsp;</div> 
                          <div><input type="text" name="jenis_keg" id="jenis_keg" class="form-control form-control-sm" required value="<? echo $row_trans['detkeg_jenis'];?>"></div>
                        </div>
                        <div class="row" style="padding-left:15px; width: 100%; padding-bottom: 0.5%;">
                          <div class="col col-3">Tempat</div>
                          <div>: &nbsp;</div> 
                          <div><input type="text" name="tem_keg" id="tem_keg" class="form-control form-control-sm" required value="<? echo $row_trans['detkeg_tempat'];?>"></div>
                        </div>
                        <div class="row" style="padding-left:15px; width: 100%; padding-bottom: 0.5%;">
                          <div class="col col-3">Anggaran</div>
                          <div>: &nbsp;</div> 
                          <div> <input type="text" name="nom_keu" id="nom_keu" class="form-control form-control-sm" required value="<? echo $row_trans['detkeu_nom'];?>" style="text-align: "></div>
                        </div>
                        <br/>
                        
                    </div>

                    <!-- tab view keuangan/pengeluaran -->
                    <div role="tabpanel" class="tab-pane show fade" id="editProgKet<? echo $idDetKeg;?>">
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Uraian</label>
                            <div class="col-sm-12">
                                <textarea name="urai_keg" id="urai_keg" class="form-control" rows="5" required><? echo $row_trans['detkeg_urai'];?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea name="ket_keg" id="ket_keg" class="form-control" required><? echo $row_trans['detkeg_ket'];?></textarea>
                            </div>
                        </div> 
                    </div>
                  </div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <? if($ktgdiv == "1" || $role == "1")
                {
                  ?>
                    <button type="submit" class="btn btn-info btn-flat" id="aprvProg" name="aprvProg" onclick="return confirm('Program disetujui ?')">Setuju</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="rejProg" name="rejProg">Tolak</button>
                  <?
                } else {
                  ?>
                    <button type="submit" class="btn btn-primary btn-flat" id="editProg" name="editProg">Simpan</button>
                  <?
                }
                ?>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
<?
}

function modalViewProg($prog)
{
global $conn;
?>
  <div class="modal fade" id="viewProgram<? echo $prog;?>" tabindex="-1" role="dialog">
    <form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" style="color: white;"><b>DETAIL PROGRAM</b></h4>
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
                                        e.detkeg_jenis,
                                        e.detkeg_urai,
                                        e.detkeg_ket,
                                        e.detkeg_tempat,
                                        e.detkeg_id,
                                        f.detkeu_nom
                                    FROM 
                                        tbl_transaksi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                      LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                      LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                                      LEFT JOIN tbl_detkeu f ON e.detkeg_id = f.detkeg_id
                                    WHERE a.trans_id = '$prog'
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
                      <a class="nav-link" href="#vtranskeu<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Uraian</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <br/>
                    <!-- tab view kegiatan -->
                    <div role="tabpanel" class="tab-pane fade show active" id="vtranskeg<? echo $idDetKeg;?>">
                     
                        <div class="row">
                          <div class="col col-3 no-gutters">Nama Kegiatan</div>
                          <div class="col">: <? echo $row_trans['detkeg_nama'];?></div>
                        </div>
                         <div class="row">
                          <div class="col col-3 no-gutters">Jenis Kegiatan</div>
                          <div class="col">: <? echo $row_trans['detkeg_jenis'];?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Tempat</div>
                          <div class="col">: <? echo $row_trans['detkeg_tempat'];?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Anggaran</div>
                          <div class="col">: Rp. <? echo split2curr($row_trans['detkeu_nom']);?></div>
                        </div>
                        <br/>
                        
                    </div>

                    <!-- tab view keuangan/pengeluaran -->
                    <div role="tabpanel" class="tab-pane show fade" id="vtranskeu<? echo $idDetKeg;?>">
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
<?
}

function modalDelProg($prog)
{
global $conn;
?>
  <div class="modal fade" id="delProgram<? echo $prog;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" id="myModalLabel">Hapus Program</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <input type="hidden" name="progid" id="progid" value="<? echo $prog;?>">
                  <?php
                    $getProg = "select * from tbl_transaksi where trans_id='$prog'";
                    //echo $getProg;
                    $del=mysqli_query($conn,$getProg);
                    $drow=mysqli_fetch_array($del);
                  ?>
                    <div class="container-fluid">
                      <h5><center>Konfirmasi hapus Program ?</center></h5> 
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-danger" id="delProg" name="delProg"><span class="glyphicon glyphicon-trash"></span> Hapus
                </div>
            </form>
          </div>
      </div>
  </div>
<?
}

function displayMJ_view()
{
  global $conn;
  $user = $_SESSION['username'];
  $usr_id = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usr_id'";
  $login    = mysqli_query($conn,$get_user);
  $row = mysqli_fetch_array($login,MYSQLI_ASSOC);

  $role = $row['role_id'];
  $ktgdiv =$row['ktgdiv_id'];
  $bidang = $row['bid_id'];
  $divi = $row['div_id'];
  $id_usr = $row['usr_id'];
  ?>
            <div align="center"><h4><strong>RENCANA PROGRAM KOMISI</strong></h4></div>
            <div class="box-body">
              <table id="laptab" class="table table-sm table-striped" style="font-size:12px;">
                <thead>    
                <tr align="center">
                    <th width="10">No.</th>
                    <th>Divisi</th>
                    <th>Bidang</th>
                    <th>Kegiatan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>User</th>
                    <th>Tanggal Buat</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                        $i= 0;
                        if(!empty($_POST['filterDiv']))
                        {
                          $div = $_POST['filterDiv'];
                          $qryDiv = " AND a.div_id = '$div'";
                        } else {
                           $qryDiv = "";
                        }
                        if(!empty($_POST['filterMonth'])){
                          $Month = $_POST['filterMonth'];
                          $qryMonth = " AND e.bln_id = '$Month'";
                        } else {
                           $qryMonth = "";
                        }
                        if(!empty($_POST['filterYear'])){
                          $Year = $_POST['filterYear'];
                          $qryYear = " AND e.thn_desc = '$Year'";
                        } else {
                           $qryYear = "";
                        }
                        $get_trans = "SELECT 
                                        a.trans_id,
                                        a.trans_tgl,
                                        b.div_nama,
                                        c.bid_nama,
                                        d.usr_nama,
                                        e.bln_id,
                                        e.thn_desc,
                                        e.detkeg_nama,
                                        a.trans_stat
                                    FROM 
                                        tbl_transaksi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                      LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                      LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id 
                                      WHERE 1=1 $qryDiv $qryMonth $qryYear AND trans_stat <> '9'
                                      ORDER BY e.bln_id DESC, a.trans_tgl ASC"; 
                        //echo $get_trans;
                        $exec_trans = mysqli_query($conn,$get_trans);
                        if(mysqli_num_rows($exec_trans) > 0) 
                        {
                            while($row=mysqli_fetch_array($exec_trans,MYSQLI_ASSOC))
                            {
                                
                                $i++;
                                $progId    = $row['trans_id'];
                                $transStat = $row['trans_stat'];
                                //echo $progId;
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
                                    <td><?php echo $row['detkeg_nama'];?></td>
                                    <td align="center"><?php echo $bln;?></td>
                                    <td align="center"><?php echo $thn;?></td>
                                    <td align="right"><?php echo $row['usr_nama']?></td>
                                    <td align="center"><?php echo date_format($tgl_keg,"Y/m/d");?></td>
                                    <td style="text-align:right;">
                                        <input type="hidden" name="progid" id="progid" value="<? echo $progId;?>">
                                        <?if($ktgdiv == "1") 
                                        { 
                                            if($transStat == "1") 
                                            { 
                                              ?>
                                                <a class="btn" data-toggle="modal" data-target="#editProgram<? echo $progId;?>"><span class="badge badge-info">review</span></a>
                                              <? 
                                            } 
                                            else if ($transStat == "3")
                                            { 
                                            ?>
                                                <a class="btn" data-toggle="modal" data-target="#viewProgram<? echo $progId;?>"><span class="badge badge-success">disetujui</span>
                                            <?
                                            }
                                             else if ($transStat == "4")
                                            { 
                                            ?>
                                                <a class="btn" data-toggle="modal" data-target="#viewProgram<? echo $progId;?>"><span class="badge badge-danger">ditolak</span>
                                            <?
                                            } 
                                        } 
                                        ?>
                                        <!-- <a class="btn" data-toggle="modal" data-target="#delProgram<? //echo $progId;?>"><span class="fa fa-trash"></span></a> -->
                                        <a class="btn" href="<? refresh();?>"><span class="fa fa-refresh"></span></a>
                                    </td>
                                </tr>                                
                              <?  
                                echo modalViewProg($progId);
                                echo modalEditProg($progId);
                                echo modalDelProg($progId);
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
function displayView()
{
  global $conn;
  $user = $_SESSION['username'];
  $usr_id = $_SESSION['usr_id'];
  $get_user   = "SELECT * FROM tbl_user where usr_nama='$user' AND usr_id = '$usr_id'";
  $login    = mysqli_query($conn,$get_user);
  $row = mysqli_fetch_array($login,MYSQLI_ASSOC);

  $role = $row['role_id'];
  $ktgdiv =$row['ktgdiv_id'];
  $bidang = $row['bid_id'];
  $divi = $row['div_id'];
  $id_usr = $row['usr_id'];
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
?>
  <div align="center"><h4><strong>RENCANA PROGRAM</strong></h4></div>
  <div class="box-body">
    <table id="laptab" class="table table-sm table-striped" style="font-size:12px;">
      <thead>    
      <tr align="center">
          <th width="10">No.</th>
          <th>Bidang</th>
          <th>Kegiatan</th>
          <th>Bulan</th>
          <th>Tahun</th>
          <th>User</th>
          <th>Tanggal Buat</th>
          <th style="text-align:center;">Aksi</th>
      </tr>
      </thead>
      <tbody>
        <?php
              $i= 0;
              if(!empty($_POST['filterMonth'])){
                $Month = $_POST['filterMonth'];
                $qryMonth = " AND e.bln_id = '$Month'";
              } else {
                 $qryMonth = "";
              }
              if(!empty($_POST['filterYear'])){
                $Year = $_POST['filterYear'];
                $qryYear = " AND e.bln_id = '$Year'";
              } else {
                 $qryYear = "";
              }
              $get_trans = "SELECT 
                              a.trans_id,
                              a.trans_tgl,
                              b.div_nama,
                              c.bid_nama,
                              d.usr_nama,
                              e.bln_id,
                              e.thn_desc,
                              e.detkeg_nama,
                              a.trans_stat
                          FROM 
                              tbl_transaksi a 
                            LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                            LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                            LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                            LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                            $filt $qryMonth $qryYear AND trans_stat <> '9'
                            ORDER BY e.bln_id DESC, a.trans_tgl ASC"; 
              //echo $get_trans;
              $exec_trans = mysqli_query($conn,$get_trans);
              if(mysqli_num_rows($exec_trans) > 0) 
              {
                  while($row=mysqli_fetch_array($exec_trans,MYSQLI_ASSOC))
                  {
                      
                      $i++;
                      $progId    = $row['trans_id'];
                      $transStat = $row['trans_stat'];
                      //echo $progId;
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
                      
                      //echo $progId;
                      ?>
                      <tr>
                          <td><?php echo $i;?>.</td>
                          <td><?php echo $row['bid_nama'];?></td>
                          <td><?php echo $row['detkeg_nama'];?></td>
                          <td align="center"><?php echo $bln;?></td>
                          <td align="center"><?php echo $thn;?></td>
                          <td align="right"><?php echo $row['usr_nama']?></td>
                          <td align="center"><?php echo date_format($tgl_keg,"Y/m/d");?></td>
                          <td style="text-align:right;">
                              <input type="hidden" name="progid" id="progid" value="<? echo $progId;?>">
                              <?
                                  if($transStat == "1") 
                                  { 
                                    ?>
                                      <a class="btn" data-toggle="modal" data-target="#viewProgram<? echo $progId;?>"><span class="badge badge-info">review</span>
                                    <? 
                                  } 
                                  else if ($transStat == "3")
                                  { 
                                  ?>
                                      <a class="btn" data-toggle="modal" data-target="#viewProgram<? echo $progId;?>"><span class="badge badge-success">disetujui</span>
                                  <?
                                  }
                                   else if ($transStat == "4")
                                  { 
                                  ?>
                                      <a class="btn" data-toggle="modal" data-target="#viewProgram<? echo $progId;?>"><span class="badge badge-danger">ditolak</span>
                                  <?
                                  }
                               ?>
                              <a class="btn" data-toggle="modal" data-target="#delProgram<? echo $progId;?>"><span class="fa fa-trash"></span></a>
                              <a class="btn" href="<? refresh();?>"><span class="fa fa-refresh"></span></a>
                          </td>
                      </tr>                                
                    <?  
                      echo modalViewProg($progId);
                      echo modalEditProg($progId);
                      echo modalDelProg($progId);
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