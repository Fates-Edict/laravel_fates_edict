<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';
    protected $guarded = ['id'];
    public $searchable = [
        'name'
    ];

    public function Patients()
    {
        return $this->hasMany(Patient::class, 'hospital_id', 'id');
    }
}
