<?php

namespace Modules\Kontrak\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Pegawai\Http\Controllers\PegawaiController;
use Modules\Jabatan\Http\Controllers\JabatanController;

class KontrakController extends Controller
{
    protected $pegawaiController;
    protected $jabatanController;

    public function __construct(
        PegawaiController $pegawaiController,
        JabatanController $jabatanController
    ) {
        $this->pegawaiController = $pegawaiController;
        $this->jabatanController = $jabatanController;
    }

    public function index()
    {
        $result = DB::select(
            'SELECT
                `kontrak`.`id`,
                `kontrak`.`nama_kontrak`,
                `kontrak`.`id_pegawai`,
                `kontrak`.`id_jabatan`,
                `pegawai`.`nama`,
                `jabatan_pegawai`.`jabatan`
            FROM
                `pegawai`
            INNER JOIN `kontrak` ON `pegawai`.`id` = `kontrak`.`id_pegawai`
            INNER JOIN `jabatan_pegawai` ON `jabatan_pegawai`.`id` = `kontrak`.`id_jabatan`'
        );

        return response()->json([
            'status' => true,
            'response' => $result
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nama_kontrak' => 'required|string',
            'id_pegawai' => 'required|int',
            'id_jabatan' => 'required|int'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            $isValid = $this->validatePegawaiAndJabatan($data['id_pegawai'], $data['id_jabatan']);

            if ($isValid === true) {
                DB::statement(
                    "INSERT INTO `kontrak` (`nama_kontrak`, `id_pegawai`, `id_jabatan`) VALUES (?,?,?)", 
                    [$data['nama_kontrak'], $data['id_pegawai'], $data['id_jabatan']] 
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Berhasil Insert Data Kontrak'
                ]);
            } else {
                return response()->json($isValid);
            }
        }
    }

    public function getById(Request $request, $id)
    {
        $data = [
            'id' => $id
        ];

        $validator = Validator::make($data, [
            'id' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            $result = DB::select(
                'SELECT * FROM kontrak WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data kontrak tidak di temukan'
                ]);

            } else {

                return response()->json([
                    'status' => true,
                    'response' => $result
                ]);

            }

        }
    }

    public function deleteById(Request $request, $id)
    {
        $data = [
            'id' => $id
        ];

        $validator = Validator::make($data, [
            'id' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            $result = DB::select(
                'SELECT * FROM kontrak WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data kontrak tidak di temukan'
                ]);

            } else {

                DB::select(
                    'DELETE FROM `kontrak`
                     WHERE (`kontrak`.`id` = ?)',
                    [$data['id']]
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Data kontrak berhasil dihapuskan'
                ]);

            }
        }
    }

    public function validatePegawaiAndJabatan($idPegawai, $idJabatan)
    {
        $isPegawaiExist = $this->pegawaiController->isPegawaiExistById($idPegawai);
        $isJabatanExist = $this->jabatanController->isJabatanExistById($idJabatan);

        $result = [
            'status' => false,
            'response' => null
        ];

        if ($isPegawaiExist == false) {
            $result['response']['id_pegawai'] = [
                'Pegawai tidak ditemukan. Pastikan data pegawai sesuai dan sudah ada di sistem.'
            ];
        } 

        if ($isJabatanExist == false) {
            $result['response']['id_jabatan'] = [
                'Jabatan tidak ditemukan. Pastikan data jabatan sesuai dan sudah ada di sistem.'
            ];
        } 

        if (!empty($result['response'])) {
            return $result;
        } else {
            return true;
        }
    }
}

