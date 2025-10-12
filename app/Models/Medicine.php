<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groups;

class Medicine extends Model
{

    protected $fillable = ['medicine', 'price', 'description', 'quantity', 'group_id'];

    
    public function group(){
        return $this->belongsTo(Groups::class);
    }
    
    use HasFactory;
}
