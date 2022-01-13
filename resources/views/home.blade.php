@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 m-2">
            <img src="{{url('images/Moonly Market Logo.png')}}" class="mx-auto d-block" width="400" alt="">
        </div>
        @foreach($barangs as $barang)
        <div class="col-md-4">
            <div class="card">
                <img src="{{url('uploads')}}/{{$barang->gambar}}" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{$barang->nama_barang}}</h5>
                    <p class="card-text">
                        <strong>Harga :</strong> Rp.{{number_format($barang->harga)}}<br>
                        <strong>Unit Tersisa :</strong>{{$barang->persediaan}}<br>
                        <hr>
                        <strong>Keterangan :</strong>{{$barang->keterangan}}
                    </p>
                    <a href="{{url('pesan')}}/{{$barang->id}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Pesan</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection