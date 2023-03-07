<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterMember extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'mmember';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamp = false;

    public function resep(): HasMany
    {
        return $this->hasMany(TransResep::class);
    }

    protected $hidden = ['xpassword'];

    protected $fillable = ['kode', 'nama', 'email', 'no_hp', 'tgllahir', 'jnskelamin', 'xpassword', 'alamat', 'kota', 'provinsi'];
    //protected $guarded = ['id'];

    public function scopeProvinsi(Builder $query, $search)
    {
        $query->where('provinsi', 'ilike', "%{$search}%");
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->where(
            function ($where) use ($search) {
                $where
                    ->Where('nama', 'ilike', "%{$search}%")
                    ->orWhere('provinsi', 'ilike', "%{$search}%")
                    ->orWhere('kota', 'ilike', "%{$search}%");
            }
        );
    }
}
