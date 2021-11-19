<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'title', 
        'owner', 
        'start_date', 
        'end_date',
        'status_active'
    ];

    public function user() {
        return $this->hasOne('App\Models\User','id','owner');
    }

    public function project_details() {
        return $this->hasOne('App\Models\ProjectDetails','project_id','id');
    }

}
