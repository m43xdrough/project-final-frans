<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMaterial extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'mmaterial';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamp = false;

    public function transdtl(): HasMany
    {
        return $this->hasMany(TransSOD::class);
    }

    protected $fillable = ['kdbarang', 'namabarang', 'harga'];
    //protected $guarded = ['id'];

    public function scopeNamabarang(Builder $query, $search)
    {
        $query->where('namabarang', 'ilike', "%{$search}%");
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->where(
            function ($where) use ($search) {
                $where
                    ->Where('namabarang', 'ilike', "%{$search}%")
                    ->orWhere('kdbarang', 'ilike', "%{$search}%");
            }
        );
    }
}
