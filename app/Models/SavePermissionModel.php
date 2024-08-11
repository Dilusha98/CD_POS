<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavePermissionModel extends Model
{
    use HasFactory;

    protected $table = 'save_permissions';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
