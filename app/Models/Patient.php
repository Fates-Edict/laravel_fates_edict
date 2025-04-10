<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $guarded = ['id'];

    public function Hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
