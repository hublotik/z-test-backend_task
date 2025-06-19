<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDict extends Model
{
    protected $table = 'status_dict';

    protected $fillable = [
        'status_name',
    ];

    public function tenders()
    {
        return $this->hasMany(Tender::class, 'status_id');
    }
}