<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $table = "checklistitems";
    public $fillable = [
        'checklist_id',
        'item_name'
    ];
}
