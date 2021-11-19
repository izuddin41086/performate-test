<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;
    protected $table = 'project_status';
    protected $fillable = [
        'status_name',
        'low_range',
        'high_range'
    ];
}
