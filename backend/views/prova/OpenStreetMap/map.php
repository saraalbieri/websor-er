<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UtlEventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mappa eventi calamitosi in corso';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="map-canvas" class="site-index" ng-app="mapAngular">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->FilteredActions->showCartografico) : ?>
        <?php echo '<span class="carto-link">' . Html::a('Cartografia', ['/sistema-cartografico?lat=' . $model->lat . '&lon=' . $model->lon], ['class' => 'btn btn-warning', 'style' => 'margin-bottom: 10px']) . '</span>'; ?>
    <?php endif; ?>
    <div id="map-canvas" class="site-index" ng-app="mapAngular">

        <ui-gmap-google-map center='{latitude: <?php echo $model->lat; ?>, longitude: <?php echo $model->lon; ?>}' zoom='10'>

            <ui-gmap-marker coords="{latitude: <?php echo $model->lat; ?>, longitude: <?php echo $model->lon; ?>}" idkey="<?php echo $model->id; ?>"> </ui-gmap-marker>
            <?php
            $sottoeventi = UtlEvento::find()->where(['idparent' => $model->id])->all();
            foreach ($sottoeventi as $sttevt) {

                switch ($sttevt->stato) {
                    case 'Allarme':
                        $st = 'allarme';
                        break;
                    case 'Emergenza':
                        $st = 'emergenza';
                        break;
                    default:
                        $st = 'preallarme';
                        break;
                }
                ?>
                <ui-gmap-marker coords="{latitude: <?php echo $sttevt->lat; ?>, longitude: <?php echo $sttevt->lon; ?>}" idkey="<?php echo $sttevt->id; ?>" options="{
                                icon: '<?php echo Yii::$app->request->baseUrl . '/images/map-markers/evento-' . $sttevt->tipologia_evento  . '.png'; ?>'
                            }"> </ui-gmap-marker>
                <?php
            }
            ?>

        </ui-gmap-google-map>
    </div>

</div>
