<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;

class Etudiant extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = "etudiants";
    protected $fillable = ['name', 'email', 'password', 'phone'];
}
