<?php

use Core\Controller;
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

         return $this->view("manage/angkot-show", $data);
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
               'id' => $newData['id'],
               'tipe' => $newData['tipe'],
               'nama' => $newData['nama'],
            ]);
            $this->pangkalanModel->addGeoPoint('id', $id, 'kordinat', [
               'x' => $kordinat[1],
               'y' => $kordinat[0],
            ]);

            $this->redirect('/manage/pangkalan');
      }
   }

   public function delete($table, $id)
   {
      switch ($table) {
         case "pangkalan":
            $this->pangkalanModel->delete($id);
            break;
         case "angkot":
            $this->angkotModel->delete($id);
            break;
         default:
            Session::setFlashdata("data tidak ditemukan");
      }
      $this->redirect('/manage/pangkalan');
   }
}