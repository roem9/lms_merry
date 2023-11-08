<?php

function web_member()
{
    $db = db_connect();

    $result = $db->query("SELECT value FROM config WHERE field = 'web_admin'")->getRowArray();
    return $result['value'];
}

function list_program()
{
    $db = db_connect();

    $result = $db->query("SELECT id_program, nama_program FROM program WHERE hapus = 0")->getResultArray();
    return $result;
}

function list_pengajar()
{
    $db = db_connect();

    $result = $db->query("SELECT id_pengajar, nama_pengajar FROM pengajar WHERE hapus = 0 AND status = 'aktif'")->getResultArray();
    return $result;
}

function bulanIndonesia($bulan) {
    switch ($bulan) {
        case 1:
            return "Januari";
        case 2:
            return "Februari";
        case 3:
            return "Maret";
        case 4:
            return "April";
        case 5:
            return "Mei";
        case 6:
            return "Juni";
        case 7:
            return "Juli";
        case 8:
            return "Agustus";
        case 9:
            return "September";
        case 10:
            return "Oktober";
        case 11:
            return "November";
        case 12:
            return "Desember";
        default:
            return "Bulan tidak valid";
    }
}
