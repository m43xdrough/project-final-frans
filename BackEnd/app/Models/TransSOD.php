<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransSOD extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'tsod';

    public $incrementing = true;

    public $timestamp = false;

    //protected $guarded = ['id'];
    protected $fillable = ['tsoh_id', 'nourut', 'material_id', 'qty', 'harga', 'disc', 'ndisc', 'ppn', 'nppn', 'total'];

    public function transheader(): BelongsTo
    {
        //return $this->belongsTo(TransSOH::class , 'foreign_key');
        return $this->belongsTo(TransSOH::class, 'id', 'tsoh_id');
    }

    public function material(): BelongsTo
    {
        //return $this->belongsTo(MasterMaterial::class, 'foreign_key');
        return $this->belongsTo(MasterMaterial::class, 'material_id', 'id');
    }
}
