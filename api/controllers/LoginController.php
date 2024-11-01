<?php

namespace api\controllers;

use api\models\LoginForm;
use api\models\User;
use common\models\UserRefreshTokens;
use Yii;
use yii\rest\Controller;

class LoginController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \bizley\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        // Komponentga kirish
        $jwt = Yii::$app->jwt;

        // Payload ma'lumotlarini tayyorlash

        $now = new \DateTimeImmutable();
        $token = Yii::$app->jwt->getBuilder()
            // Configures the issuer (iss claim)
            ->issuedBy(Yii::$app->params['jwt']['issuer'])
            // Configures the audience (aud claim)
            ->permittedFor(Yii::$app->params['jwt']['audience'])
            // Configures the id (jti claim)
            ->identifiedBy(Yii::$app->params['jwt']['id'])
            // Configures the time that the token was issued (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify("+1" . Yii::$app->params['jwt']['expire'] . " second"))
            // Configures a new claim, called "uid"
            ->withClaim('uid', 1)
            // Configures a new header, called "foo"
            ->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken(
                Yii::$app->jwt->getConfiguration()->signer(),
                Yii::$app->jwt->getConfiguration()->signingKey()
            );
        $tokenString = $token->toString();
        return [
             $tokenString
        ];
    }

    public function actionIndex()
    {
        return Yii::$app->user->identity->id;
    }
}