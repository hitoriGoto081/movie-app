<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $genres = Genre::all();

        return response()->json([
            'status' => true,
            'message' => 'Data genre berhasil diambil',
            'data' => $genres
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $genre = Genre::create([
            'nama_genre' => $request->nama_genre,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Genre berhasil ditambahkan',
            'data' => $genre
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status' => false,
                'message' => 'Genre tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data genre berhasil ditemukan',
            'data' => $genre
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari data genre berdasarkan ID
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status' => false,
                'message' => 'Genre tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data
        $genre->update([
            'nama_genre' => $request->nama_genre,
        ]);

        // Response sukses
        return response()->json([
            'status' => true,
            'message' => 'Genre berhasil diupdate',
            'data' => $genre
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status' => false,
                'message' => 'Genre tidak ditemukan'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'status' => true,
            'message' => 'Genre berhasil dihapus'
        ], 200);
    }
}
