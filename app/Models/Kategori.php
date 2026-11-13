<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    public function items()
    {
        return $this->belongsToMany(
            MasterItem::class,
            'kategori_item',
            'kategori_id',
            'master_item_id'
        );
    }
}
