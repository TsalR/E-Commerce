<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan_detail extends Model
{
    public function barang(){
        return $this->belongsTo('App\Models\barang','barang_id','id');
    }

    public function pesanan(){
        return $this->belongsTo('App\Models\pesanan','pesanan_id','id');
    }
}
