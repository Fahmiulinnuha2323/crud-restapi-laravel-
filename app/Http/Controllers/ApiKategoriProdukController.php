<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriProduk;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Catch_;

class ApiKategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_kategori = KategoriProduk::all();
        if($data_kategori)
            return ResponseFormatter::success($data_kategori, 'Data kategori berhasil di ambil');
        else
            return ResponseFormatter::error($data_kategori, 'Data kosong', 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_kategori' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $kategori = KategoriProduk::create($request->all());
        if($kategori)
            return ResponseFormatter::success($kategori, 'Data berhasil dibuat');
        else
            return ResponseFormatter::error($kategori, 'Data gagal dibuat', 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = KategoriProduk::find($id);

        if($kategori)
            return ResponseFormatter::success($kategori, 'Data berhasil diambil');
        else
            return ResponseFormatter::error($kategori, 'Data tidak ada', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::find($id);

        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if($kategori){
            $kategori->update($request->all());
            return ResponseFormatter::success($kategori, 'Data berhasil di update');
        }else
            return ResponseFormatter::error($kategori,'Data tidak berhasil diupdate', 400);

        // try{
        //     $kategori->update($request->all());
        //     $response = [
        //         'message' => 'Data berhasil di update'
        //     ];
        //     return response()->json($response, HttpResponse::HTTP_OK);
        // }catch(QueryException $e){
        //     return response()->json([
        //         'message' => 'Failed ' . $e->errorInfo
        //     ]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = KategoriProduk::find($id);

        if($kategori){
            $kategori->delete();
            return ResponseFormatter::success($kategori, 'Data berhasil dihapus');
        }else
            return ResponseFormatter::error($kategori, 'Data tidak ditemukan', 404);
    }
}
