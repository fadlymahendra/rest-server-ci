<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Mahasiswa extends REST_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model('Mahasiswa_model', 'mhs');
   }

   // METHOD GET
   public function index_get() {
      $id = $this->get('id');
      if ($id === null) {
         $mahasiswa = $this->mhs->getMahasiswa();
      } else {
         $mahasiswa = $this->mhs->getMahasiswa($id);
      }
      
      if ($mahasiswa) {
         $this->response([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $mahasiswa
        ], REST_Controller::HTTP_OK);
      } else {
         $this->response([
            // 'status' => false,
            'message' => 'Data tidak ditemukan  ',
            'data' => $mahasiswa
        ], REST_Controller::HTTP_NOT_FOUND);
      }
   
   }

   // METHOD DELETE
   public function index_delete() {
      $id = $this->delete('id');

      if ($id === null) {
         $this->response([
            'status' => false,
            'message' => 'Masukkan ID yang benar',    
        ], REST_Controller::HTTP_BAD_REQUEST);
      } else {
         if ($this->mhs->deleteMahasiswa($id) > 0) {
            // OK
            $this->response([
               'id' => $id,
               'message' => 'Data sudah terhapus gaes'
           ], REST_Controller::HTTP_NO_CONTENT);
         } else {
            // ID not found
            $this->response([
               'status' => false,
               'message' => 'Masukkan ID yang benar yes',
           ], REST_Controller::HTTP_BAD_REQUEST);
         }
      }
   }

   // METHOD POST
   public function index_post() {
      $data = [
         'nrp' => $this->post('nrp'),
         'nama' => $this->post('nama'),
         'email' => $this->post('email'),
         'jurusan' => $this->post('jurusan')
      ];

      if ($this->mhs->postMahasiswa($data) > 0) {
         $this->response([
            'status' => true,
            'message' => 'Berhasil meanmbahkan Data'
        ], REST_Controller::HTTP_CREATED);
      } else {
         $this->response([
            'status' => false,
            'message' => 'Gagal dan  salah',
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
   }

   // METHOD PUT
   public function index_put() {
      $id = $this->put('id');
      $data = [
         'nrp' => $this->put('nrp'),
         'nama' => $this->put('nama'),
         'email' => $this->put('email'),
         'jurusan' => $this->put('jurusan')
      ];

      if ($this->mhs->putMahasiswa($data, $id) > 0) {
         $this->response([
            'status' => true,
            'message' => 'Berhasil mengubah Data'
        ], REST_Controller::HTTP_OK);
      } else {
         $this->response([
            'status' => false,
            'message' => 'Gagal dan salah',
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
   }
  
}