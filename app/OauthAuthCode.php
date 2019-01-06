<?php

namespace App;

use Hashids;
use Laravel\Passport\AuthCode;

class OauthAuthCode extends AuthCode
{
    /**
     * setUserIdAttribute() does not work, Need to override the parent method.
     *
     * @param array $attributes
     * @param bool  $sync
     *
     * @return $this
     */
    public function setRawAttributes($attributes, $sync = false)
    {
        /**
         * Decrypt user_id
         *
         * Encrypt user_id in @see \App\Http\Controllers\Oauth\AuthorizationController::authorize()
         */
        if (isset($attributes['user_id'])) {
            $attributes['user_id'] = current(Hashids::decode($attributes['user_id']));
        }

        return parent::setRawAttributes($attributes, $sync);
    }
}
