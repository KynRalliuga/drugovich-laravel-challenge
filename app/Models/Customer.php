<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'cnpj',
        'name',
        'foundation_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'group_id',
    ];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function store($atts = []){
        foreach ($atts as $key => $value) {
            if(in_array($key, $this->fillable)){
                $this->{$key} = $value;
            }
        }
        $this->save();
    }

    public function updateById($id, $atts = []){
        $customer = Customer::find($id);
        foreach ($atts as $key => $value) {
            if(in_array($key, $this->fillable)){
                $customer->{$key} = $value;
            }
        }
        $customer->save();
    }

    public function getByGroup($id){
        return $this->where('group_id', $id);
    }
}
