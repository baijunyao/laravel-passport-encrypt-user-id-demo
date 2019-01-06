<?php

namespace App;

use Laravel\Passport\Token;
use Vinkla\Hashids\Facades\Hashids;

class OauthAccessToken extends Token
{
    /**
     * 当向 oauth_access_tokens 表中存储数据的时候解密 user_id
     *
     * 下面这些方法是为了加密和解密 jwt 中的 user_id
     * @see \App\Extensions\Illuminate\Auth\ExtendedUserProvider::retrieveById()
     * @see \App\User::findForPassport()
     * @see \App\OauthAccessToken::setUserIdAttribute()
     *
     * @param int|string $value
     */
    public function setUserIdAttribute($value): void
    {
        if (is_numeric($value)) {
            $this->attributes['user_id'] = $value;
        } else {
            $this->attributes['user_id'] = current(Hashids::decode($value));
        }
    }
}
