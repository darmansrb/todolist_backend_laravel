<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{
    public function getlist() {
        $tugas = Tasks::get();

        if (count($tugas) > 0) {
            $hasil_json = array(
                'status_kode' => 200,
                'data' => $tugas,
            );
        } else {
            $hasil_json = array(
                'status_kode' => 204,
                'data' => [],
            );
        }

        return response()->json($hasil_json);
    }

    public function simpan(Request $request) {

        $get_req = json_decode($request->getContent(), true);
        $datajudul = strtoupper($get_req['judul']);

        if (!empty($datajudul)) {

            $simpan_task = Tasks::create([
                'judul' => $datajudul,
                'status' => '0'
            ]);

            // $simpan_task = true;

            if ($simpan_task) {

                $hasil_json = array(
                    'status_kode' => 201,
                    'pesan' => "Berhasil tambah tugas",
                );
            } else {

                $hasil_json = array(
                    'status_kode' => 417,
                    'pesan' => "Gagal tambah tugas",
                );
            }


        } else {
            $hasil_json = array(
                'status_kode' => 428,
                'pesan' => "Tugas tidak boleh kosong",
            );
        }
        return response()->json($hasil_json);

    }

    public function view_edit($id) {

        $findidtugas = Tasks::where('id', $id)->first();

        if ($findidtugas) {
            $showdatatugas = array(
                'status_kode' => 200,
                'data' => $findidtugas,
            );
        } else {
            $showdatatugas = array(
                'status_kode' => 204,
                'data' => [],
            );
        }

        return response()->json($showdatatugas);
    }

    public function ubah(Request $request) {
        $ubah_get_req = json_decode($request->getContent(), true);
        $datajudul = strtoupper($ubah_get_req['judul']);
        $dataid = strtoupper($ubah_get_req['id']);

        if (!empty($dataid) && !empty($datajudul)) {

            $simpan_task = Tasks::where('id',  $dataid)->update([
                'judul' => $datajudul,
            ]);

            if ($simpan_task) {

                $hasil_json = array(
                    'status_kode' => 201,
                    'pesan' => "Berhasil update tugas",
                );
            } else {

                $hasil_json = array(
                    'status_kode' => 417,
                    'pesan' => "Gagal update tugas",
                );
            }

        } else {
            $hasil_json = array(
                'status_kode' => 428,
                'pesan' => "Request id dan tugas tidak boleh kosong",
            );
        }
        return response()->json($hasil_json);
    }

    public function update_status(Request $request) {

        $ubah_get_req = json_decode($request->getContent(), true);
        $dataid = $ubah_get_req['id'];
        $datastatus = $ubah_get_req['status'];

        if (!empty($dataid) && !empty($datastatus)) {

            $simpan_task = false;
            $pesan = "";

            if ($datastatus == "done") {
                $simpan_task = Tasks::where('id',  $dataid)->update([
                    'status' => '1',
                ]);
                $pesan = "Status tugas selesai";
            }else{
                $simpan_task = Tasks::where('id',  $dataid)->update([
                    'status' => '0',
                ]);
                $pesan = "Status tugas di batalkan";
            }

            if ($simpan_task) {

                $hasil_json = array(
                    'status_kode' => 201,
                    'pesan' => $pesan,
                );
            } else {

                $hasil_json = array(
                    'status_kode' => 417,
                    'pesan' => "Gagal update status tugas",
                );
            }

        } else {
            $hasil_json = array(
                'status_kode' => 428,
                'pesan' => "Request id dan tugas tidak boleh kosong",
            );
        }
        return response()->json($hasil_json);
    }

    public function hapus($id) {

        $delete = Tasks::where('id', $id)->delete();
        // $delete = false;

        if ($delete) {

            $hasil_json = array(
                'status_kode' => 201,
                'pesan' => "Berhasil hapus tugas",
            );
        } else {

            $hasil_json = array(
                'status_kode' => 417,
                'pesan' => "Gagal hapus tugas",
            );
        }

        return response()->json($hasil_json);
    }

    public function cari_tugas(Request $request) {

        $cari_get_req = json_decode($request->getContent(), true);
        $datacari = $cari_get_req['request'];

        $tugas = Tasks::where('judul', 'LIKE',"%$datacari%")->get();

        if (count($tugas) > 0) {
            $hasil_json = array(
                'status_kode' => 200,
                'data' => $tugas,
            );
        } else {
            $hasil_json = array(
                'status_kode' => 204,
                'data' => [],
            );
        }

        return response()->json($hasil_json);

    }
}
