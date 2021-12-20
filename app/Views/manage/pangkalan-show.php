<?php $this->view("templates/header2") ?>

<div class="container mt-3">
   <a href="<?= BASEURL ?>/manage/pangkalan/add" class="btn btn-dark mb-3">Tambah</a>
   <table id="main-table" class="table table-bordered table-striped align-middle">
      <thead>
         <tr class="bg-dark text-white"><th colspan="7"><h2>Pangkalan</h2></th></tr>
         <tr class="table-warning">
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Tipe</th>
            <th scope="col">Kordinat X</th>
            <th scope="col">Kordinat Y</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <?php $i = 1 ?>
      <?php foreach ( $pangkalan as $pangkal ) : ?>
      <tbody>
         <tr>
            <th scope="row"><?= $i ?></th>
            <td><?= $pangkal['nama'] ?></td>
            <td><?= $pangkal['tipe'] ?></td>
            <td><?= $pangkal['kordinat_x'] ?></td>
            <td><?= $pangkal['kordinat_y'] ?></td>
            <td class="text-center">
               <div class="btn-group my-1">
                  <a href="<?= BASEURL ?>/manage/delete/pangkalan/<?= $pangkal['id'] ?>" class="btn btn-danger" onclick="confirm('Hapus data?')">Hapus</a>
                  <a href="<?= BASEURL ?>/manage/pangkalan/<?= $pangkal['id'] ?>" class="btn btn-warning">Edit</a>
               </div>
            </td>
         </tr>
      </tbody>
      <?php $i++ ?>
      <?php endforeach; ?>
   </table>
</div>

<?php $this->view("templates/footer") ?>