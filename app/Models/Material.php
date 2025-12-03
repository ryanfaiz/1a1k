<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'file_path',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

}
