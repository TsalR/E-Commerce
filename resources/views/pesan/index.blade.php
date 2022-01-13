@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{url('home')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i>Kembali</a>
        </div>
        <div class="col-md-12 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$barang->nama_barang}}</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12 m-3">
            <div class="card">
                <div class="card-header">
                    <h2>{{$barang->nama_barang}}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{url('uploads')}}/{{$barang->gambar}}" class="rounded mx-auto d-block" width="100%" alt="" srcset="">
                        </div>
                        <div class="col-md-6 mt-5">
                            <h4>{{$barang->nama_barang}}</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp.{{number_format($barang->harga)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Persediaan</td>
                                        <td>:</td>
                                        <td>{{number_format($barang->persediaan)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>{{$barang->keterangan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Pesan</td>
                                            <td>:</td>
                                            <td>
                                                <form action="{{url('pesan')}}/{{$barang->id}}" method="post">
                                                    @csrf
                                                    <input type="text" name="jumlah_pesan" class="form-control" required="">
                                                    <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-shopping-cart"></i> Masukan Keranjang</button>
                                                </form>
                                            </td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection