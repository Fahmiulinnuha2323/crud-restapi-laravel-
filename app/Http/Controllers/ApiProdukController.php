<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\KategoriProduk;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class ApiProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //untuk menampilkan data
        $data_produk = Produk::with('kategori')->get();
        $response = [
            'message' => 'Data berhasil diambil',
            'data' => $data_produk
        ];

        return response()->json($response, Response::HTTP_OK);
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

    }

    public function all(Request $request)
    {
        $id_produk = $request->input('id_produk');
        $limit = $request->input('limit');
        $name = $request->input('nama_produk');
        $id_kategori = $request->input('id_kategori');

        if($id_produk)
        {
            $product = Produk::with('kategori')->find($id_produk);

            if($product)
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            else
                return ResponseFormatter::error($product, 'Data produk tidak ada', 404);
        }

        if($id_kategori)
        {
            $product = Produk::with('kategori')->find($id_kategori);

            if($product)
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            else
                return ResponseFormatter::error($product, 'Data produk tidak ada', 404);
        }

        $product = Produk::with('kategori');

        if($name)
            $product->where('nama_produk', 'like', '%' . $name . '%');

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data list produk berhasil diambil'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id)
    {
        $data_produk = Produk::with('kategori')->find($id);

        if($data_produk)
            return ResponseFormatter::success($data_produk, 'Data produk berhasil diambil');
        else
            return ResponseFormatter::error($data_produk, 'Data produk tidak ada', 404);
    }

    public function showByNama($nama)
    {
        $data_produk = Produk::with('kategori')->where('nama_produk','LIKE', '%'.$nama. '%')->get();

        if($data_produk)
            return ResponseFormatter::success($data_produk, 'Data produk berhasil diambil');
        else
            return ResponseFormatter::error($data_produk, 'Data produk tidak ada', 404);

        // try{
        //     $response = [
        //         'message' => 'Data berhasil diambil',
        //         'data' => $data_produk
        //     ];
        //     return response()->json($response, Response::HTTP_OK);

        // }catch(QueryException $e){
        //     return response()->json([
        //         'message' => 'Data tidak ada' . $e->errorInfo
        //     ]);
        // }
        //
    }

    public function showByKategori($id)
    {
        $data_produk = Produk::with('kategori')->where('id_kategori',$id)->get();

        return ResponseFormatter::success($data_produk, 'Data produk berhasil diambil');
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        if($produk){
            $produk->delete();
            return ResponseFormatter::success($produk, 'Data berhasil dihapus');
        }else
            return ResponseFormatter::error($produk, 'Data produk tidak ada', 404);
    }
}
