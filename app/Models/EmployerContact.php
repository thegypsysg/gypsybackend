<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerContact extends Model
{
    use HasFactory;

    protected $primaryKey = 'ec_id';

    public $timestamps = false;

    protected $fillable = ['employer_id','name', 'position_held', 'phone_number', 'email_id', 'user_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            $contact->user_id = auth()->id();
        });
    }
}
