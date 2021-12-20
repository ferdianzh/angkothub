<?php

use Core\Controller;
use Functions\Geo;
use Functions\Session;
use Models\AngkotModel;
use Models\PangkalanModel;

class Home extends Controller
{
    protected $pangkalanModel;
    protected $angkotModel;

    public function __construct()
    {
        $this->pangkalanModel = new PangkalanModel;
        $this->angkotModel = new AngkotModel;
    }

    public function index()
    {
        $data = [
            'pangkalan' => $this->pangkalanModel
                           ->select('id, nama, tipe, X(kordinat) AS kordinat_x, Y(kordinat) AS kordinat_y')->get(),
            'angkot' => $this->angkotModel
                            ->select('id, id_pangkalan, kode, warna, rute, AsText(rute_berangkat) AS rute_berangkat, AsText(rute_kembali) AS rute_kembali')->get(),
        ];

        for ( $i=0; $i<count($data['angkot']); $i++ ) {
            $ruteBerangkat = $data['angkot'][$i]['rute_berangkat'];
            $data['angkot'][$i]['rute_berangkat'] = Geo::lineToLeaflet($ruteBerangkat);

            $ruteKembali = $data['angkot'][$i]['rute_kembali'];
            $data['angkot'][$i]['rute_kembali'] = Geo::lineToLeaflet($ruteKembali);
        }

        Session::setFlashdata('Home');
        return $this->view("home/index", $data);
    }
}