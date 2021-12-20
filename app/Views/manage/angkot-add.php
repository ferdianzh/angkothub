<?php $this->view("templates/header2") ?>

<div class="container mt-3">
   <form class="row g-3" action="<?= BASEURL ?>/manage/save/angkot" method="post">
      <div class="col-4">
         <label for="id_pangkalan" class="form-label">Pangkalan</label>
         <select id="id_pangkalan" class="form-select" name="id_pangkalan">
            <?php foreach ( $pangkalan as $pangkal ) : ?>
            <option value="<?= $pangkal['id'] ?>"><?= $pangkal['nama'] ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="col-4">
         <label for="kode" class="form-label">Kode</label>
         <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Angkutan">
      </div>
      <div class="col-4">
         <label for="warna" class="form-label">Warna</label>
         <input type="text" class="form-control" id="warna" name="warna">
      </div>
      <div class="col-12">
         <label for="rute" class="form-label">Rute</label>
         <input type="text" class="form-control" id="rute" name="rute">
      </div>
      <div class="col-12">
         <label for="rute_berangkat" class="form-label">Line Rute Berangkat</label>
         <textarea class="form-control" name="rute_berangkat" id="rute_berangkat" rows="3" placeholder="Format: [y, x], [y, x],..."></textarea>
      </div>
      <div class="col-12">
         <label for="rute_kembali" class="form-label">Line Rute Kembali</label>
         <textarea class="form-control" name="rute_kembali" id="rute_kembali" rows="3"
         placeholder="Format: [y, x], [y, x],..."></textarea>
      </div>
      <div class="col-12">
         <button type="submit" class="btn btn-dark">Submit</button>
      </div>
   </form>
</div>

<?php $this->view("templates/footer") ?>