<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajarModel;
use \Hermawan\DataTables\DataTable;

class Pengajar extends BaseController
{
    public function index()
    {
        $data['sidebar'] = "pengajar";
        $data['title'] = "List Pengajar";

        return view('pages/pengajar', $data);
    }

    // Create Pengajar
    public function simpan()
    {
        // var_dump($this->generateNIPPengajar());
        // exit();
        $validasi  = \Config\Services::validation();
        $aturan = [
            'nama_pengajar' => [
                'label' => 'Nama Pengajar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            't4_lahir' => [
                'label' => 'Tempat Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'tgl_lahir' => [
                'label' => 'Tgl Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'tgl_masuk' => [
                'label' => 'Tgl Masuk',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'no_wa' => [
                'label' => 'No. Whatsapp',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ]
            // ,
            // 'gambar_sampul' => 'required|uploaded[file]|max_size[file,10240]|ext_in[png]'
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_pengajar = $this->request->getPost('id_pengajar');
            $nama_pengajar = $this->request->getPost('nama_pengajar');
            $alamat = $this->request->getPost('alamat');
            $t4_lahir = $this->request->getPost('t4_lahir');
            $tgl_lahir = $this->request->getPost('tgl_lahir');
            $tgl_masuk = $this->request->getPost('tgl_masuk');
            $no_wa = $this->request->getPost('no_wa');

            $data = [
                'nama_pengajar' => $nama_pengajar,
                'alamat' => $alamat,
                't4_lahir' => $t4_lahir,
                'tgl_lahir' => $tgl_lahir,
                'tgl_masuk' => $tgl_masuk,
                'no_wa' => $no_wa
            ];

            $model = new PengajarModel();

            $searchPengajar = $model->where(['hapus' => 0])->find($id_pengajar);
            if ($searchPengajar) {
                $model->update($id_pengajar, $data);
                $hasil['sukses'] = "Berhasil mengubah data";
                $hasil['error'] = true;
                $hasil['edit'] = true;
            } else {
                $data['nip'] = $this->generateNIPPengajar();
                $model->save($data);
                $hasil['sukses'] = "Berhasil memasukkan data";
                $hasil['error'] = true;
                $hasil['edit'] = false;
            }
        } else {
            $hasil['sukses'] = false;
            $hasil['error'] = $validasi->listErrors();
        }

        return json_encode($hasil);
    }

    // generate id pengajar 
    public function generateNIPPengajar()
    {
        $db = db_connect();
        $tahun = date("Y");

        $data = $db->query("SELECT * FROM pengajar WHERE YEAR(created_at) = $tahun ORDER BY id_pengajar DESC")->getRowArray();

        if ($data) {
            $id = $data['id_pengajar'] + 1;
        } else {
            $id = 1;
        }

        if ($id >= 1 && $id < 10) {
            $user = "P-" . date('ym') . "000" . $id;
        } else if ($id >= 10 && $id < 100) {
            $user = "P-" . date('ym') . "00" . $id;
        } else if ($id >= 100 && $id < 1000) {
            $user = "P-" . date('ym') . "0" . $id;
        } else {
            $user = "P-" . date('ym') . $id;
        }
        return $user;
    }

    // Get All Pengajar
    public function getListPengajar()
    {
        $db = db_connect();
        $builder = $db->table('pengajar')
            ->where(["hapus" => 0])
            ->select('id_pengajar, nip, nama_pengajar, no_wa, DATE_FORMAT(tgl_lahir, "%d%m%Y") as password, status');

        return DataTable::of($builder)->toJson(true);
    }

    // Get Pengajar
    public function getPengajar($id)
    {
        $model = new PengajarModel();
        $data = $model->where(['hapus' => 0])->find($id);
        return json_encode($data);
    }

    // hapus pengajar
    public function hapusPengajar($id_pengajar)
    {
        $db = db_connect();
        // cek apakah ada kelas pengajar
        $kelas = $db->query("SELECT * FROM kelas WHERE fk_id_pengajar = $id_pengajar AND hapus = 0")->getResultArray();

        $isDeleted = false;
        
        if(empty($kelas)){
            // delete 
            $model = new PengajarModel();
            $model->update($id_pengajar, ['hapus' => 1]);
            $isDeleted = true;
        } else {
            // do not delete 
            $isDeleted = false;
        }

        return json_encode($isDeleted);
    }

    // edit status pengajar
    public function editStatusPengajar()
    {
        $id_pengajar = $this->request->getPost('id_pengajar');
        $status = $this->request->getPost('status');
        $model = new PengajarModel();
        $model->update($id_pengajar, ['status' => $status]);
    }
}
