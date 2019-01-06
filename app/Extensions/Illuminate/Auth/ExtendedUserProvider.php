<?php

namespace App\Extensions\Illuminate\Auth;

use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\EloquentUserProvider;
use Vinkla\Hashids\Facades\Hashids;

class ExtendedUserProvider extends EloquentUserProvider
{
    /**
     * 当获取用户的时候解密 user_id
     *
     * 下面这些方法是为了加密和解密 jwt 中的 user_id
     * @see \App\Extensions\Illuminate\Auth\ExtendedUserProvider::retrieveById()
     * @see \App\User::findForPassport()
     * @see \App\OauthAccessToken::setUserIdAttribute()
     *
     * @param int|string $identifier
     * @return User
     * @throws AuthenticationException
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        /**
         * If Id is a string, then we need to decrypt $identifier.
         *
         * @see \App\Models\User::findForPassport()
         */
        if (!is_numeric($identifier)) {
            $identifier = current(Hashids::decode($identifier));
        }

        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
    }
}
