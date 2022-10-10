<?php

namespace backend\controllers;

use Yii;
use common\models\tblSezioneSpecialistica;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SezioneSpecialisticaController implements the CRUD actions for TblSezioneSpecialistica model.
 */

class SezioneSpecialisticaController extends Controller
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
                        Yii::error("Tentativo di accesso non autorizzato specializzazioni organizzazione: ".Yii::$app->user->getId());
                        Yii::$app->user->logout();
                    }
                    return $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'permissions' => ['viewSezioneSpecialistica']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'permissions' => ['createSezioneSpecialistica']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'permissions' => ['updateSezioneSpecialistica']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => ['deleteSezioneSpecialistica']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all TblSezioneSpecialistica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TblSezioneSpecialistica::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblSezioneSpecialistica model.
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
     * Creates a new TblSezioneSpecialistica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblSezioneSpecialistica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblSezioneSpecialistica model.
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
     * Deletes an existing TblSezioneSpecialistica model.
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
     * Finds the TblSezioneSpecialistica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblSezioneSpecialistica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblSezioneSpecialistica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}