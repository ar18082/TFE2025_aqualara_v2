<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileStorage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_filename',
        'path',
        'extension',
        'mime_type',
        'size',
        'hash',
        'description',
        'is_public',
        'is_active',
        'user_id',
        'codeCli',
    ];

    /**
     * Get the user - relationship.
     */
    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'codeCli', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appareil()
    {
        return $this->belongsTo(Appareil::class);
    }
}
