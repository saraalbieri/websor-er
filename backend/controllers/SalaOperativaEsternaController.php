<?php

namespace backend\controllers;

use common\models\SalaOperativaEsterna;
use common\models\SalaOperativaEsternaSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalaOperativaEsternaController implements the CRUD actions for SalaOperativaEsterna model.
 */
class SalaOperativaEsternaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    if(Yii::$app->user){
                        Yii::$app->user->logout();
                    }
                    return $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'verbs' => ['GET'],
                        'permissions' => ['listSalaOperativaEsterna']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'verbs' => ['POST','GET'],
                        'permissions' => ['updateSalaOperativaEsterna']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'permissions' => ['createSalaOperativaEsterna']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => ['deleteSalaOperativaEsterna']
                    ],                    
                ]
            ],
        ];
    }

    /**
     * Lists all SalaComunaleCap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalaOperativaEsternaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalaComunaleCap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SalaComunaleCap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalaOperativaEsterna();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SalaComunaleCap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SalaComunaleCap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalaComunaleCap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalaComunaleCap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalaOperativaEsterna::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
