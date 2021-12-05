<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemType extends Model
{
    use HasFactory;
    protected $table  = "problemtypes";
    protected $guarded = [];
    public $timestamps = false;

}
