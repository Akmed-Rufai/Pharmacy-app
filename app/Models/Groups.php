<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medicine;

class Groups extends Model
{
    /** @use HasFactory<\Database\Factories\GroupsFactory> */
    protected $fillable = ['group', 'usage', 'prescription'];

    public function medicine(){
        return $this->hasMany(Medicine::class);
    }

    use HasFactory;
}
