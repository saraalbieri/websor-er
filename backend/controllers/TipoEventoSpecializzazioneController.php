<?php

namespace backend\controllers;

use Yii;
use common\models\ConTipoEventoSpecializzazione;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoEventoSpecializzazioneTipologieController implements the CRUD actions for ConTipoEventoSpecializzazione model.
 */
class TipoEventoSpecializzazioneController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    if(Yii::$app->user){
                        Yii::error("Tentativo di accesso non autorizzato tipo evento-specializzazione user: ".Yii::$app->user->getId());
                        Yii::$app->user->logout();                        
                    }
                    return $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'permissions' => ['viewTipoEventoSpecializzazione']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'permissions' => ['createTipoEventoSpecializzazione']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'permissions' => ['updateTipoEventoSpecializzazione']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => ['deleteTipoEventoSpecializzazione']
                    ],
                ]        
            ]    
        ];
    }

    /**
     * Lists all ConTipoEventoSpecializzazione models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConTipoEventoSpecializzazione();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConTipoEventoSpecializzazione model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ConTipoEventoSpecializzazione model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConTipoEventoSpecializzazione();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ConTipoEventoSpecializzazione model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ConTipoEventoSpecializzazione model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ConTipoEventoSpecializzazione model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConTipoEventoSpecializzazione the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConTipoEventoSpecializzazione::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
