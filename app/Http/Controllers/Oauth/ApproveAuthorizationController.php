<?php

namespace App\Http\Controllers\Oauth;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController as Controller;
use Zend\Diactoros\Response as Psr7Response;
use Hashids;

class ApproveAuthorizationController extends Controller
{
    public function approve(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $authRequest = $this->getAuthRequestFromSession($request);

            /**
             * Encrypt user_id
             *
             * @see \App\OauthAuthCode::setRawAttributes()
             */
            $user = $authRequest->getUser();
            $user->setIdentifier(Hashids::encode($user->getIdentifier()));

            return $this->convertResponse(
                $this->server->completeAuthorizationRequest($authRequest, new Psr7Response)
            );
        });
    }
}
