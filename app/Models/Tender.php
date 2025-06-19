<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $table = 'tenders';

    protected $fillable = [
        'remote_id',
        'number',
        'status_id',
        'name',
        'updated_at',
        'created_at',
    ];

    public function status()
    {
        return $this->belongsTo(StatusDict::class, 'status_id');
    }
}