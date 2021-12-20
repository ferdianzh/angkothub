<?php $this->view("templates/header") ?>

<main class="container-fluid" style="height: 100vh; padding-top: 56px;">
    <div class="row h-100">

        <div class="col-3 px-0 shadow">
            <nav class="bg-light pt-3">
                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-rute" type="button" role="tab" aria-controls="nav-rute" aria-selected="true">Cari Rute</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-pangkalan" type="button" role="tab" aria-controls="nav-pangkalan" aria-selected="false">Pemberhentian</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-angkot" type="button" role="tab" aria-controls="nav-angkot" aria-selected="false">Angkot</button>
                </div>
            </nav>

            <div class="tab-content pt-4 px-3 bg-white" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-rute" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="mb-3">
                        <label for="awal" class="form-label">Posisi Awal</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="awal">
                            <button class="btn btn-dark" type="button" id="button-awal">Pilih</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="tujuan">
                            <button class="btn btn-dark" type="button" id="button-tujuan">Pilih</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="mt-2 btn bg-hub fw-bold text-white px-4">Mulai</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-pangkalan" role="tabpanel">
                    <div class="list-group" id="list-tab" role="tablist">
                    <?php foreach ( $pangkalan as $pangkal ) : ?>
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">
                            <h5><?= $pangkal['nama'] ?></h5>
                            <p>Tipe: <?php if($pangkal['tipe'] == '1') echo 'Pangkalan'; else echo 'Terminal'; ?></p>
                        </a>
                    <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="nav-angkot" role="tabpanel">
                    <div class="list-group" id="list-tab" role="tablist">
                    <?php for ( $i=0; $i<3; $i++ ) : ?>
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">
                            <div class="row">
                                <div class="col-4">Gambar</div>
                                <div class="col-8">
                                    <h5>Kode Angkot</h5>
                                    <p>Kode Rute</p>
                                </div>
                            </div>    
                        </a>
                    <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-9" id="map">
            <!-- map -->
        </div>
    </div>
</main>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin="">
</script>
<script src="<?= BASEURL ?>/js/leaflet/leaflet.base.js"></script>
<script>
    // map init
    var map = L.map('map').setView([-7.26811, 112.66676], 13);
    tiles.addTo(map);
    map.on('click', onMapClick);

    // marker pangkalan
    <?php foreach ( $pangkalan as $pangkal ) : ?>
    var marker = L.marker([
                        <?= $pangkal['kordinat_y'].', '.$pangkal['kordinat_x'] ?>
                    ]).addTo(map).bindPopup(
                        '<b><?= $pangkal['nama'] ?></b><hr/>Atur sebagai titik tujuan'
                    );
    <?php endforeach; ?>

    // line rute angkot
    <?php foreach ( $angkot as $angkt ) : ?>
    var pathLine = L.polyline([
        <?= '['.$angkt['rute_berangkat'].'],' ?>
    ]).addTo(map)
    <?php endforeach; ?>
</script>

<?php $this->view("templates/footer") ?>