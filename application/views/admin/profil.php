<?php
$username = $this->session->userdata('username'); 
$query = $this->db->query("SELECT * FROM `user` WHERE `username` = '{$username}' ;");
?>
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-5 text-gray-800">Overview Data <?=$section?></h1>
<?=$this->session->flashdata('flash') ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
<div class="table">
        <table class="table table-bordered" width="500px" cellspacing="0">
          <thead>
            <tr>
              <th width="30px">No</th>
              <th>Keterangan</th>
              <th width="30px" class="text-center">Detail</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="center">1</td>
              <td>Nama Lengkap</td>
              <td><?php foreach ($query->result() as $user){ echo $user->nama; }?></td>
            </tr>
          </tbody>
        </table>
        <div class="btn btn-info ml-3 my-3">
                    <a href="<?= base_url('admin/profil/ubahprofil'); ?>" class="text text-white"><i class="fas fa-user-edit"></i> Ubah Profil</a>
                </div>

      </div>
    </div>
  </div>

</div>


                