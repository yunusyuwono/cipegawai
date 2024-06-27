<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PegawaiController extends ResourceController
{
    protected $modelName = 'App\Models\Pegawai';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'message' => 'Sukses',
            'data_pegawai' => $this->model->orderBy('idpegawai','DESC')->findAll()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($idpegawai = null)
    {
        $data = [
            'message' => 'Sukses',
            'data_pegawai' => $this->model->find($idpegawai)
        ];

        if($data['data_pegawai']== null){
            return $this->failNotFound('Data pegawai tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'nama'      =>'required',
            'jabatan'   =>'required',
            'hp'        =>'required',
            'email'     =>'required|valid_email',
            'foto'      =>'uploaded[foto]|max_size[foto,300]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'password'  => 'required|min_length[8]',
        ]);

        if(!$rules){
            $response = ['message' => $this->validator->getErrors()];

            return $this->failValidationErrors($response);
        }

        $foto = $this->request->getFile('foto');
        $namafoto = $foto->getRandomName();
        $foto->move('foto', $namafoto);
        $this->model->insert([
            'nama'      => esc($this->request->getVar('nama')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'hp'        => esc($this->request->getVar('hp')),
            'email'     => esc($this->request->getVar('email')),
            'foto'      => $namafoto,
            'password'  => esc($this->request->getVar('password')),
        ]);
        
        $response = [
            'message' => 'Data pegawai berhasil ditambahkan',
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    
    public function update($idpegawai = null)
    {
        $rules = $this->validate([
            'nama'      =>'required',
            'jabatan'   =>'required',
            'hp'        =>'required',
            'email'     =>'required|valid_email',
            'foto'      =>'max_size[foto,300]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'password'  => 'required|min_length[8]',
        ]);

        if(!$rules){
            $response = ['message' => $this->validator->getErrors()];

            return $this->failValidationErrors($response);
        }

        $foto = $this->request->getFile('foto');
        if($foto){
            $namafoto = $foto->getRandomName();
            $foto->move('foto', $namafoto);
            $fotodb=$this->model->find($idpegawai);
            if($fotodb['foto'] == $this->request->getPost('fotolama'))
            {
                unlink('foto/'.$this->request->getPost('fotolama'));
            }
            
        }
        else
        {
            $namafoto = $this->request->getPost('fotolama');
        }
        $this->model->update($idpegawai,[
            'nama'      => esc($this->request->getVar('nama')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'hp'        => esc($this->request->getVar('hp')),
            'email'     => esc($this->request->getVar('email')),
            'foto'      => $namafoto,
            'password'  => esc($this->request->getVar('password')),
        ]);
        
        $response = [
            'message' => 'Data pegawai berhasil diubah',
        ];
        return $this->respond($response,200);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($idpegawai = null)
    {
        $this->model->delete($idpegawai);
        
        $response = [
            'message' => 'Data pegawai berhasil dihapus',
        ];
        return $this->respondDeleted($response);
    }
}