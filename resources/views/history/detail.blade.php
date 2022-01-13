@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{url('history')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i>Kembali</a>
        </div>
        <div class="col-md-12 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('history')}}">Riwayat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pemesanan</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>Sukses check-out</h3>
                <h5>Pesanan anda telah berhasil di check out,selanjutnya untuk pembayaran silahkan transfer di <br>
                    rekening <strong>BANK BNI = 0393111010</strong><br>
                    dengan nominal : <strong>Rp.{{number_format($pesanan->jumlah_harga+$pesanan->kode)}}</strong>
                </h5>
                <h5><span class="bg-warning text-white">Harap Transfer Sesuai Dengan Pembayaran Kode Unik Yang Tertera Untuk Dapat Melakukan Proses Dengan Cepat</span></h5>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-body">
                    <h3><i class="fa fa-shopping-cart"></i> Detail Pemesanan </h3>
                    @if(!empty($pesanan))
                    <p align="right">Tanggal Pesan : {{$pesanan->tanggal}}</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Jumlah </th>
                                <th>Harga</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($pesanan_details as $pesanan_detail)   
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><img src="{{url('uploads')}}/{{$pesanan_detail->gambar}}"  width="100" alt=""></td>
                                <td>{{ $pesanan_detail->barang->nama_barang }}</td>
                                <td>{{ $pesanan_detail->jumlah}} barang</td>
                                <td align="left">Rp. {{ number_format($pesanan_detail->barang->harga) }}</td>
                                <td align="left">Rp. {{ number_format($pesanan_detail->jumlah_harga) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" align="right"><strong>Total Harga Barang :</strong></td>
                                <td><strong>Rp. {{ number_format($pesanan->jumlah_harga)}}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right"><strong>Kode Unik :</strong></td>
                                <td><strong>Rp. {{ number_format($pesanan->kode)}}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right"><strong>Total Bayar :</strong></td>
                                <td><strong>Rp. {{ number_format($pesanan->jumlah_harga+$pesanan->kode)}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection