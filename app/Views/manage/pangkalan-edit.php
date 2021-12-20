<?php $this->view("templates/header2") ?>

<div class="container mt-3">
   <form class="row g-3" action="<?= BASEURL ?>/manage/update/pangkalan/<?= $pangkalan['id'] ?>" method="POST">
      <div class="col-8">
         <label for="id" class="form-label">ID</label>
         <input type="text" class="form-control" id="id" name="id" placeholder="Kode ID" value="<?= $pangkalan['id'] ?>" disabled readonly>
      </div>
      <div class="col-md-4">
         <label for="tipe" class="form-label">Tipe</label>
         <select id="tipe" class="form-select" name="tipe">
            <option value="1" <?php if($pangkalan['tipe'] == 1) echo 'selected' ?>>Pangkalan</option>
            <option value="2" <?php if($pangkalan['tipe'] == 2) echo 'selected' ?>>Terminal</option>
         </select>
      </div>
      <div class="col-12">
         <label for="nama" class="form-label">Nama</label>
         <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pangkalan atau Terminal" value="<?= $pangkalan['nama'] ?>">
      </div>
      <div class="col-md-6">
         <label for="kordinat" class="form-label">Kordinat</label>
         <input type="text" class="form-control" id="kordinat" name="kordinat" value="<?= $pangkalan['kordinat_y'].', '.$pangkalan['kordinat_x'] ?>">
      </div>
      <div class="col-12">
         <button type="submit" class="btn btn-dark">Submit</button>
      </div>
   </form>
</div>

<?php $this->view("templates/footer") ?>