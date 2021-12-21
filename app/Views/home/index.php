<?php $this->view("templates/header") ?>

<main class="container-fluid overflow-hidden" style="height: 100vh; padding-top: 56px;">
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
                            <button class="btn btn-dark" type="button" id="button-awal">
                                <i class="fas fa-search-location"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="tujuan">
                            <button class="btn btn-dark" type="button" id="button-tujuan">
                                <i class="fas fa-search-location"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="mt-2 btn bg-hub fw-bold text-white px-4">Mulai</button>
                    </div>
                </div>

                <div class="tab-pane fade overflow-auto" id="nav-pangkalan" role="tabpanel" style="height: 500px;">
                    <div class="list-group" id="list-tab" role="tablist">
                    <?php foreach ( $pangkalan as $pangkal ) : ?>
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home" data-lat="<?= $pangkal['kordinat_y'] ?>" data-lng="<?= $pangkal['kordinat_x'] ?>" onclick="pangkalanBtnClick(this)">
                            <h5 class="mb-1"><?= $pangkal['nama'] ?></h5>
                            <p class="mb-1">Tipe: <?php if($pangkal['tipe'] == '1') echo 'Pangkalan'; else echo 'Terminal'; ?></p>
                        </a>
                    <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="tab-pane fade overflow-auto" id="nav-angkot" role="tabpanel" style="height: 500px;">
                    <div class="list-group" id="list-tab" role="tablist">
                    <?php foreach ( $angkot as $angkt ) : ?>
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">
                            <div class="row">
                                <!-- <div class="col-4">Gambar</div> -->
                                <div class="col">
                                    <h5 class="mb-1" style="color: <?= $angkt['warna'] ?>;"><?= $angkt['kode'] ?></h5>
                                    <p class="mb-1"><?= $angkt['rute'] ?></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
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
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="<?= BASEURL ?>/js/leaflet.awesome-markers.js"></script>
<script src="<?= BASEURL ?>/js/leaflet/leaflet.base.js"></script>
<script>
    // map init
    var map = L.map('map').locate({setView: true, maxZoom: 14});
    var currLat, currLng;
    var destLat, destLng;
    tiles.addTo(map);
    map.on('click', onMapClick);

    // marker user
    map.on('locationfound', function(e){
        var marker = L.marker([e.latitude, e.longitude], {icon: userMarker}).bindPopup('Your are here :)');
        map.addLayer(marker);

        currLat = e.latitude;
        currLng = e.longitude;
    })
    .on('locationerror', function(e){
        console.log(e);
        alert("Location access denied.");
    });
                    
    // marker pangkalan
    <?php foreach ( $pangkalan as $pangkal ) : ?>
    var marker = L.marker([
                        <?= $pangkal['kordinat_y'].', '.$pangkal['kordinat_x'] ?>
                    ], {icon: pangkalanMarker}).addTo(map).bindPopup(
                        '<b><?= $pangkal['nama'] ?></b><hr/>Atur sebagai titik tujuan'
                    );
    <?php endforeach; ?>

    // line rute angkot
    <?php foreach ( $angkot as $angkt ) : ?>
    var pathLine = L.polyline([
        <?= '['.$angkt['rute_berangkat'].'],' ?>
    ], {color: "<?= $angkt['warna'] ?>"}).addTo(map).bindPopup(
        '<b style="color: <?= $angkt['warna'] ?>">Rute <?= $angkt['kode'] ?></b><hr/>Atur sebagai titik tujuan'
    );
    <?php endforeach; ?>
    
    // auto routing
    var route = '';
    function pangkalanBtnClick(btn) {
        destLat = btn.dataset.lat;
        destLng = btn.dataset.lng;
        console.log(currLat+' '+currLng)
        console.log(destLat+' '+destLng)
        
        if (route != '') {
            map.removeControl(route);
        }

        route = L.Routing.control({
            waypoints: [
                L.latLng(currLat, currLng),
                L.latLng(destLat, destLng)
            ],
        }).addTo(map);
    }
</script>

<?php $this->view("templates/footer") ?>