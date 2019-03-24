<?
function modalViewLap($id) 
{
  global $conn;
  ?>
  <div class="modal fade" id="viewLaporan<? echo $id;?>" tabindex="-1" role="dialog">
    <form id="lap" class="form-horizontal" method="post" enctype="multipart/form-data">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #3C8DBC;">
                  <h4 class="modal-title" style="color: white;"><b>DETAIL TRANSAKSI</b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                   <?
                      $getdet_trans ="SELECT 
                                       a.*,
                                       b.*,
                                       c.*,
                                       (a.real_anggaran - a.real_keu) saldo
                                    FROM 
                                        tbl_realisasi a 
                                      LEFT JOIN tbl_divisi b ON a.div_id = b.div_id
                                      LEFT JOIN tbl_bidang c ON a.bid_id = c.bid_id
                                    WHERE a.trans_id = '$id' 
                                    ORDER BY a.bln_id DESC";
                      //echo $getdet_trans;
                      $execdet_trans = mysqli_query($conn, $getdet_trans);
                      $row_trans = mysqli_fetch_array($execdet_trans,MYSQLI_ASSOC);

                      $idDetKeg       = $row_trans['detkeg_id'];
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
                    <a class="nav-link" href="#vtranskeu<? echo $idDetKeg;?>" role="tab" data-toggle="tab">Pengeluaran</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <br/>
                    <!-- tab view kegiatan -->
                    <div role="tabpanel" class="tab-pane fade show active" id="vtranskeg<? echo $idDetKeg;?>">
                     
                        <div class="row">
                          <div class="col col-3 no-gutters">Nama Kegiatan</div>
                          <div class="col">: <? echo $row_trans['real_nama'] ;?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Jenis Kegiatan</div>
                          <div class="col">: <? echo $row_trans['real_jenis'];?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Tempat</div>
                          <div class="col">: <? echo $row_trans['real_tempt'];?></div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col col-2 no-gutters"><b>Uraian</b></div>
                        </div>
                        <div class="row" style="padding-left:15px; width: 100%;">
                          <span class="border border-secondary rounded col">
                            <div class="col" style="padding-left: 5px;"><pre><? echo  $row_trans['real_urai'];?></pre></div>
                          </span>
                        </div>
                        <div class="row">
                            <div class="col col-2 no-gutters"><b>Keterangan</b></div>
                        </div>
                        <div class="row" style="padding-left:15px; width: 100%;">
                            <span class="border border-secondary rounded col">
                              <div class="col" style="padding-left: 5px;"><pre><? echo $row_trans['real_ket'];?></pre></div>
                            </span>
                        </div>
                    </div>
                     <div role="tabpanel" class="tab-pane fade show active" id="vtranskeu<? echo $idDetKeg;?>">
                        <div class="row">
                          <div class="col col-3 no-gutters">Anggaran</div>
                          <div class="col">: Rp <? echo split2curr($row_trans['real_anggaran']);?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Total Pengeluaran</div>
                          <div class="col">: Rp <? echo split2curr($row_trans['real_keu']);?></div>
                        </div>
                        <div class="row">
                          <div class="col col-3 no-gutters" >Saldo</div>
                          <?if($row_trans['saldo'] > 0) { ?>
                          <div class="col" style="color: black;">: Rp <? echo split2curr($row_trans['saldo']);?></div>
                        <? } else if($row_trans['saldo'] <= 0) { ?>
                        <div class="col" style="color: red;">: Rp <? echo '('.split2curr($row_trans['saldo']).')';?></div>
                        <? } ?>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col col-3 no-gutters"><b>Uraian Pengeluaran</b></div>
                        </div>
                        <div class="row" style="padding-left:15px; width: 100%;">
                            <span class="border border-secondary rounded col">
                              <div class="col" style="padding-left: 5px;"><pre><? echo $row_trans['real_keu_urai'];?></pre></div>
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
