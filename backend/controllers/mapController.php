<?php

namespace backend\controllers;

use common\models\cap\CapExposedMessage;
use common\models\cap\CapMessages;
use paragraph1\phpFCM\Recipient\Device;
use yii\web\Response;
use common\models\ComComunicazioni;
use common\models\ConEventoExtra;
use common\models\ConEventoSegnalazione;
use common\models\ConOperatoreEvento;
use common\models\ConOperatoreTask;
use common\models\ConOperatoreTaskSearch;
use common\models\LocComune;
use common\models\LocIndirizzo;
use common\models\LocCivico;
use common\models\MyHelper;
use common\models\RichiestaCanadair;
use common\models\RichiestaCanadairSearch;
use common\models\RichiestaDos;
use common\models\RichiestaDosSearch;
use common\models\RichiestaElicottero;
use common\models\RichiestaElicotteroSearch;
use common\models\RichiestaMezzoAereo;
use common\models\User;
use common\models\UtlExtraSegnalazione;
use common\models\UtlOperatorePc;
use common\models\UtlSegnalazione;
use common\models\UtlSegnalazioneSearch;
use common\models\UtlIngaggio;
use common\models\UtlIngaggioSearch;
use common\models\ViewVolontariAttivazioni;
use common\models\UtlTipologia;
use common\models\UtlUtente;

use Exception;
use Yii;
use common\models\UtlEvento;
use common\models\UtlEventoSearch;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\debug\models\timeline\DataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

use common\models\EvtSchedaCoc;
use common\models\UplTipoMedia;
use common\models\UplMedia;
use yii\web\UploadedFile;
use common\models\ConSchedaCocDocumenti;
use common\models\SalaComunaleCap;
use common\models\SalaOperativaEsterna;
use GuzzleHttp\Client;
use kartik\mpdf\Pdf;

class EventoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'denyCallback' => function ($rule, $action) {
                            if (Yii::$app->user) {
                                Yii::error(json_encode(Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->getId())));
                                Yii::$app->user->logout();
                            }
                            return $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
                        },
                        'rules' => [
                            [
                                'allow' => true,
                                'actions' => ['index', 'map', 'view', 'list-eventi-map'],
                                'permissions' => ['listEventi']
                            ],

                                'roles' => ['@']
                            ],
                        ],
                ];
    }

    public function actionListEventiMap()
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return UtlEvento::find()
                ->where(['!=', 'stato', 'Chiuso'])
                ->andWhere(['is_public' => 1])
                ->joinWith(['tipologia'])
                ->asArray()
                ->all();
        }

    }

