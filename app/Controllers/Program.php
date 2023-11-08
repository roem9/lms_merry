<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\PertemuanProgram;
use App\Models\LatihanPertemuanModel;
use App\Models\PertemuanProgramModel;
use App\Models\ProgramModel;
use App\Models\MateriPertemuanModel;
use Hermawan\DataTables\DataTable;
use JsonException;

class Program extends BaseController
{
    public function getAllMember()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('member')->select('nim, nama_member');
            return DataTable::of($builder)->toJson(true);
        }
    }

    public function index()
    {
        $data['sidebar'] = "program";
        $data['title'] = "Program";
        $data['breadcrumbs'] = ["Program"];
        $data['searchButton'] = true;

        return view('pages/program', $data);
        // echo "cek";
    }

    // Get All Program
    public function getAllProgram()
    {
        // $model = new ProgramModel();
        // $data = $model->where(['hapus' => 0])->orderBy("nama_program")->findAll();
        // return json_encode($data);
        $db = db_connect();
        $data = $db->query("SELECT id_program, nama_program, deskripsi, image, (SELECT count(*) FROM kelas WHERE fk_id_program = program.id_program AND hapus = 0) as kelas, (SELECT count(*) FROM kelas_member as a JOIN kelas as b ON a.fk_id_kelas = b.id_kelas WHERE b.fk_id_program = program.id_program AND a.hapus = 0) as peserta, (SELECT count(*) FROM subscription_member as a JOIN program as b ON a.fk_id_program = b.id_program WHERE b.id_program = program.id_program AND a.hapus = 0) as subscription FROM program WHERE hapus = 0 ORDER BY nama_program")->getResult();

        return json_encode($data);
    }

    public function getListProgram($nama_program = "")
    {
        // $model = new ProgramModel();
        if ($nama_program != "") {
            // $data = $model->where(['hapus' => 0])->like('nama_program', $nama_program)->orderBy("nama_program")->findAll();
            $db = db_connect();
            $data = $db->query("SELECT id_program, nama_program, deskripsi, (SELECT count(*) FROM kelas WHERE fk_id_program = program.id_program AND hapus = 0) as kelas, (SELECT count(*) FROM kelas_member as a JOIN kelas as b ON a.fk_id_kelas = b.id_kelas WHERE fk_id_program = program.id_program AND a.hapus = 0) as peserta FROM program WHERE hapus = 0 AND nama_program LIKE '%$nama_program%' ORDER BY nama_program")->getResult();
            return json_encode($data);
        } else {
            // $data = $model->where(['hapus' => 0])->orderBy("nama_program")->findAll();
            $db = db_connect();
            $data = $db->query("SELECT id_program, nama_program, deskripsi, (SELECT count(*) FROM kelas WHERE fk_id_program = program.id_program AND hapus = 0) as kelas, (SELECT count(*) FROM kelas_member as a JOIN kelas as b ON a.fk_id_kelas = b.id_kelas WHERE fk_id_program = program.id_program AND a.hapus = 0) as peserta FROM program WHERE hapus = 0 ORDER BY nama_program")->getResult();
            return json_encode($data);
        }
    }

    // Get Program
    public function getProgram($id)
    {
        $model = new ProgramModel();
        $data = $model->where(['hapus' => 0])->find($id);
        return json_encode($data);
    }

    // Create program
    public function simpan()
    {
        $validasi  = \Config\Services::validation();
        $file = $this->request->getFile('file');
        if ($file != null) {
            $aturan = [
                'nama_program' => [
                    'label' => 'Nama Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi'
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ]
                ],
                'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,png,jpg,jpeg],'
            ];
        } else {
            $aturan = [
                'nama_program' => [
                    'label' => 'Nama Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi'
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ]
                ]
            ];
        }

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_program = $this->request->getPost('id_program');
            $nama_program = $this->request->getPost('nama_program');
            $deskripsi = $this->request->getPost('deskripsi');

            $data = [
                'nama_program' => $nama_program,
                'deskripsi' => $deskripsi
            ];

            $model = new ProgramModel();

            $searchProgram = $model->where(['hapus' => 0])->find($id_program);
            if ($searchProgram) {
                if ($file != null) {
                    if ($file = $this->request->getFile('file')) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            // Get file name and extension
                            // $name = $file->getName();
                            // $ext = $file->getClientExtension();

                            // Get random file name
                            $newName = $file->getRandomName();

                            // Store file in public/uploads/ folder
                            $file->move('public/assets/img-program', $newName);
                            $data['image'] = $newName;

                            $model->update($id_program, $data);
                            $hasil['sukses'] = "Berhasil mengubah data";
                            $hasil['error'] = true;
                            $hasil['edit'] = true;
                            $hasil['image'] = $data['image'];
                        } else {
                            // Response
                            $hasil['sukses'] = false;
                            $hasil['error'] = "Gagal mengupload file";
                        }
                    } else {
                        // Response
                        $hasil['sukses'] = false;
                        $hasil['error'] = "Gagal mengupload file";
                    }
                } else {
                    $model->update($id_program, $data);
                    $hasil['sukses'] = "Berhasil mengubah data";
                    $hasil['error'] = true;
                    $hasil['edit'] = true;
                    $hasil['image'] = $searchProgram['image'];
                }
            } else {
                if ($file != null) {
                    if ($file = $this->request->getFile('file')) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            // Get file name and extension
                            $name = $file->getName();
                            $ext = $file->getClientExtension();

                            // Get random file name
                            $newName = $file->getRandomName();

                            // Store file in public/uploads/ folder
                            $file->move('public/assets/img-program', $newName);
                            $data['image'] = $newName;

                            $model->save($data);
                            $hasil['sukses'] = "Berhasil memasukkan data";
                            $hasil['error'] = true;
                            $hasil['edit'] = false;
                        } else {
                            // Response
                            $hasil['sukses'] = false;
                            $hasil['error'] = "Gagal mengupload file";
                        }
                    } else {
                        // Response
                        $hasil['sukses'] = false;
                        $hasil['error'] = "Gagal mengupload file";
                    }
                } else {
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

    public function hapusProgram($id)
    {
        $model = new ProgramModel();
        $model->update($id, ["hapus" => 1]);
    }

    // view list pertemuan program
    public function designProgram($id_program)
    {
        $db = db_connect();
        $program = $db->query("SELECT * FROM program WHERE id_program  = $id_program AND hapus = 0")->getRowArray();
        $allProgram = $db->query("SELECT * FROM program WHERE hapus = 0 ORDER BY nama_program")->getResultArray();

        $data['sidebar'] = "program";
        $data['title'] = "Design Program $program[nama_program]";
        $data['breadcrumbs'] = ["<a class='opacity-5 text-dark' href='".base_url()."/program'>Program</a>"];
        $data['searchButton'] = false;
        $data['deskripsi'] = "Menu untuk mengelola design pertemuan program $program[nama_program]";
        $data['id_program'] = $id_program;

        $data['breadcrumbSelect'] = [];
        if ($allProgram) {
            foreach ($allProgram as $i) {
                if ($i['id_program'] == $program['id_program']) {
                    array_push($data['breadcrumbSelect'], "<option selected value='designProgram/$i[id_program]'>$i[nama_program]</option>");
                } else {
                    array_push($data['breadcrumbSelect'], "<option value='designProgram/$i[id_program]'>$i[nama_program]</option>");
                }
            }
        }

        return view('pages/design-program', $data);
    }

    public function getAllPertemuan($id_program)
    {
        $db = db_connect();
        $data = $db->query("SELECT * FROM pertemuan_program WHERE fk_id_program  = $id_program AND hapus = 0 ORDER BY urutan")->getResult();
        return json_encode($data);
    }

    public function simpanPertemuanProgram()
    {
        $validasi  = \Config\Services::validation();
        $aturan = [
            'nama_pertemuan' => [
                'label' => 'Nama Pertemuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tipe_latihan' => [
                'label' => 'Tipe Latihan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'pengulangan_latihan' => [
                'label' => 'Perulangan Latihan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'poin' => [
                'label' => 'Poin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'pembahasan' => [
                'label' => 'Poin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $fk_id_program = $this->request->getPost('fk_id_program');
            $id_pertemuan = $this->request->getPost('id_pertemuan');
            $nama_pertemuan = $this->request->getPost('nama_pertemuan');
            $tipe_latihan = $this->request->getPost('tipe_latihan');
            $pengulangan_latihan = $this->request->getPost('pengulangan_latihan');
            $poin = $this->request->getPost('poin');
            $pembahasan = $this->request->getPost('pembahasan');

            $data = [
                'fk_id_program' => $fk_id_program,
                'nama_pertemuan' => $nama_pertemuan,
                'tipe_latihan' => $tipe_latihan,
                'pengulangan_latihan' => $pengulangan_latihan,
                'poin' => $poin,
                'pembahasan' => $pembahasan
            ];

            $model = new PertemuanProgramModel();

            $searchProgram = $model->where(['hapus' => 0])->find($id_pertemuan);
            if ($searchProgram) {
                $model->update($id_pertemuan, $data);
                $hasil['sukses'] = "Berhasil mengubah data";
                $hasil['error'] = true;
                $hasil['edit'] = true;
            } else {
                $db = db_connect();
                $urutan = $db->query("SELECT urutan FROM pertemuan_program WHERE fk_id_program = $fk_id_program AND hapus = 0 ORDER BY urutan DESC LIMIT 1")->getRowArray();
                if ($urutan) $data['urutan'] = $urutan['urutan'] + 1;
                else $data['urutan'] = 1;

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

    public function getPertemuanProgram($id_pertemuan)
    {
        $model = new PertemuanProgramModel();
        $data = $model->where(['hapus' => 0])->find($id_pertemuan);
        return json_encode($data);
    }

    public function hapusPertemuanProgram($id)
    {
        $model = new PertemuanProgramModel();
        $model->update($id, ["hapus" => 1]);
    }

    public function ubahUrutan()
    {
        $id_pertemuan = $this->request->getPost('id_pertemuan');
        $id_pertemuan_other = $this->request->getPost('id_pertemuan_other');
        $urutan = $this->request->getPost('urutan');
        $arah = $this->request->getPost('arah');

        $db = db_connect();
        if ($arah == 'naik') {
            $db->query("UPDATE pertemuan_program SET urutan = $urutan WHERE id_pertemuan = $id_pertemuan_other");
            $db->query("UPDATE pertemuan_program SET urutan = $urutan - 1 WHERE id_pertemuan = $id_pertemuan");
        } else {
            $db->query("UPDATE pertemuan_program SET urutan = $urutan WHERE id_pertemuan = $id_pertemuan_other");
            $db->query("UPDATE pertemuan_program SET urutan = $urutan + 1 WHERE id_pertemuan = $id_pertemuan");
        }
    }

    // view list materi pertemuan
    public function materiPertemuan($id_pertemuan)
    {
        $db = db_connect();
        $pertemuan = $db->query("SELECT * FROM pertemuan_program WHERE id_pertemuan  = $id_pertemuan AND hapus = 0")->getRowArray();
        $program = $db->query("SELECT * FROM program WHERE id_program  = $pertemuan[fk_id_program] AND hapus = 0")->getRowArray();
        $allPertemuan = $db->query("SELECT * FROM pertemuan_program WHERE fk_id_program  = $pertemuan[fk_id_program] AND hapus = 0")->getResultArray();

        $data['sidebar'] = "program";
        $data['title'] = "Design Materi $pertemuan[nama_pertemuan]";
        $data['breadcrumbs'] = ["<a class='opacity-5 text-dark' href='".base_url()."/program'>Program</a>", "<a class='opacity-5 text-dark' href='".base_url()."/program/designProgram/$program[id_program]'>$program[nama_program]</a>"];
        $data['searchButton'] = false;
        $data['deskripsi'] = "Menu untuk mengelola materi $pertemuan[nama_pertemuan]";
        $data['id_pertemuan'] = $id_pertemuan;

        $data['breadcrumbSelect'] = [];
        if ($allPertemuan) {
            foreach ($allPertemuan as $i) {
                if ($i['id_pertemuan'] == $pertemuan['id_pertemuan']) {
                    array_push($data['breadcrumbSelect'], "<option selected value='materiPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Materi)</option>");
                } else {
                    array_push($data['breadcrumbSelect'], "<option value='materiPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Materi)</option>");
                }
                if ($i['tipe_latihan'] != 'Tidak Ada Latihan') {
                    array_push($data['breadcrumbSelect'], "<option value='latihanPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Latihan)</option>");
                }
            }
        }

        return view('pages/design-materi-pertemuan', $data);
    }

    public function simpanMateriPertemuan()
    {
        $validasi  = \Config\Services::validation();
        $aturan = [
            'item' => [
                'label' => 'Tipe Materi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_materi = $this->request->getPost('id_materi');
            $fk_id_pertemuan = $this->request->getPost('fk_id_pertemuan');
            $item = $this->request->getPost('item');
            if ($item == 'audio') {
                $aturan = [
                    'nama_file' => [
                        'label' => 'Nama File',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ],
                    'audio' => 'uploaded[audio]|max_size[audio,10240]|ext_in[audio,mp3]'
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'file') {
                $aturan = [
                    'nama_file' => [
                        'label' => 'Nama File',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ],
                    'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf]'
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'image') {
                $aturan = [
                    'nama_file' => [
                        'label' => 'Nama File',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ],
                    'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,png,jpg,jpeg,PNG,JPG,JPEG]'
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'text') {
                $aturan = [
                    'text' => [
                        'label' => 'Text',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'video') {
                $aturan = [
                    'video' => [
                        'label' => 'Video',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            }

            if ($validasi->withRequest($this->request)->run()) {
                $data = [
                    'fk_id_pertemuan' => $fk_id_pertemuan,
                    'item' => $item
                ];

                if ($item == 'text' || $item == 'video') {
                    $model = new MateriPertemuanModel();
                    $searchMateri = $model->find($id_materi);
                    if ($searchMateri) {
                        $data['data'] = $this->request->getPost($item);
                        $model->update($id_materi, $data);
                        $hasil['sukses'] = "Berhasil mengubah data";
                        $hasil['error'] = true;
                        $hasil['edit'] = true;
                    } else {
                        $data['data'] = $this->request->getPost($item);
                        $db = db_connect();
                        $urutan = $db->query("SELECT urutan FROM materi_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY urutan DESC LIMIT 1")->getRowArray();
                        if ($urutan) $data['urutan'] = $urutan['urutan'] + 1;
                        else $data['urutan'] = 1;

                        $model->save($data);
                        $hasil['sukses'] = "Berhasil menambahkan materi";
                        $hasil['error'] = true;
                        $hasil['edit'] = false;
                    }
                } else {
                    $model = new MateriPertemuanModel();
                    if ($file = $this->request->getFile("$item")) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $nama_file = $this->request->getPost('nama_file');
                            $db = db_connect();
                            // Get audio name and extension
                            // $name = $file->getName();
                            $ext = $file->getClientExtension();

                            // Get random audio name
                            $name = $db->query("SELECT id_materi FROM materi_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY id_materi DESC LIMIT 1")->getRowArray();
                            if ($name) {
                                $newName = "$nama_file" . "_" . $name['id_materi'] + 1 . "." . $ext;
                            } else {
                                $newName = "$nama_file" . "_1." . $ext;
                            }


                            // Store audio in public/uploads/ folder
                            if ($item == 'audio') {
                                $file->move('public/assets/materi-pertemuan/audio/', $newName, true);
                            } else if ($item == 'file') {
                                $file->move('public/assets/materi-pertemuan/file/', $newName, true);
                            } else if ($item == 'image') {
                                $file->move('public/assets/materi-pertemuan/img/', $newName, true);
                            }
                            $data['data'] = $newName;


                            $urutan = $db->query("SELECT urutan FROM materi_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY urutan DESC LIMIT 1")->getRowArray();
                            if ($urutan) $data['urutan'] = $urutan['urutan'] + 1;
                            else $data['urutan'] = 1;

                            $model->save($data);
                            $hasil['sukses'] = "Berhasil menambahkan materi";
                            $hasil['error'] = true;
                            $hasil['edit'] = false;
                        } else {
                            // Response
                            $hasil['sukses'] = false;
                            $hasil['error'] = "Gagal mengupload file";
                        }
                    } else {
                        // Response
                        $hasil['sukses'] = false;
                        $hasil['error'] = "Gagal mengupload file";
                    }
                }
            } else {
                $hasil['sukses'] = false;
                $hasil['error'] = $validasi->listErrors();
            }
        } else {
            $hasil['sukses'] = false;
            $hasil['error'] = $validasi->listErrors();
        }


        return json_encode($hasil);
    }

    public function getAllMateriPertemuan($id_pertemuan)
    {
        $db = db_connect();
        $data = $db->query("SELECT * FROM materi_pertemuan WHERE fk_id_pertemuan  = $id_pertemuan ORDER BY urutan")->getResult();
        return json_encode($data);
    }

    public function ubahUrutanMateri()
    {
        $id_materi = $this->request->getPost('id_materi');
        $id_materi_other = $this->request->getPost('id_materi_other');
        $urutan = $this->request->getPost('urutan');
        $arah = $this->request->getPost('arah');

        $db = db_connect();
        if ($arah == 'naik') {
            $db->query("UPDATE materi_pertemuan SET urutan = $urutan WHERE id_materi = $id_materi_other");
            $db->query("UPDATE materi_pertemuan SET urutan = $urutan - 1 WHERE id_materi = $id_materi");
        } else {
            $db->query("UPDATE materi_pertemuan SET urutan = $urutan WHERE id_materi = $id_materi_other");
            $db->query("UPDATE materi_pertemuan SET urutan = $urutan + 1 WHERE id_materi = $id_materi");
        }
    }

    public function hapusMateriPertemuan($id_materi)
    {
        $db = db_connect();
        $deleted = $db->query("SELECT * FROM materi_pertemuan WHERE id_materi = $id_materi")->getRowArray();
        $db->query("UPDATE materi_pertemuan SET urutan = urutan - 1 WHERE urutan > $deleted[urutan] AND fk_id_pertemuan = $deleted[fk_id_pertemuan]");
        $db->query("DELETE FROM materi_pertemuan WHERE id_materi = $id_materi");

        if ($deleted['item'] == 'audio') {
            unlink("public/assets/materi-pertemuan/audio/" . $deleted['data']);
        } else if ($deleted['item'] == 'image') {
            unlink("public/assets/materi-pertemuan/img/" . $deleted['data']);
        } else if ($deleted['item'] == 'file') {
            unlink("public/assets/materi-pertemuan/file/" . $deleted['data']);
        }
    }

    public function getMateriPertemuan($id_materi)
    {
        $model = new MateriPertemuanModel();
        $data = $model->find($id_materi);
        return json_encode($data);
    }

    // views latihan pertemuan 
    public function latihanPertemuan($id_pertemuan)
    {
        $db = db_connect();
        $pertemuan = $db->query("SELECT * FROM pertemuan_program WHERE id_pertemuan  = $id_pertemuan AND hapus = 0")->getRowArray();
        $program = $db->query("SELECT * FROM program WHERE id_program  = $pertemuan[fk_id_program] AND hapus = 0")->getRowArray();
        $allPertemuan = $db->query("SELECT * FROM pertemuan_program WHERE fk_id_program  = $pertemuan[fk_id_program] AND hapus = 0")->getResultArray();

        $data['sidebar'] = "program";
        $data['title'] = "Design Latihan $pertemuan[nama_pertemuan]";
        $data['breadcrumbs'] = ["<a class='opacity-5 text-dark' href='".base_url()."/program'>Program</a>", "<a class='opacity-5 text-dark' href='".base_url()."/program/designProgram/$program[id_program]'>$program[nama_program]</a>"];
        $data['searchButton'] = false;
        $data['deskripsi'] = "Menu untuk mengelola latihan $pertemuan[nama_pertemuan]";
        $data['id_pertemuan'] = $id_pertemuan;
        $data['breadcrumbSelect'] = [];
        if ($allPertemuan) {
            foreach ($allPertemuan as $i) {
                array_push($data['breadcrumbSelect'], "<option value='materiPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Materi)</option>");
                if ($i['tipe_latihan'] != 'Tidak Ada Latihan') {
                    if ($i['id_pertemuan'] == $pertemuan['id_pertemuan']) {
                        array_push($data['breadcrumbSelect'], "<option selected value='latihanPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Latihan)</option>");
                    } else {
                        array_push($data['breadcrumbSelect'], "<option value='latihanPertemuan/$i[id_pertemuan]'>$i[nama_pertemuan] (Latihan)</option>");
                    }
                }
            }
        }

        return view('pages/design-latihan-pertemuan', $data);
    }

    public function simpanLatihanPertemuan()
    {
        $validasi  = \Config\Services::validation();
        $aturan = [
            'item' => [
                'label' => 'Item',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id_latihan = $this->request->getPost('id_latihan');
            $fk_id_pertemuan = $this->request->getPost('fk_id_pertemuan');
            $item = $this->request->getPost('item');
            if ($item == 'petunjuk') {
                $aturan = [
                    'data' => [
                        'label' => 'Text',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'soal-pg') {
                $aturan = [
                    'data' => [
                        'label' => 'Text',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Harap lengkapi soal, pilihan dan jawaban terlebih dahulu'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'soal-esai') {
                $aturan = [
                    'data' => [
                        'label' => 'Text',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Harap lengkapi soal dan jawaban terlebih dahulu'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'audio') {
                $aturan = [
                    'audio' => 'uploaded[audio]|max_size[audio,10240]|ext_in[audio,mp3]',
                    'nama_file' => [
                        'label' => 'Nama File',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'image') {
                $aturan = [
                    'nama_file' => [
                        'label' => 'Nama File',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ],
                    'image' => 'uploaded[image]|max_size[image,10240]|ext_in[image,png,jpg,jpeg,PNG,JPG,JPEG]',
                ];
                $validasi->setRules($aturan);
            } else if ($item == 'video') {
                $aturan = [
                    'data' => [
                        'label' => 'Video',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} harus diisi'
                        ]
                    ]
                ];
                $validasi->setRules($aturan);
            }

            if ($validasi->withRequest($this->request)->run()) {
                $data = [
                    'fk_id_pertemuan' => $fk_id_pertemuan,
                    'item' => $item
                ];

                if ($item == 'petunjuk' || $item == 'soal-pg' || $item == 'soal-esai' || $item == 'video') {
                    $model = new LatihanPertemuanModel();
                    $searchMateri = $model->find($id_latihan);
                    if ($searchMateri) {
                        $data['data'] = $this->request->getPost('data');
                        $model->update($id_latihan, $data);
                        $hasil['sukses'] = "Berhasil mengubah data";
                        $hasil['error'] = true;
                        $hasil['edit'] = true;
                    } else {
                        $data['data'] = $this->request->getPost('data');
                        $db = db_connect();
                        $urutan = $db->query("SELECT urutan FROM latihan_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY urutan DESC LIMIT 1")->getRowArray();
                        if ($urutan) $data['urutan'] = $urutan['urutan'] + 1;
                        else $data['urutan'] = 1;

                        $model->save($data);
                        $hasil['sukses'] = "Berhasil menambahkan item latihan";
                        $hasil['error'] = true;
                        $hasil['edit'] = false;
                    }
                } else {
                    $model = new LatihanPertemuanModel();
                    if ($file = $this->request->getFile("$item")) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $nama_file = $this->request->getPost('nama_file');
                            $db = db_connect();
                            // Get audio name and extension
                            $name = $file->getName();
                            $ext = $file->getClientExtension();

                            // Get random audio name
                            $name = $db->query("SELECT id_latihan FROM latihan_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY id_latihan DESC LIMIT 1")->getRowArray();
                            if ($name) {
                                $newName = "$nama_file" . "_" . $name['id_latihan'] + 1 . "." . $ext;
                            } else {
                                $newName = "$nama_file" . "_1." . $ext;
                            }

                            // Store audio in public/uploads/ folder
                            if ($item == 'audio') {
                                $file->move('public/assets/latihan-pertemuan/audio/', $newName, true);
                            } else if ($item == 'image') {
                                $file->move('public/assets/latihan-pertemuan/img/', $newName, true);
                            }
                            $data['data'] = $newName;

                            $urutan = $db->query("SELECT urutan FROM latihan_pertemuan WHERE fk_id_pertemuan = $fk_id_pertemuan ORDER BY urutan DESC LIMIT 1")->getRowArray();
                            if ($urutan) $data['urutan'] = $urutan['urutan'] + 1;
                            else $data['urutan'] = 1;

                            $model->save($data);
                            $hasil['sukses'] = "Berhasil menambahkan item latihan";
                            $hasil['error'] = true;
                            $hasil['edit'] = false;
                        } else {
                            // Response
                            $hasil['sukses'] = false;
                            $hasil['error'] = "Gagal mengupload file";
                        }
                    } else {
                        // Response
                        $hasil['sukses'] = false;
                        $hasil['error'] = "Gagal mengupload file";
                    }
                }
            } else {
                $hasil['sukses'] = false;
                $hasil['error'] = $validasi->listErrors();
            }
        } else {
            $hasil['sukses'] = false;
            $hasil['error'] = $validasi->listErrors();
        }


        return json_encode($hasil);
    }

    public function getAllLatihanPertemuan($id_pertemuan)
    {
        $db = db_connect();
        $data = $db->query("SELECT * FROM latihan_pertemuan WHERE fk_id_pertemuan  = $id_pertemuan ORDER BY urutan")->getResult();
        return json_encode($data);
    }

    public function ubahUrutanLatihan()
    {
        $id_latihan = $this->request->getPost('id_latihan');
        $id_latihan_other = $this->request->getPost('id_latihan_other');
        $urutan = $this->request->getPost('urutan');
        $arah = $this->request->getPost('arah');

        $db = db_connect();
        if ($arah == 'naik') {
            $db->query("UPDATE latihan_pertemuan SET urutan = $urutan WHERE id_latihan = $id_latihan_other");
            $db->query("UPDATE latihan_pertemuan SET urutan = $urutan - 1 WHERE id_latihan = $id_latihan");
        } else {
            $db->query("UPDATE latihan_pertemuan SET urutan = $urutan WHERE id_latihan = $id_latihan_other");
            $db->query("UPDATE latihan_pertemuan SET urutan = $urutan + 1 WHERE id_latihan = $id_latihan");
        }
    }

    public function hapusLatihanPertemuan($id_latihan)
    {
        $db = db_connect();
        $deleted = $db->query("SELECT * FROM latihan_pertemuan WHERE id_latihan = $id_latihan")->getRowArray();
        $db->query("UPDATE latihan_pertemuan SET urutan = urutan - 1 WHERE urutan > $deleted[urutan] AND fk_id_pertemuan = $deleted[fk_id_pertemuan]");
        $db->query("DELETE FROM latihan_pertemuan WHERE id_latihan = $id_latihan");

        if ($deleted['item'] == 'audio') {
            unlink("public/assets/latihan-pertemuan/audio/" . $deleted['data']);
        } else if ($deleted['item'] == 'image') {
            unlink("public/assets/latihan-pertemuan/img/" . $deleted['data']);
        }
    }

    public function getLatihanPertemuan($id_latihan)
    {
        $model = new LatihanPertemuanModel();
        $data = $model->find($id_latihan);
        return json_encode($data);
    }
}