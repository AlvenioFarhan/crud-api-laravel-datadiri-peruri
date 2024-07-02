<?php

namespace App\Http\Controllers;

use App\Models\DataDiri;
use Illuminate\Http\Request;

class DataDiriController extends Controller
{
    public function index()
    {
        return DataDiri::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:data_diri',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kewarganegaraan' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        $dataDiri = DataDiri::create($validatedData);
        return response()->json($dataDiri, 201);
    }

    public function show($id)
    {
        return DataDiri::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $dataDiri = DataDiri::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:data_diri,email,' . $dataDiri->id,
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
            'kewarganegaraan' => 'sometimes|required|string|max:255',
            'agama' => 'sometimes|required|string|max:255',
            'status_perkawinan' => 'sometimes|required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        $dataDiri->update($validatedData);
        return response()->json($dataDiri, 200);
    }

    public function destroy($id)
    {
        $dataDiri = DataDiri::findOrFail($id);
        $dataDiri->delete();
        return response()->json(null, 204);
    }
}
