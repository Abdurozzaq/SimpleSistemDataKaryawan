<?php

namespace Modules\Jabatan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function index()
    {
        $result = DB::select('select * from jabatan_pegawai');

        return response()->json([
            'status' => true,
            'response' => $result
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'jabatan' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            DB::statement(
                "INSERT INTO `jabatan_pegawai` (`jabatan`, `deskripsi`) VALUES (?,?)", 
                [$data['jabatan'], $data['deskripsi']] 
            );

            return response()->json([
                'status' => true,
                'response' => 'Berhasil Insert Data Jabatan'
            ]);

        }
    }

    public function updateById(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required',
            'jabatan' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            $result = DB::select(
                'SELECT * FROM jabatan_pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data jabatan tidak di temukan'
                ]);

            } else {

                DB::statement(
                    "UPDATE `jabatan_pegawai`
                     SET `jabatan`= ?, `deskripsi`= ?
                     WHERE (`jabatan_pegawai`.`id` = ?)", 
                    [$data['jabatan'], $data['deskripsi'], $data['id']] 
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Berhasil Update Data Jabatan'
                ]);

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
                'SELECT * FROM jabatan_pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data jabatan tidak di temukan'
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
                'SELECT * FROM jabatan_pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data jabatan tidak di temukan'
                ]);

            } else {

                DB::select(
                    'DELETE FROM `jabatan_pegawai`
                     WHERE (`jabatan_pegawai`.`id` = ?)',
                    [$data['id']]
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Data jabatan berhasil dihapuskan'
                ]);

            }
        }
    }

    public function isJabatanExistById($id)
    {
        $result = DB::select(
            'SELECT * FROM jabatan_pegawai WHERE id = ?',
            [$id]
        );

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }
}
