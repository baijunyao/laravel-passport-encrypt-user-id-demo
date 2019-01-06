<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Hashids;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 此处定义 getIdAttribute 是为了跳过模型把主键 id 转成数字的操作
     *
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttributeValue()
     *
     * @param $value
     * @return mixed
     */
    public function getIdAttribute($value)
    {
        return $value;
    }

    /**
     * 当获取用户的时候加密 user_id
     *
     * 下面这些方法是为了加密和解密 jwt 中的 user_id
     * @see \App\Extensions\Illuminate\Auth\ExtendedUserProvider::retrieveById()
     * @see \App\User::findForPassport()
     * @see \App\OauthAccessToken::setUserIdAttribute()
     *
     * @param string $email
     *
     * @return User
     */
    public function findForPassport($email): self
    {
        $user     = $this->where('email', $email)->first();
        $user->id = Hashids::encode($user->id);

        return $user;
    }
}
