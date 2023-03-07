<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransResep extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'tresep';
    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamp = false;

    protected $fillable = ['noresep', 'tglresep', 'chspherisr', 'chspherisl', 'chcylinderr', 'chcylinderl', 'chadditionr', 'chadditionl', 'chaxisr', 'chaxisl', 'member_id'];
    //protected $guarded = ['id'];



    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'updated_date';

    // //Default Value
    // protected $attributes = [
    //     'options' => '[]',
    //     'delayed' => false,
    // ];

    //untuk memastikan field yang disebutkan yg dpt diisi/update
    // protected $fillable = ['name'];

    //Relation 1 <|
    public function transaksi(): HasMany
    {
        return $this->hasMany(TransSOH::class);
        //return $this->belongsTo(TransResep::class,'foreign_key ');    pakai ini jika di table MasterMember ada field untuk foreign key
    }

    //Inverse of Relation
    public function member(): BelongsTo
    {
        return $this->belongsTo(MasterMember::class);
    }
    /*public function member()
    {
        return $this->hasOne(MasterMember::class, 'id', 'member_id');
    }*/

    public function scopeSearch(Builder $query, $search)
    {
        $query->where(
            function ($where) use ($search) {
                $where->Where('noresep', 'ilike', "%{$search}%");
            }
        );
    }
}
