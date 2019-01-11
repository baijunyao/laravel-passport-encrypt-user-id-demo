<?php

namespace App;

use Hashids;
use Laravel\Passport\AuthCode;

class OauthAuthCode extends AuthCode
{
    /**
     * 因为 setRawAttributes 不能触发 setUserIdAttribute()
     * 所以此处需要覆盖父级的 setRawAttributes()
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
         * 因为模型的 get() 方法会触发 setRawAttributes ；虽然 Passport 没有使用模型获取数据
         * 但是为了严谨此处需要增加 $this->exists 的判断； 只在存储的时候解密 user_id
         */
        if (isset($attributes['user_id']) && !$this->exists) {
            $attributes['user_id'] = current(Hashids::decode($attributes['user_id']));
        }

        return parent::setRawAttributes($attributes, $sync);
    }
}
