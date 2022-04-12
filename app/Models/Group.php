<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function store($name){
        $this->name = $name;
        $this->save();
    }

    public function updateById($id, $name){
        $group = Group::find($id);
        $group->name = $name;
        $group->save();
    }
}
