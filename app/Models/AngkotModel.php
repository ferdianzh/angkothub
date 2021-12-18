<?php

namespace Models;

use Core\Model;

class AngkotModel extends Model {
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'angkot';
        $this->field = ['id', 'id_pangkalan', 'kode', 'warna', 'gambar', 'rute', 'rute_berangkat', 'rute_kembali'];
    }
}