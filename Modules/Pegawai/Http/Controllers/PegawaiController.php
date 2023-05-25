<?php

namespace Modules\Pegawai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $result = DB::select('select * from pegawai');

        return response()->json([
            'status' => true,
            'response' => $result
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nama' => 'required|string',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            DB::statement(
                "INSERT INTO `pegawai` (`nama`, `email`) VALUES (?,?)", 
                [$data['nama'], $data['email']] 
            );

            return response()->json([
                'status' => true,
                'response' => 'Berhasil Insert Data Pegawai'
            ]);

        }
    }

    public function updateById(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required',
            'nama' => 'required|string',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'response' => $validator->messages()
            ]);

        } else {

            $result = DB::select(
                'SELECT * FROM pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data pegawai tidak di temukan'
                ]);

            } else {

                DB::statement(
                    "UPDATE `pegawai`
                     SET `nama`=?, `email`=?
                     WHERE (`pegawai`.`id` = ?)", 
                    [$data['nama'], $data['email'], $data['id']] 
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Berhasil Update Data Pegawai'
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
                'SELECT * FROM pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data pegawai tidak di temukan'
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
                'SELECT * FROM pegawai WHERE id = ?',
                [$data['id']]
            );

            if (empty($result)) {

                return response()->json([
                    'status' => false,
                    'response' => 'Data pegawai tidak di temukan'
                ]);

            } else {

                DB::select(
                    'DELETE FROM `pegawai`
                     WHERE (`pegawai`.`id` = ?)',
                    [$data['id']]
                );
    
                return response()->json([
                    'status' => true,
                    'response' => 'Data pegawai berhasil dihapuskan'
                ]);

            }
        }
    }

    public function isPegawaiExistById($id)
    {
        $result = DB::select(
            'SELECT * FROM pegawai WHERE id = ?',
            [$id]
        );

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }
}
