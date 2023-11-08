<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\KelasMemberModel;
use App\Models\SubscriptionMemberModel;
use \Hermawan\DataTables\DataTable;

class Member extends BaseController
{
    public function index()
    {
        $data['sidebar'] = "member";
        $data['collapse'] = "member";
        $data['collapseItem'] = 'listMember';
        $data['title'] = "List Member";

        return view('pages/member/member', $data);
    }

    public function subscription()
    {
        $data['sidebar'] = "member";
        $data['collapse'] = "member";
        $data['collapseItem'] = 'memberSubscription';
        $data['title'] = "List Member Subscription";

        return view('pages/member/subscription', $data);
    }

    public function kelas()
    {
        $data['sidebar'] = "member";
        $data['collapse'] = "member";
        $data['collapseItem'] = 'memberKelas';
        $data['title'] = "List Member Kelas";

        return view('pages/member/member_kelas', $data);
    }

    public function list($status)
    {
        $data['sidebar'] = "member";
        $data['status'] = $status;

        if ($status == 'aktif' || $status == 'nonaktif') {
            if ($status == 'aktif') {
                $data['title'] = "Member Aktif";
            } else if ($status == 'nonaktif') {
                $data['title'] = "Member Nonaktif";
            }

            return view('pages/member', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    // Create Member
    public function simpan()
    {
        $validasi  = \Config\Services::validation();
        $aturan = [
            'nama_member' => [
                'label' => 'Nama Member',
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
            $id_member = $this->request->getPost('id_member');
            $nama_member = $this->request->getPost('nama_member');
            $alamat = $this->request->getPost('alamat');
            $t4_lahir = $this->request->getPost('t4_lahir');
            $tgl_lahir = $this->request->getPost('tgl_lahir');
            $no_wa = $this->request->getPost('no_wa');

            $data = [
                'nama_member' => $nama_member,
                'alamat' => $alamat,
                't4_lahir' => $t4_lahir,
                'tgl_lahir' => $tgl_lahir,
                'no_wa' => $no_wa
            ];

            $model = new MemberModel();

            $searchMember = $model->where(['hapus' => 0])->find($id_member);
            if ($searchMember) {
                $model->update($id_member, $data);
                $hasil['sukses'] = "Berhasil mengubah data";
                $hasil['error'] = true;
                $hasil['edit'] = true;
            } else {
                $data['nim'] = $this->generateNimMember();
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

    // generate id member 
    public function generateNimMember()
    {
        $tahun = date("Y");

        $model = new MemberModel();
        $data = $model->where("YEAR(created_at) = $tahun")->orderBy("id_member", "DESC")->first();

        if ($data) {
            $id = $data['id_member'] + 1;
        } else {
            $id = 1;
        }

        if ($id >= 1 && $id < 10) {
            $user = date('ym') . "000" . $id;
        } else if ($id >= 10 && $id < 100) {
            $user = date('ym') . "00" . $id;
        } else if ($id >= 100 && $id < 1000) {
            $user = date('ym') . "0" . $id;
        } else {
            $user = date('ym') . $id;
        }
        return $user;
    }

    // Get All Member
    public function getListMember()
    {
        $db = db_connect();
        $builder = $db->table('member')
            ->where(["hapus" => 0])
            ->select('id_member, nim, nama_member, no_wa, DATE_FORMAT(tgl_lahir, "%d%m%Y") as password, status')
            ->select('(SELECT count(*) FROM kelas_member where kelas_member.fk_id_member = member.id_member AND hapus = 0) as kelas')
            ->select('(SELECT count(*) FROM subscription_member where subscription_member.fk_id_member = member.id_member AND hapus = 0) as subscription');

        return DataTable::of($builder)->toJson(true);
    }

    // Get All Member Subscription
    public function getListMemberSubscription()
    {
        $db = db_connect();
        $builder = $db->table('member')
            ->select('id_subscription_member, member.id_member, nim, nama_member, nama_program, tgl_mulai, tgl_berakhir')
            ->join('subscription_member', 'member.id_member = subscription_member.fk_id_member')
            ->join('program', 'subscription_member.fk_id_program = program.id_program')
            ->where('subscription_member.hapus = 0 AND member.hapus = 0');

        return DataTable::of($builder)->toJson(true);
    }

    public function getListMemberKelas()
    {
        $db = db_connect();
        $builder = $db->table('member')
            ->select('id_kelas_member, member.id_member, nim, nama_member, nama_kelas, tgl_mulai, tgl_selesai')
            ->join('kelas_member', 'member.id_member = kelas_member.fk_id_member')
            ->join('kelas', 'kelas_member.fk_id_kelas = kelas.id_kelas')
            ->where('kelas_member.hapus = 0 AND member.hapus = 0');

        return DataTable::of($builder)->toJson(true);
    }

    // Get All Subscritption / 
    // public function getMemberList($tipe)
    // {
    //     // member kelas 
    //     // Nama Member | Kelas | Tgl Mulai | Tgl Selesai | Sertifikat |
    //     // Member Subscription
    //     // Nama Member | Program | Tgl Mulai | Tgl Berakhir | Sertifikat |
    //     $db = db_connect();
    //     if($tipe == 'kelas'){
    //         $builder = $db->table('kelas_member')
    //             ->where(["hapus" => 0])
    //             ->select('id_member, nim, nama_member, no_wa, DATE_FORMAT(tgl_lahir, "%d%m%Y") as password, status')
    //             ->select('(SELECT count(*) FROM kelas_member where kelas_member.fk_id_member = member.id_member AND hapus = 0) as kelas');
    //     } else if($tipe == 'subsripction'){

    //     }

    //     return DataTable::of($builder)->toJson(true);
    // }

    // Get Member
    public function getMember($id)
    {
        $model = new MemberModel();
        $data = $model->where(['hapus' => 0])->find($id);
        return json_encode($data);
    }

    // Get Member
    public function getSubscriptionMember($id)
    {
        $db = db_connect();

        $data = $db->query("SELECT a.*, b.nama_member FROM subscription_member as a JOIN member as b ON a.fk_id_member = b.id_member AND a.hapus = 0 AND id_subscription_member = $id")->getRowArray();

        return json_encode($data);
    }

    // hapus member
    public function hapusMember($id_member)
    {
        $db = db_connect();
        // cek apakah ada kelas member atau subscription member 
        $kelas = $db->query("SELECT * FROM kelas_member WHERE fk_id_member = $id_member AND hapus = 0")->getResultArray();
        $subscription = $db->query("SELECT * FROM subscription_member WHERE fk_id_member = $id_member AND hapus = 0")->getResultArray();

        $isDeleted = false;
        
        if(empty($kelas) && empty($subscription)){
            // delete 
            $model = new MemberModel();
            $model->update($id_member, ['hapus' => 1]);
            
            $db->query("UPDATE kelas_member SET hapus = 1 WHERE fk_id_member = $id_member");
            $db->query("UPDATE subscription_member SET hapus = 1 WHERE fk_id_member = $id_member");
            $isDeleted = true;
        } else {
            // do not delete 
            $isDeleted = false;
        }

        return json_encode($isDeleted);
    }

    public function tambahKelasOfMember()
    {
        $tipe_member = $this->request->getPost('tipe_member');

        $validasi  = \Config\Services::validation();
        $aturan = [
            'fk_id_member' => [
                'label' => 'Nama Member',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tipe_member' => [
                'label' => 'Tipe Member',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ]
        ];

        if($tipe_member == 'Member Kelas'){
            $aturan['fk_id_kelas'] = [
                'label' => 'Kelas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ];
        } else if($tipe_member == 'Member Subscription'){
            $aturan['fk_id_program'] = [
                'label' => 'Program',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ];
            $aturan['tgl_mulai'] = [
                'label' => 'Tgl Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ];
        }

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $fk_id_member = $this->request->getPost('fk_id_member');
            $fk_id_kelas = $this->request->getPost('fk_id_kelas');
            $fk_id_program = $this->request->getPost('fk_id_program');
            $tgl_mulai = $this->request->getPost('tgl_mulai');
            $tgl_berakhir = $this->request->getPost('tgl_berakhir');

            if($tipe_member == 'Member Kelas'){
                $data = [
                    'fk_id_member' => $fk_id_member,
                    'fk_id_kelas' => $fk_id_kelas
                ];
            } else if($tipe_member == 'Member Subscription'){
                $data = [
                    'fk_id_member' => $fk_id_member,
                    'fk_id_program' => $fk_id_program,
                    'tgl_mulai' => $tgl_mulai,
                    'tgl_berakhir' => $tgl_berakhir
                ];
            }

            $db = db_connect();
            if($tipe_member == "Member Kelas"){
                $searchMember = $db->query("SELECT * FROM kelas_member WHERE fk_id_member = $fk_id_member AND fk_id_kelas = $fk_id_kelas AND hapus = 0")->getResult();
                if ($searchMember) {
                    $hasil['sukses'] = false;
                    $hasil['error'] = 'Gagal menambahkan kelas, karena member telah masuk ke dalam kelas';
                } else {
                    $model = new KelasMemberModel();
                    $model->save($data);
                    $hasil['sukses'] = "Berhasil memasukkan data";
                    $hasil['error'] = true;
                    $hasil['edit'] = false;
                }
            } else if($tipe_member == "Member Subscription"){
                $searchMember = $db->query("SELECT * FROM subscription_member WHERE fk_id_member = $fk_id_member AND fk_id_program = $fk_id_program AND hapus = 0")->getResult();
                if ($searchMember) {
                    $hasil['sukses'] = false;
                    $hasil['error'] = 'Gagal menambahkan program, karena member telah mengikuti program';
                } else {
                    $model = new SubscriptionMemberModel();
                    $model->save($data);
                    $hasil['sukses'] = "Berhasil memasukkan data";
                    $hasil['error'] = true;
                    $hasil['edit'] = false;
                }
            }

        } else {
            $hasil['sukses'] = false;
            $hasil['error'] = $validasi->listErrors();
        }

        return json_encode($hasil);
    }

    public function simpanSubscriptionOfMember(){
        $validasi  = \Config\Services::validation();
        $aturan['tgl_mulai'] = [
            'label' => 'Tgl Mulai',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi',
            ]
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_subscription_member = $this->request->getPost("id_subscription_member");
            $tgl_mulai = $this->request->getPost('tgl_mulai');
            $tgl_berakhir = $this->request->getPost('tgl_berakhir');

            $data = [
                "tgl_mulai" => $tgl_mulai,
                "tgl_berakhir" => $tgl_berakhir,
            ];

            $model = new SubscriptionMemberModel();
            $model->update($id_subscription_member, $data);
            $hasil['sukses'] = "Berhasil mengubah data";
            $hasil['error'] = true;
            $hasil['edit'] = true;
        } else {
            $hasil['sukses'] = false;
            $hasil['error'] = $validasi->listErrors();
        }

        return json_encode($hasil);
    }

    public function getKelasOfMember($id_member)
    {
        $db = db_connect();
        $data = $db->query("SELECT id_kelas_member, nama_kelas, a.hapus FROM kelas_member as a JOIN kelas as b ON a.fk_id_kelas = b.id_kelas WHERE a.fk_id_member = $id_member AND a.hapus = 0 AND b.hapus = 0")->getResult();
        echo json_encode($data);
    }

    public function getSubscriptionOfMember($id_member)
    {
        $db = db_connect();
        $data = $db->query("SELECT id_subscription_member, nama_program, a.hapus FROM subscription_member as a JOIN program as b ON a.fk_id_program = b.id_program WHERE a.fk_id_member = $id_member AND a.hapus = 0 AND b.hapus = 0")->getResult();
        echo json_encode($data);
    }

    // hapus kelas of member
    public function hapusKelasOfMember($id_kelas_member)
    {
        $model = new KelasMemberModel();
        $model->update($id_kelas_member, ['hapus' => 1]);
    }

    // hapus subscription of member
    public function hapusSubscriptionOfMember($id_subscription_member)
    {
        $model = new SubscriptionMemberModel();
        $model->update($id_subscription_member, ['hapus' => 1]);
    }

    // edit status member
    public function editStatusMember()
    {
        $id_member = $this->request->getPost('id_member');
        $status = $this->request->getPost('status');
        $model = new MemberModel();
        $model->update($id_member, ['status' => $status]);
    }
}
