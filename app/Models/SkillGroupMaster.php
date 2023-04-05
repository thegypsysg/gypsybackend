<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillGroupMaster extends Model
{
    use HasFactory;
    
    protected $table = 'skills_group_master';

    protected $primaryKey = 'sgm_id';

    public $timestamps = false;

    protected $fillable = ['group_name', 'description', 'image'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            
            $skill->slug = strtolower(str_replace(' ', '-', $skill->group_name));
            
        });
    }
}
