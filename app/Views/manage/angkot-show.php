<?php $this->view("templates/header2") ?>

<div class="container mt-3">
   <a href="<?= BASEURL ?>/manage/angkot/add" class="btn btn-dark mb-3">Tambah</a>
   <table id="main-table" class="table table-bordered table-striped align-middle">
      <thead>
         <tr class="bg-dark text-white"><th colspan="10"><h2>Pangkalan</h2></th></tr>
         <tr class="table-warning">
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">ID Pangkalan</th>
            <th scope="col">Kode</th>
            <th scope="col">Warna</th>
            <th scope="col">Gambar</th>
            <th scope="col">Rute</th>
            <th scope="col">Rute Berangkat</th>
            <th scope="col">Rute Kembali</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <?php $i = 1 ?>
      <?php foreach ( $angkot as $angkt ) : ?>
      <tbody>
         <tr>
            <th scope="row"><?= $i ?></th>
            <td><?= $angkt['id'] ?></td>
            <td><?= $angkt['id_pangkalan'] ?></td>
            <td><?= $angkt['kode'] ?></td>
            <td><?= $angkt['warna'] ?></td>
            <td><?= $angkt['gambar'] ?></td>
            <td><?= $angkt['rute'] ?></td>
            <td><?= $angkt['rute_berangkat'] ?></td>
            <td><?= $angkt['rute_kembali'] ?></td>
            <td class="text-center">
               <div class="btn-group my-1">
                  <a href="<?= BASEURL ?>/manage/delete/angkot/<?= $angkt['id'] ?>" class="btn btn-danger" onclick="confirm('Hapus data?')">Hapus</a>
                  <a href="<?= BASEURL ?>/manage/angkot/<?= $angkt['id'] ?>" class="btn btn-warning">Edit</a>
               </div>
            </td>
         </tr>
      </tbody>
      <?php $i++ ?>
      <?php endforeach; ?>
   </table>
</div>

<?php $this->view("templates/footer") ?>