<?php
//mengecek apakah sedang melakukan submit atau tidak
define ('SITE_ROOT', realpath(dirname(__FILE__)));
if($_POST['image_form_submit'] == 1){
  
  //untuk menyimpan data gambar
  $images_arr = array();
  
  //looping data gambar
  foreach($_FILES['images']['name'] as $key=>$val){
    $image_name = $_FILES['images']['name'][$key]; //mengambil nama gambar
    $tmp_name   = $_FILES['images']['tmp_name'][$key]; //mengambil tpm/path
    $size     = $_FILES['images']['size'][$key]; //mengambil size atau aukuran gambar
    $type     = $_FILES['images']['type'][$key]; //mengambil type gambar
    $error    = $_FILES['images']['error'][$key]; //menggambil error gambil bila ada

    $target_dir = "data/"; // tempat menyimpan gambar yang telah di upload
    $target_file = $target_dir.$_FILES['images']['name'][$key]; //memanggil data di dalam tempat penyimpanan
    
    /*
    * mengecek apakah di dalam tempat pengimpanan sudah ada nama file yang sama
    * bila ada maka tidak akan di sempan kembali
    * bisa tidak maka akan di simpan
    */
    if(move_uploaded_file($_FILES['images']['tmp_name'][$key],SITE_ROOT.$target_file)){
      $images_arr[] = $target_file; //menyimpan gambar yang telah di simpan ke dalam array $images_array
    }
  }
  
  //Menampilkan data gambar yang telah tersimpan di folder "data"
      ?><table cellpadding="3" cellspacing="10">
        <tr><?
  if(!empty($images_arr))
  { 
    $count=0; ?>
    <div class="row">
    <?php foreach($images_arr as $image_src)
    { 
      $count++; ?>
          <td><img src="<?php echo $image_src; ?>" class="img-thumbnail" style="height: 100px;"></td>
      <!-- <div class="col-xs-2" style="margin-top: 15px;">
        <a href="javascript:void(0);">
          
        </a>
      </div> -->
    <?php 
    } ?>
    </div>
  <?php 
  }
  ?>
        </tr>
      </table>
      <?
}
?>