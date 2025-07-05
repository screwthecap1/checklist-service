<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $table = 'checklist_items';
    protected $guarded = false;

    public function  checklist() {
        return $this->belongsTo(Checklist::class);
    }
}
