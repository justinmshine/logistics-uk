<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TasksModel extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'description'];
    protected $table = 'tasks';
}
