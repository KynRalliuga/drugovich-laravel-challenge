<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\ManagerLevelEnum;

class Manager extends Model {
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'token_jwt',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'level' => ManagerLevelEnum::class
    ];

    public function findByToken($token){
        return $this->where('token_jwt', $token)->first();
    }

    public function findByEmail($email){
        return $this->where('email', $email)->first();
    }

    public function updateToken($token){
        $this->token_jwt = $token;
        return $this->save();
    }

    public function isLevel1(){
        return $this->level === ManagerLevelEnum::LEVEL_1;
    }

    public function isLevel2(){
        return $this->level === ManagerLevelEnum::LEVEL_2;
    }
}
