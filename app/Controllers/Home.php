<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $data['session'] = session();
        $data['sidebar'] = "dashboard";
        $data['title'] = "Dashboard";
        $data['breadcrumbs'] = ['Dashboard'];

        $data['bulan'] = $db->query("SELECT * FROM config WHERE field = 'bulan'")->getRowArray();
        $data['tahun'] = $db->query("SELECT * FROM config WHERE field = 'tahun'")->getRowArray();

        if($data['bulan']['value'] == "" && $data['tahun']['value'] == ""){
            $data['description'] = "Statistik Lembaga Anda Seluruh Periode";
        } else if($data['bulan']['value'] == "" && $data['tahun']['value'] != ""){
            $data['description'] = "Statistik Lembaga Anda Periode " . $data['tahun']['value'];
        } else if($data['tahun']['value'] == "" && $data['bulan']['value'] != ""){
            $data['description'] = "Statistik Lembaga Anda Periode " . bulanIndonesia($data['bulan']['value']) . "";
        } else {
            $data['description'] = "Statistik Lembaga Anda Periode " . bulanIndonesia($data['bulan']['value']) . " " .$data['tahun']['value'];
        }

        $db = db_connect();
        $data['peserta'] = COUNT($db->query("SELECT * FROM kelas_member WHERE hapus = 0")->getResult());
        $data['peserta_lulus'] = COUNT($db->query("SELECT * FROM kelas_member WHERE hapus = 0 AND sertifikat = 1")->getResult());
        $data['kelas'] = COUNT($db->query("SELECT * FROM kelas WHERE hapus = 0")->getResult());
        $data['program'] = COUNT($db->query("SELECT * FROM program WHERE hapus = 0")->getResult());

        return view('pages/dashboard', $data);
    }

    public function laporan()
    {
        $data['sidebar'] = "laporan";
        $data['title'] = "Laporan";

        $db = db_connect();
        $periode = $db->query("SELECT MONTH(tgl_mulai) as month, YEAR(tgl_mulai) as year FROM kelas GROUP BY MONTH(tgl_mulai), YEAR(tgl_mulai) ORDER BY tgl_mulai DESC")->getResultArray();

        $data['laporan'] = [];
        foreach ($periode as $i => $periode) {
            $data['laporan'][$i]['month'] = $periode['month'];
            $data['laporan'][$i]['year'] = $periode['year'];
            $data['laporan'][$i]['periode'] = date("F", mktime(0, 0, 0, $periode['month'], 10)) . " " . $periode['year'];
            $class = $db->query("SELECT * FROM kelas WHERE MONTH(tgl_mulai) = $periode[month] AND YEAR(tgl_mulai) = $periode[year] AND hapus = 0")->getResultArray();

            $data['laporan'][$i]['class'] = COUNT($class);
            $data['laporan'][$i]['subscription'] = COUNT($db->query("SELECT * FROM subscription_member WHERE MONTH(tgl_mulai) = $periode[month] AND YEAR(tgl_mulai) = $periode[year] AND hapus = 0")->getResultArray());
            $data['laporan'][$i]['student'] = 0;
            $data['laporan'][$i]['certificate'] = 0;

            foreach ($class as $class) {
                $peserta = $db->query("SELECT * FROM kelas_member WHERE fk_id_kelas = $class[id_kelas] AND hapus = 0")->getResultArray();

                $data['laporan'][$i]['student'] += COUNT($peserta);
                $sertifikat = $db->query("SELECT * FROM kelas_member WHERE fk_id_kelas = $class[id_kelas] AND hapus = 0 AND sertifikat = 1")->getResultArray();
                $data['laporan'][$i]['certificate'] += COUNT($sertifikat);
            }
        }

        return view('pages/laporan', $data);
    }

    public function laporanStatistik(){
        $db = db_connect();
        $data['bulan'] = $db->query("SELECT * FROM config WHERE field = 'bulan'")->getRowArray();
        $data['tahun'] = $db->query("SELECT * FROM config WHERE field = 'tahun'")->getRowArray();

        $bulan = $data['bulan']['value'];
        $tahun = $data['tahun']['value'];

        if($bulan == "" && $tahun == ""){
            $conditionSubscription = "subscription_member.hapus = 0";
            $conditionKelas = "kelas.hapus = 0";
        } else if($bulan == "" && $tahun != ""){
            $conditionSubscription = "YEAR(tgl_mulai) = $tahun AND subscription_member.hapus = 0";
            $conditionKelas = "((YEAR(tgl_mulai) = $tahun OR YEAR(tgl_selesai) = $tahun)) AND kelas.hapus = 0";
        } else if($tahun == "" && $bulan != ""){
            $conditionSubscription = "MONTH(tgl_mulai) = $bulan AND subscription_member.hapus = 0";
            $conditionKelas = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan)) AND kelas.hapus = 0";
            $whereCondition = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan)) AND kelas.hapus = 0";
        } else {
            $conditionSubscription = "MONTH(tgl_mulai) = $bulan AND YEAR(tgl_mulai) = $tahun AND subscription_member.hapus = 0";
            $conditionKelas = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan) AND (YEAR(tgl_mulai) = $tahun OR YEAR(tgl_selesai) = $tahun)) AND kelas.hapus = 0";
            $whereCondition = "((MONTH(tgl_mulai) = $bulan OR MONTH(tgl_selesai) = $bulan) AND (YEAR(tgl_mulai) = $tahun OR YEAR(tgl_selesai) = $tahun)) AND kelas.hapus = 0";
        }

        $data['label'] = [];
        $data['data'] = [];
        $dataProgram = $db->query("SELECT * FROM program WHERE hapus = 0")->getResultArray();

        foreach ($dataProgram as $key => $dataProgram) {
            $data['label'][$key] = $dataProgram['nama_program'];
            $subscription = $db->query("SELECT COUNT(id_subscription_member) as subscription FROM subscription_member WHERE $conditionSubscription AND fk_id_program = $dataProgram[id_program]")->getRowArray();
            $kelas = $db->query("SELECT COUNT(id_kelas) as kelas FROM kelas WHERE $conditionKelas AND fk_id_program = $dataProgram[id_program]")->getRowArray();
            $member = $db->query("SELECT COUNT(id_kelas_member) as member FROM kelas_member WHERE fk_id_kelas IN (SELECT id_kelas FROM kelas WHERE $conditionKelas AND fk_id_program = $dataProgram[id_program]) AND kelas_member.hapus = 0")->getRowArray();

            if($subscription['subscription'] === null){
                $subscription['subscription'] = 0;
            }

            if($kelas['kelas'] === null){
                $kelas['kelas'] = 0;
            }

            if($member['member'] === null){
                $member['member'] = 0;
            }
            
            $data['subscription'][$key] = $subscription['subscription'];
            $data['kelas'][$key] = $kelas['kelas'];
            $data['member'][$key] = $member['member'];
        }

        return json_encode($data);
    }

    public function exportLaporan($bulan, $tahun)
    {
        $db = db_connect();
        $kelas = $db->query("SELECT * FROM kelas WHERE hapus = 0 AND MONTH(tgl_mulai) = $bulan AND YEAR(tgl_mulai) = $tahun ORDER BY id_kelas DESC")->getResultArray();
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "LIST PESERTA PERIODE $bulan $tahun")
            ->setCellValue('A2', 'No')
            ->setCellValue('B2', 'Nama Peserta')
            ->setCellValue('C2', 'No. HP')
            ->setCellValue('D2', 'Kelas')
            ->setCellValue('E2', 'Sertifikat');

        $spreadsheet->getActiveSheet()->mergeCells('A2:A3')
            ->mergeCells('B2:B3')
            ->mergeCells('C2:C3')
            ->mergeCells('D2:D3')
            ->mergeCells('E2:E3')
            ->mergeCells('A1:D1');
        $kolom = 4;
        $nomor = 1;

        foreach ($kelas as $kelas) {
            $semua_peserta = $db->query("SELECT * FROM kelas_member WHERE fk_id_kelas = $kelas[id_kelas] AND hapus = 0")->getResultArray();
            foreach ($semua_peserta as $peserta) {
                $data_peserta = $db->query("SELECT * FROM member WHERE id_member = $peserta[fk_id_member]")->getRowArray();
                $data_peserta['no_doc'] = $peserta['no_doc'];

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $kolom, $nomor)
                    ->setCellValue('B' . $kolom, $data_peserta['nama_member'])
                    ->setCellValue('C' . $kolom, "'{$data_peserta['no_wa']}")
                    ->setCellValue('D' . $kolom, $kelas['nama_kelas'])
                    ->setCellValue('E' . $kolom, $data_peserta['no_doc']);

                $kolom++;
                $nomor++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Peserta ' . $bulan . ' ' . $tahun . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function exportLaporanSubscription($bulan, $tahun)
    {
        $db = db_connect();
        $program = $db->query("SELECT * FROM program WHERE hapus = 0")->getResultArray();
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "LIST PESERTA SUBSCRIPTION PERIODE $bulan $tahun")
            ->setCellValue('A2', 'No')
            ->setCellValue('B2', 'Nama Peserta')
            ->setCellValue('C2', 'No. HP')
            ->setCellValue('D2', 'Kelas')
            ->setCellValue('E2', 'Sertifikat');

        $spreadsheet->getActiveSheet()->mergeCells('A2:A3')
            ->mergeCells('B2:B3')
            ->mergeCells('C2:C3')
            ->mergeCells('D2:D3')
            ->mergeCells('E2:E3')
            ->mergeCells('A1:D1');
        $kolom = 4;
        $nomor = 1;

        foreach ($program as $program) {
            $semua_peserta = $db->query("SELECT * FROM subscription_member WHERE fk_id_program = $program[id_program] AND hapus = 0")->getResultArray();
            foreach ($semua_peserta as $peserta) {
                $data_peserta = $db->query("SELECT * FROM member WHERE id_member = $peserta[fk_id_member]")->getRowArray();
                $data_peserta['no_doc'] = $peserta['no_doc'];

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $kolom, $nomor)
                    ->setCellValue('B' . $kolom, $data_peserta['nama_member'])
                    ->setCellValue('C' . $kolom, "'{$data_peserta['no_wa']}")
                    ->setCellValue('D' . $kolom, $program['nama_program'])
                    ->setCellValue('E' . $kolom, $data_peserta['no_doc']);

                $kolom++;
                $nomor++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Peserta Subscription ' . $bulan . ' ' . $tahun . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
