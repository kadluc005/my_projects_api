<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;

class Project extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = "projects";
    protected $fillable = ['etudiant_id', 'name', 'duree', 'description'];
}
