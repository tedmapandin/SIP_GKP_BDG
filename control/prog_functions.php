<?
/*.......................................FUNCTION PROGRAM.....................................................*/
function modalInputProg() 
{
  global $conn;
?>
<form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3C8DBC;">
                        <h4 class="modal-title" style="color: white;"><b>PROGRAM BARU</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                              <table cellpadding="0" cellspacing="0"width="100%">
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
                                    <td> <input type="text" name="keg_name" id="keg_name" class="form-control form-control-sm" id="keg_name" maxlength="30" size="30" placeholder="Nama Kegiatan"></td>
                                  </tr>
                                  <tr>
                                    <td width="120">Jenis Kegiatan </td>
                                    <td> <input type="text" name="keg_jenis" id="keg_jenis" class="form-control form-control-sm" id="keg_jenis" maxlength="200" size="50" placeholder="Jenis Kegiatan"></td>
                                  </tr>
                                  <tr>
                                    <td width="120">Tempat  </td>
                                    <td> <input type="text" name="tem_keg" id="tem_keg" class="form-control form-control-sm" id="tem_keg" placeholder="Tempat"></td>
                                  </tr>
                                  <tr>
                                    <td>Anggaran</td>
                                    <td align="right">Rp &nbsp; <input type="text" class="uang" name="nom_keu[]" align="right">
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
                                    <textarea name="urai_keg" id="urai_keg" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputUserName" class="col-sm-4 control-label">Keterangan</label>
                                <div class="col-sm-12">
                                    <textarea name="ket_keg" id="ket_keg" class="form-control"></textarea>
                                </div>
                            </div>  
                          </div>
                      </div>
                      <br/>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary btn-flat" id="saveLap" name="saveLap">Simpan</button>
                    </div>
            </div>
  </form>
<?
}

function modalDelProg()
{
global $conn;
?>
  <div class="modal fade" id="transDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" id="myModalLabel">Hapus Program</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <input type="hidden" name="transid" id="transid" value="<? echo $transId;?>">
                  <?php
                    $del=mysqli_query($conn,"select * from tbl_transaksi where trans_id='".$transId."'");
                    $drow=mysqli_fetch_array($del);
                  ?>
                    <div class="container-fluid">
                      <h5><center>Konfirmasi hapus Program ?</center></h5> 
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-danger" id="delUser" name="delTrans"><span class="glyphicon glyphicon-trash"></span> Hapus
                </div>
            </form>
          </div>
      </div>
  </div>
<?
}

function modalEditProg()
{
global $conn;
?>

<?
}

function modalViewProg()
{
global $conn;
?>
  <div class="modal fade" id="viewLaporan" tabindex="-1" role="dialog">
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
                                        e.detkeg_urai,
                                        e.detkeg_ket,
                                        e.detkeg_tgl,
                                        e.detkeg_tempat,
                                        e.detkeg_id
                                    FROM 
                                        tbl_transaksi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                      LEFT JOIN tbl_user d ON a.usr_id = d.usr_id
                                      LEFT JOIN tbl_detkeg e ON a.trans_id = e.trans_id
                                    WHERE a.trans_id = '$transId'
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
                          <div class="col col-2 no-gutters">Nama Kegiatan</div>
                          <div class="col">: <? echo $row_trans['detkeg_nama'];?></div>
                        </div>
                        <div class="row">
                          <div class="col col-2 no-gutters" >Tanggal</div>
                          <div class="col">: <? echo tgl_indo($row_trans['detkeg_tgl']);?></div>
                        </div>
                        <div class="row">
                          <div class="col col-2 no-gutters" >Tempat</div>
                          <div class="col">: <? echo $row_trans['detkeg_tempat'];?></div>
                        </div>
                        <br/>
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

                    <!-- tab view keuangan/pengeluaran -->
                    <div role="tabpanel" class="tab-pane show fade" id="vtranskeu<? echo $idDetKeg;?>">
                      <?
                        $get_keu = "SELECT detkeg_id, detkeu_desc, detkeu_tgl_trans, detkeu_nom FROM tbl_detkeu
                                    WHERE detkeg_id = '$idDetKeg'";
                        $exec_keu = mysqli_query($conn,$get_keu);
                        while($row_keu = mysqli_fetch_array($exec_keu,MYSQLI_ASSOC))
                        {
                      ?>
                          <div class="row">
                            <div class="col col-2 no-gutters">Biaya</div>
                            <div class="col">: <? echo $row_keu['detkeu_desc'];?></div>
                          </div>
                          <div class="row">
                            <div class="col col-2 no-gutters" >Tanggal</div>
                            <div class="col">: <? echo tgl_indo($row_keu['detkeu_tgl_trans']);?></div>
                          </div>
                          <div class="row">
                            <div class="col col-2 no-gutters" >Nominal</div>
                            <div class="col">: Rp. <? echo split2curr($row_keu['detkeu_nom']);?></div>
                          </div>
                      <?
                      }
                      ?>
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
?>