<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    protected $table = 'access_token';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $guarded = ['id'];

    public function scopeActiveToken($query, $token)
    {
        $query->where('is_active', 1)
            ->where('token', $token)
        ->where('expired_at', '>', now());
    }
}
