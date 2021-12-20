<?php

use Core\Controller;
use Functions\Geo;
use Functions\Session;
use Models\AngkotModel;
use Models\PangkalanModel;

class Manage extends Controller
{
   private $pangkalanModel;
   private $angkotModel;

   public function __construct()
   {
      $this->pangkalanModel = new PangkalanModel;
      $this->angkotModel = new AngkotModel;
   }

   public function index()
   {
      Session::setFlashdata('Manage');
      return $this->view("manage/index");
   }

   public function pangkalan($id = null)
   {
      Session::setFlashdata('Manage Pangkalan');

      if ( is_null($id) ) {
         $data = [
            'pangkalan' => $this->pangkalanModel
                           ->select('id, nama, tipe, X(kordinat) AS kordinat_x, Y(kordinat) AS kordinat_y')->get(),
         ];

         return $this->view("manage/pangkalan-show", $data);
      }

      if ( !is_numeric($id) ) {
         return $this->view("manage/pangkalan-add");
      }

      $data = [
         'pangkalan' => $this->pangkalanModel
                        ->select('id, nama, tipe, X(kordinat) AS kordinat_x, Y(kordinat) AS kordinat_y')
                        ->where('id', $id)->first(),
      ];

      return $this->view("manage/pangkalan-edit", $data);
   }

   public function angkot($id = null)
   {
      Session::setFlashdata('Manage Angkot');

      if ( is_null($id) ) {
         $data = [
            'angkot' => $this->angkotModel
                           ->select('id, id_pangkalan, kode, warna, gambar, rute, AsText(rute_berangkat) as rute_berangkat, AsText(rute_kembali) as rute_kembali')->get(),
         ];

         for ( $i=0; $i<count($data['angkot']); $i++ ) {
            $data['angkot'][$i]['rute_berangkat'] = Geo::lineToLeaflet($data['angkot'][$i]['rute_berangkat']);
            $data['angkot'][$i]['rute_kembali'] = Geo::lineToLeaflet($data['angkot'][$i]['rute_kembali']);
         }

         return $this->view("manage/angkot-show", $data);
      }

      if ( !is_numeric($id) ) {
         $data = [
            'pangkalan' => $this->pangkalanModel->select('id, nama')->get(),
         ];

         return $this->view("manage/angkot-add", $data);
      }

      $data = [
         'angkot' => $this->angkotModel
                        ->select('id, id_pangkalan, kode, warna, gambar, rute, AsText(rute_berangkat) as rute_berangkat, AsText(rute_kembali) as rute_kembali')
                        ->where('id', $id)->first(),
         'pangkalan' => $this->pangkalanModel->select('id, nama')->get(),
      ];

      $data['angkot']['rute_berangkat'] = Geo::lineToLeaflet($data['angkot']['rute_berangkat']);
      $data['angkot']['rute_kembali'] = Geo::lineToLeaflet($data['angkot']['rute_kembali']);

      return $this->view("manage/angkot-edit", $data);
   }

   public function save($table)
   {
      $data = $_POST;

      switch ($table) {
         case "pangkalan":
            $kordinat = explode(', ', $data['kordinat']);
            $this->pangkalanModel->insert([
               'nama' => $data['nama'],
               'tipe' => $data['tipe'],
            ]);
            $insertedId = $this->pangkalanModel->insertedId();
            $this->pangkalanModel->addGeoPoint('id', $insertedId, 'kordinat', [
               'x' => $kordinat[1],
               'y' => $kordinat[0],
            ]);
            $this->redirect('/manage/pangkalan');
            break;

         case "angkot":
            $this->angkotModel->insert([
               'id_pangkalan' => $data['id_pangkalan'],
               'kode' => $data['kode'],
               'warna' => $data['warna'],
               'rute' => $data['rute'],
            ]);
            $insertedId = $this->angkotModel->insertedId();
            $this->angkotModel->addGeoLine('id', $insertedId, [
               'rute_berangkat' => Geo::leafletToLine($data['rute_berangkat']),
               'rute_kembali' => Geo::leafletToLine($data['rute_kembali']),
            ]);
            $this->redirect('/manage/angkot');
            break;

         default:
            header("location:javascript://history.go(-1)");
      }
   }

   public function update($table, $id)
   {
      $newData = $_POST;

      switch ($table) {
         case "pangkalan":
            $kordinat = explode(', ', $newData['kordinat']);
            $this->pangkalanModel->update('id', $id, [
               'tipe' => $newData['tipe'],
               'nama' => $newData['nama'],
            ]);
            $this->pangkalanModel->addGeoPoint('id', $id, 'kordinat', [
               'x' => $kordinat[1],
               'y' => $kordinat[0],
            ]);

            $this->redirect('/manage/pangkalan');
            break;
         
         case "angkot":
            // $this->angkotModel->update('id', $id, [
            //    'id_pangkalan' => $newData['id_pangkalan'],
            //    'kode' => $newData['kode'],
            //    'warna' => $newData['warna'],
            //    'gambar' => $newData['gambar'],
            //    'rute' => $newData['rute'],
            // ]);
            $this->angkotModel->addGeoLine('id', $id, [
               'rute_berangkat' => Geo::leafletToLine($newData['rute_berangkat']),
               'rute_kembali' => Geo::leafletToLine($newData['rute_kembali']),
            ]);

            $this->redirect('/manage/angkot');
            break;
         
         default:
            header("location:javascript://history.go(-1)");
      }
   }

   public function delete($table, $id)
   {
      switch ($table) {
         case "pangkalan":
            $this->pangkalanModel->delete($id);
            $this->redirect('/manage/pangkalan');
            break;
         case "angkot":
            $this->angkotModel->delete($id);
            $this->redirect('/manage/angkot');
            break;
         default:
            Session::setFlashdata("data tidak ditemukan");
      }
   }
}