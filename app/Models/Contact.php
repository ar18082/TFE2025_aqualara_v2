<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'phone',
        'phone2',
        'mobile',
        'mobile2',
        'street',
        'street2',
        'city',
        'postal_code',
        'country',
        'contact_type_id',
    ];

    // relations
    public function gerantImm()
    {
        return $this->belongsTo(GerantImm::class, 'codgerant', 'Codegerant');
    }

    public function proprioApp()
    {
        return $this->belongsTo(ProprioApp::class, 'codproprio', 'Propriocd');
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function owner()
    {
        return $this->hasOne(Property::class, 'owner_id');
    }
}
