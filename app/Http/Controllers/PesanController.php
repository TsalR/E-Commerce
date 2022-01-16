<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\pesanan;
use App\Models\pesanan_detail;
use App\Models\User;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //todo:authentication user harus login terlebih dulu
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
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
    //*fungsi pemesanan barang
    public function store(Request $request, $id)
    {
        $barang = barang::where('id',$id)->first();
        $tanggal=Carbon::now();

        //*validasi apakah melebihi stock
        if($request->jumlah_pesan > $barang->persediaan)
        {
            return redirect('pesan/'.$id);
        }

        //*Cek Validasi
        $cek_pesanan=pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();

        //*Simpan ke Database Pesanan
        if(empty($cek_pesanan)){
            $pesanan =new pesanan;
            $pesanan->user_id=Auth::user()->id;
            $pesanan->tanggal=$tanggal;
            $pesanan->status=0;
            $pesanan->jumlah_harga=0;
            $pesanan->kode=mt_rand(100,999);
            $pesanan->save();
        }

        //*Simpan ke database pesanan_detail
        $pesanan_baru=pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();

        //*Cek pesanan detail 
        $cek_pesanan_detail = pesanan_detail::where('barang_id',$barang->id)->where('pesanan_id',$pesanan_baru->id)->first();
        
        if(empty($cek_pesanan_detail))
        {
            $pesanan_detail=new pesanan_detail;
            $pesanan_detail->barang_id=$barang->id;
            $pesanan_detail->pesanan_id=$pesanan_baru->id;
            $pesanan_detail->jumlah=$request->jumlah_pesan;
            $pesanan_detail->jumlah_harga=$barang->harga*$request->jumlah_pesan;
            $pesanan_detail->save();
        }
        else
        {
            $pesanan_detail = pesanan_detail::where('barang_id',$barang->id)->where('pesanan_id',$pesanan_baru->id)->first();
            $pesanan_detail->jumlah=$pesanan_detail->jumlah+$request->jumlah_pesan;

            //*harga sekarang
            $harga_pesanan_detail_baru =$barang->harga*$request->jumlah_pesan;
            $pesanan_detail->jumlah_harga=$pesanan_detail->jumlah_harga=+$harga_pesanan_detail_baru;
            $pesanan_detail->update();
        }

        //*jumlah total
        $pesanan = pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga+$barang->harga*$request->jumlah_pesan;
        $pesanan->update();

        Alert::success('Sukses', 'Sukses Masuk Dalam Keranjang');
        return redirect('check-out');
    }

    public function check_out()   
    {
        $pesanan = pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
        $pesanan_details=[];
        if(!empty($pesanan))
        {
            $pesanan_details = pesanan_detail::where('pesanan_id',$pesanan->id)->get();
        }

        return view ('pesan.check_out',compact('pesanan','pesanan_details'));    
    }

    public function delete($id)
    {
        $pesanan_detail = pesanan_detail::where('id', $id)->first();

        $pesanan = pesanan::where('id',$pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan-> jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();

        $pesanan_detail->delete();

        Alert:: error('Pesanan Sukses Dihapus',' Hapus');
        return redirect('check-out');
    }

    public function konfirmasi()
    {
        $user=User::where('id',Auth::user()->id)->first();
        if (empty($user->alamat)) {
            Alert::warning('Silahkan Lengkapi Identitas Diri','Warning');
            return redirect('profile');
        }
        if (empty($user->notelepon)) {
            Alert::warning('Silahkan Lengkapi Identitas Diri','Warning');
            return redirect('profile');
        }
        $pesanan = pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();  
        $pesanan_id=$pesanan->id;
        $pesanan->status=1;
        $pesanan->update();

        //*Mengurangi persediaan jika melanjutkan konfirmasi
        $pesanan_details=pesanan_detail::where('pesanan_id',$pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $barang=barang::where('id',$pesanan_detail->barang_id)->first();
            $barang->persediaan=$barang->persediaan-$pesanan_detail->jumlah;
            $barang->update();
        }

        Alert::success('Pesanan Sukses Check Out','success');
        return redirect('history/'.$pesanan_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $barang = barang::where('id',$id)->first();
        return view('pesan.index', compact('barang'));
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
        //
    }
}