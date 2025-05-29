<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'description'];
    protected $table = 'tasks';
}
