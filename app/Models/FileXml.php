<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileXml extends Model
{
    protected $table = 'file_xmls';

    protected $fillable = [
        'fileName',
        'link',
    ];
    use HasFactory;
}
