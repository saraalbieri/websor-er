<?php

namespace api\utils;

use sizeg\jwt\JwtHttpBearerAuth;
use yii\web\UnauthorizedHttpException;

/**
 * La magia di yii2 e dei pacchetti relativi ci costringe a questo per la modifica di un semplice messaggio, ok
 * 
 * handleFailure è un metodo della classe estesa da JwtHttpBearerAuth
 * qui lo riscriviamo solo per cambiare il messaggio di errore che è in inglese non traducibile
 *
 * @author Fabio Rizzo
 */
class Authenticator extends JwtHttpBearerAuth
{
    /**
     * {@inheritdoc}
     */
    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('Credenziali non valide');
    }

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');

        if(
        	$authHeader == null && 
        	isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && 
        	$_SERVER['REDIRECT_HTTP_AUTHORIZATION'] != "") {
            $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches)) {
            $token = $this->loadToken($matches[1]);
            if ($token === null) {
                return null;
            }

            if ($this->auth) {
                $identity = call_user_func($this->auth, $token, get_class($this));
            } else {
                $identity = $user->loginByAccessToken($token, get_class($this));
            }

            return $identity;
        }

        return null;
    }

}
