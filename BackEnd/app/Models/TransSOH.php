<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransSOH extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'tsoh';

    public $incrementing = true;

    public $timestamp = false;

    protected $fillable = ['notrans', 'tgltrans', 'subtotal', 'totdisc', 'totppn', 'grandtotal', 'resep_id'];
    //protected $guarded = ['id'];

    public function transdetail(): HasMany
    {
        return $this->hasMany(TransSOD::class, 'tsoh_id', 'id');
    }

    public function resep(): BelongsTo
    {
        return $this->belongsTo(TransResep::class, 'resep_id', 'id');
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->where(
            function ($where) use ($search) {
                $where
                    ->Where('notrans', 'ilike', "%{$search}%");
            }
        );
    }
}
