<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCareSetting extends Model
{
    use HasFactory;

    protected $table = "healthcare_settings";

    protected $primaryKey = 'hs_id';

    public $timestamps = false;

    protected $fillable = ['settings_name', 'description'];
}
