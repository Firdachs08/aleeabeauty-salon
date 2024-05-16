<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceObtained extends Model
{
    use HasFactory;

    protected $table = 'service_obtained';
    protected $guarded = ['id'];
}
