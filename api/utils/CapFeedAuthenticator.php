<?php

namespace api\utils;

use Yii;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\web\UnauthorizedHttpException;

use common\models\cap\CapConsumer;

/**
 * 
 * @author Fabio Rizzo
 */
class CapFeedAuthenticator extends JwtHttpBearerAuth
{
    /**
     * {@inheritdoc}
     */
    public function handleFailure($response)
    {

        //header('WWW-Authenticate: Basic realm="Cap"');
        //header('HTTP/1.0 401 Unauthorized');
        \Yii::$app->response->headers->add('WWW-Authenticate', 'Basic realm="Cap"');
        \Yii::$app->response->statusCode = 401;
        \Yii::$app->response->send();

        exit();

        //throw new UnauthorizedHttpException('Credenziali non valide');
    }

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if(!$authHeader) {
            //var_dump($request->getHeaders()); exit;
            \Yii::$app->response->headers->add('WWW-Authenticate', 'Basic realm="Cap"');
            \Yii::$app->response->statusCode = 401;
            \Yii::$app->response->send();

            exit;
        }

        preg_match('/^Basic\s+(.*?)$/', $authHeader, $matches);
        if(count($matches) < 2) return null;

        $credentials = explode(":", base64_decode($matches[1]));
        $username = $credentials[0];
        $pwd = $credentials[1];

        $consumer = CapConsumer::findOne(['username'=>$username]);
        if(!$consumer) {
            \Yii::$app->response->headers->add('WWW-Authenticate', 'Basic realm="Cap"');
            \Yii::$app->response->statusCode = 401;
            \Yii::$app->response->send();

            exit;
        }

        // 800ms sono solo per questo step, da valutare se mettere le password in chiaro
        if(!Yii::$app->security->validatePassword($pwd, $consumer->password_hash) ) return null;

        Yii::$app->consumer->setIdentity( $consumer );
        return $consumer;
    }

}
