<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\KelasMemberModel;
use \Hermawan\DataTables\DataTable;

class Kelas extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $data['sidebar'] = "kelas";

        $data['title'] = "List Kelas";
        
        $data['bulan'] = $db->query("SELECT * FROM config WHERE field = 'bulan'")->getRowArray();
        $data['tahun'] = $db->query("SELECT * FROM config WHERE field = 'tahun'")->getRowArray();

        if($data['bulan']['value'] == "" && $data['tahun']['value'] == ""){
            $data['description'] = "List Kelas Lembaga Anda Seluruh Periode";
        } else if($data['bulan']['value'] == "" && $data['tahun']['value'] != ""){
            $data['description'] = "List Kelas Lembaga Anda Periode " . $data['tahun']['value'];
        } else if($data['tahun']['value'] == "" && $data['bulan']['value'] != ""){
            $data['description'] = "List Kelas Lembaga Anda Periode " . bulanIndonesia($data['bulan']['value']) . "";
        } else {
            $data['description'] = "List Kelas Lembaga Anda Periode " . bulanIndonesia($data['bulan']['value']) . " " .$data['tahun']['value'];
        }


        return view('pages/kelas', $data);
    }

    // Get All Kelas
    public function getListKelas()
    {
        $db = db_connect();
        $data['bulan'] = $db->query("SELECT * FROM config WHERE field = 'bulan'")->getRowArray();
        $data['tahun'] = $db->query("SELECT * FROM config WHERE field = 'tahun'")->getRowArray();

        $bulan = $data['bulan']['value'];
        $tahun = $data['tahun']['value'];

        if($bulan == "" && $tahun == ""){
            $whereCondition = "kelas.hapus = 0";
        } else if($bulan == "" && $tahun != ""){
            $whereCondition = "((YEAR(tgl_mulai) = $tahun OR YEAR(tgl_selesai) = $tahun)) AND kelas.hapus = 0";
        } else if($tahun == "" && $bulan != ""){
            $whereCondition = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan)) AND kelas.hapus = 0";
        } else {
            $whereCondition = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan) AND (YEAR(tgl_mulai) = $tahun OR YEAR(tgl_selesai) = $tahun)) AND kelas.hapus = 0";
        }

        $builder = $db->table('kelas')
            ->where($whereCondition)
            ->select('id_kelas, nama_kelas, DATE_FORMAT(tgl_mulai, "%d-%M-%Y") as tgl_mulai, DATE_FORMAT(tgl_selesai, "%d-%M-%Y") as tgl_selesai, status, nama_program')
            ->select('(SELECT count(*) FROM kelas_member where kelas_member.fk_id_kelas = kelas.id_kelas AND hapus = 0) as peserta')
            ->select('(SELECT nama_pengajar FROM pengajar where id_pengajar = kelas.fk_id_pengajar) as nama_pengajar')
            ->join('program', 'kelas.fk_id_program = program.id_program');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $validasi  = \Config\Services::validation();
        $aturan = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tgl_mulai' => [
                'label' => 'Tgl Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'tgl_selesai' => [
                'label' => 'Tgl Selesai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'fk_id_program' => [
                'label' => 'Program',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'fk_id_pengajar' => [
                'label' => 'Pengajar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
            // ,
            // 'gambar_sampul' => 'required|uploaded[file]|max_size[file,10240]|ext_in[png]'
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_kelas = $this->request->getPost('id_kelas');
            $tgl_mulai = $this->request->getPost('tgl_mulai');
            $tgl_selesai = $this->request->getPost('tgl_selesai');
            $nama_kelas = $this->request->getPost('nama_kelas');
            $fk_id_program = $this->request->getPost('fk_id_program');
            $fk_id_pengajar = $this->request->getPost('fk_id_pengajar');

            $data = [
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'nama_kelas' => $nama_kelas,
                'fk_id_program' => $fk_id_program,
                'fk_id_pengajar' => $fk_id_pengajar
            ];

            $model = new KelasModel();

            $searchKelas = $model->where(['hapus' => 0])->find($id_kelas);
            if ($searchKelas) {
                $model->update($id_kelas, $data);
                $hasil['sukses'] = "Berhasil mengubah data";
                $hasil['error'] = true;
                $hasil['edit'] = true;
            } else {
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

    // Get Kelas
    public function getKelas($id)
    {
        $model = new KelasModel();
        $data = $model->where(['hapus' => 0])->find($id);
        return json_encode($data);
    }

    // hapus kelas
    public function hapusKelas($id_kelas)
    {
        $db = db_connect(); 
        // cek apakah ada member di kelas 
        $member = $db->query("SELECT * FROM kelas_member WHERE fk_id_kelas = $id_kelas AND hapus = 0")->getResultArray();

        $isDeleted = false;

        if(empty($member)){
            // delete 
            $model = new KelasModel();
            $model->update($id_kelas, ['hapus' => 1]);
            
            $db->query("UPDATE kelas_member SET hapus = 1 WHERE fk_id_kelas = $id_kelas");
            $isDeleted = true;
        } else {
            // do not delete 
            $isDeleted = false;
        }

        return json_encode($isDeleted);
    }

    // edit status kelas
    public function editStatusKelas()
    {
        $id_kelas = $this->request->getPost('id_kelas');
        $status = $this->request->getPost('status');
        $model = new KelasModel();
        $model->update($id_kelas, ['status' => $status]);
    }

    public function getMemberOfKelas($id_kelas)
    {
        // $model = new KelasMemberModel();
        // $model->where(['fk_id_kelas' => $id_kelas, 'hapus' => 0]);
        $db = db_connect();
        $builder = $db->query("SELECT id_kelas_member, nama_member FROM kelas_member as a JOIN member as b ON a.fk_id_member = b.id_member WHERE fk_id_kelas = $id_kelas AND a.hapus = 0 ORDER BY nama_member")->getResultArray();
        return json_encode($builder);
    }

    // hapus member kelas
    public function hapusMemberOfKelas($id_kelas_member)
    {
        $model = new KelasMemberModel();
        $model->update($id_kelas_member, ['hapus' => 1]);
    }

    public function getListKelasOption()
    {
        $db = db_connect();
        $builder = $db->query("SELECT id_kelas, nama_kelas, (SELECT COUNT(*) FROM kelas_member WHERE kelas_member.fk_id_kelas = kelas.id_kelas  AND hapus = 0) as peserta FROM kelas WHERE hapus = 0 AND status = 'aktif' ORDER BY nama_kelas")->getResultArray();
        return json_encode($builder);
    }

    public function changePeriode(){
        $bulan = $this->request->getPost("bulan");
        $tahun = $this->request->getPost("tahun");

        $db = db_connect();

        $db->query("UPDATE config SET value = '$bulan' WHERE field = 'bulan'");
        $db->query("UPDATE config SET value = '$tahun' WHERE field = 'tahun'");

        // return redirect()->to(base_url('/pengiriman/'));
        return redirect()->back();
    }
}
