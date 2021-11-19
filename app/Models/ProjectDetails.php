<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    use HasFactory;
    protected $table = 'project_details';
    protected $fillable = [
        'project_id', 
        'completion_date', 
        'planned_duration', 
        'actual_duration',
        'on_schedule_status'
    ];
}
