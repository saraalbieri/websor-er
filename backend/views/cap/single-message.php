<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


use common\models\cap\ConCapMessageIncident;
use common\models\cap\ConCapMessageReference;
use common\models\cap\CapMessages;
/* @var $this yii\web\View */
/* @var $model common\models\UtlCategoriaAutomezzoAttrezzatura */

$list_incidents = [];
$list_references = [];

$this->title = $model->identifier;
$this->params['breadcrumbs'][] = ['label' => 'Messaggi', 'url' => ['list-message',[
    'raggruppamento' => $model->resource->raggruppamento,
    'sort' => '-sent_rome_timezone'
]]];
$this->params['breadcrumbs'][] = $this->title;


$obj = \common\utils\cap\item\Base::getBaseItemFromProfile( $model->resource->profile , $model->xml_content);

?>
<div class="cap-mappatura">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?php echo ($model->resource) ? Html::encode( $model->resource->raggruppamento ) . " - " .  Html::encode( $model->resource->identifier ) : ''; ?></p>
    
    <p>
        <?php if(Yii::$app->user->can('createSegnalazione')) echo Html::a('Crea segnalazione', [
            '/segnalazione/create', 'from_cap' => $model->id
        ], [
            'class' => 'btn btn-primary'
        ]) ?>
    </p>

    <div class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="segnalazioni-map-canvas" class="site-index m20h" ng-app="segnalazione" ng-controller="segnalazioneViewController as ctrl">

                <ui-gmap-google-map center='{latitude: <?php echo $model->lat; ?>, longitude: <?php echo $model->lon; ?>}' zoom='10'>

                    <ui-gmap-marker coords="{latitude: <?php echo $model->lat; ?>, longitude: <?php echo $model->lon; ?>}" idkey="<?php echo $model->id; ?>"> </ui-gmap-marker>

                </ui-gmap-google-map>

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'url',
                    'lat',
                    'lon',
                    [
                        'label'=>'Indirizzo',
                        'attribute' => 'id',
                        'value' => function($model) use ($obj){
                            return @$obj->info[$model->info_n]['address'];
                        }
                    ],
                    'identifier',
                    [
                        'attribute' => 'sent_rome_timezone',
                        'value' => function($data) {
                            $d = \DateTime::createFromFormat('Y-m-d H:i:sP', $data->call_time);
                            if(is_bool($d)) return null;

                            $d->setTimezone( (new \DateTimeZone('Europe/Rome')) );
                            return $d->format('d/m/Y H:i:s');
                        }
                    ],[
                        'attribute' => 'call_time',
                        'value' => function($data) {
                            $d = \DateTime::createFromFormat('Y-m-d H:i:sP', $data->call_time);
                            if(is_bool($d)) return null;

                            $d->setTimezone( (new \DateTimeZone('Europe/Rome')) );
                            return $d->format('d/m/Y H:i:s');
                        }
                    ],
                    [
                        'attribute' => 'intervent_time',
                        'value' => function($data) {
                            $d = \DateTime::createFromFormat('Y-m-d H:i:sP', $data->intervent_time);
                            if(is_bool($d)) return null;

                            $d->setTimezone( (new \DateTimeZone('Europe/Rome')) );
                            return $d->format('d/m/Y H:i:s');
                        }
                    ],
                    [
                        'attribute' => 'arrival_time',
                        'value' => function($data) {
                            $d = \DateTime::createFromFormat('Y-m-d H:i:sP', $data->arrival_time);
                            if(is_bool($d)) return null;

                            $d->setTimezone( (new \DateTimeZone('Europe/Rome')) );
                            return $d->format('d/m/Y H:i:s');
                        }
                    ],
                    [
                        'attribute' => 'close_time',
                        'value' => function($data) {
                            $d = \DateTime::createFromFormat('Y-m-d H:i:sP', $data->close_time);
                            if(is_bool($d)) return null;

                            $d->setTimezone( (new \DateTimeZone('Europe/Rome')) );
                            return $d->format('d/m/Y H:i:s');
                        }
                    ],
                    'major_event',
                    'attribute'=>'profile',
                    'code_int',
                    'code_call',
                    'string_comune',
                    'string_provincia',
                    'formatted_status',
                    [
                        'attribute' => 'eventi_websor',
                        'label' => 'Eventi websor',
                        'format' => 'raw',
                        'value' => function($data) {
                            $q = Yii::$app->db->createCommand("SELECT distinct e.num_protocollo, e.id FROM con_evento_segnalazione ce 
                                LEFT JOIN utl_evento e ON e.id = ce.idevento
                                LEFT JOIN utl_segnalazione s ON s.id = ce.idsegnalazione
                                WHERE s.id_cap_message = :id_cap_message;", [':id_cap_message'=>$data->id]);
                            $res = $q->queryAll();
                            $ids = array_map(function($row){ 
                                return Html::a($row['num_protocollo'], [
                                    '/evento/view',
                                    'id' => $row['id']
                                ], [
                                    'class' => '',
                                    'target' => '_blank'
                                ]);
                            }, $res);
                            return implode(", ", $ids);
                        }
                    ],
                    'status',
                    'scheda',
                    [
                        'label'=>'Scheda aggiornata',
                        'attribute'=>'scheda_update'
                    ],
                    'sender',
                    'sender_name',
                    [
                        'label'=>'Categoria',
                        'attribute'=>'category'
                    ],
                    [
                        'label'=>'Descrizione',
                        'attribute'=>'description'
                    ],
                    'event',
                    'event_type',
                    'event_subtype',
                    'segnalatore',
                    [
                        'label'=>'msgType',
                        'attribute'=>'type'
                    ],
                    /*
                    <responseType>None</responseType>
     <urgency>Future</urgency>
     <severity>Unknown</severity>
     <certainty>Unknown</certainty>
     <audience>Messaggio destinato alla gestione del soccorso la cui pubblicazione non ?? autorizzata.</audience>
                     */
                    [
                        'label'=>'Restriction',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->restriction)) ? Html::encode($obj->restriction) : '';
                        }
                    ],
                    [
                        'label'=>'Scope',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->scope)) ? Html::encode($obj->scope) : '';
                        }
                    ],
                    [
                        'label'=>'Indirizzi destinatari',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            $addrs = [];
                            foreach ((array) $obj->addresses as $addr) {
                                if(is_string($addr)) $addrs[] = $addr;
                            }
                            return Html::encode(implode(", ",$addrs));
                        }
                    ],
                    [
                        'label'=>'Code',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return is_string($obj->code) ? Html::encode($obj->code) : '';
                        }
                    ],
                    [
                        'label'=>'Note',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return is_string($obj->note) ? Html::encode($obj->note) : '';
                        }
                    ],
                    [
                        'label'=>'responseType',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            $ress = [];
                            try {
                                foreach ((array) $obj->info[$model->info_n]['responseType'] as $res) {
                                    if(is_string($res)) $ress[] = $res;
                                }
                            } catch(\Exception $e) {
                                \Yii::error($e);
                            }

                            return Html::encode(implode(", ",$ress));
                        }
                    ],
                    [
                        'label'=>'urgency',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {

                            return (is_string($obj->info[$model->info_n]['urgency'])) ? Html::encode($obj->info[$model->info_n]['urgency']) : '';
                        }
                    ],
                    [
                        'label'=>'severity',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['severity'])) ? Html::encode($obj->info[$model->info_n]['severity']) : '';
                        }
                    ],
                    [
                        'label'=>'certainty',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['certainty'])) ? Html::encode($obj->info[$model->info_n]['certainty']) : '';
                        }
                    ],
                    [
                        'label'=>'audience',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['audience'])) ? Html::encode($obj->info[$model->info_n]['audience']) : '';
                        }
                    ],
                    [
                        'label'=>'language',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['language'])) ? Html::encode($obj->info[$model->info_n]['language']) : '';
                        }
                    ],
                    [
                        'label'=>'headline',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['headline'])) ? Html::encode($obj->info[$model->info_n]['headline']) : '';
                        }
                    ],
                    [
                        'label'=>'instruction',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['instruction'])) ? Html::encode($obj->info[$model->info_n]['instruction']) : '';
                        }
                    ],
                    [
                        'label'=>'web',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return (is_string($obj->info[$model->info_n]['web'])) ? Html::encode($obj->info[$model->info_n]['web']) : '';
                        }
                    ],
                    [
                        'label'=>'contact',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return "Contact viene rimosso per privacy";
                        }
                    ],
                    [
                        'label'=>'effective',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return !empty($obj->info[$model->info_n]['effective']) ? $obj->info[$model->info_n]['effective']->format('Y-m-d H:i') : '';
                        }
                    ],
                    [
                        'label'=>'onset',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {

                            return !empty($obj->info[$model->info_n]['onset']) ? $obj->info[$model->info_n]['onset']->format('Y-m-d H:i') : '';
                        }
                    ],
                    [
                        'label'=>'Scadenza',
                        'attribute'=>'id',
                        'value' => function($model) use ($obj) {
                            return !empty($obj->info[$model->info_n]['expires']) ? $obj->info[$model->info_n]['expires']->format('Y-m-d H:i') : '';
                        }
                    ],
                    [
                        'label'=>'EventCode',
                        'attribute'=>'id',
                        'format'=>'raw',
                        'value' => function($model) use ($obj) {
                            $html = '';

                            foreach ($obj->info[$model->info_n]['eventCodes'] as $key => $value) {
                                $html .= Html::encode($key) . ": " . Html::encode($value) . "<br />";
                            }

                            return $html;
                        }
                    ],
                    [
                        'label'=>'Parametri',
                        'attribute'=>'id',
                        'format'=>'raw',
                        'value' => function($model) use ($obj) {
                            $html = '';

                            foreach ($obj->info[$model->info_n]['parameters'] as $key => $value) {
                                $html .= ((is_string($key)) ? Html::encode($key) : '' )
                                . ": " . 
                                ((is_string($value)) ? Html::encode($value) : '' )
                                . "<br />";
                            }

                            return $html;
                        }
                    ],
                    [
                        'label'=>'Risorse',
                        'attribute'=>'id',
                        'format'=>'raw',
                        'value' => function($model) use ($obj) {
                            $html = '';
                            if(isset($obj->info[$model->info_n]['resource'])) {
                                foreach ($obj->info[$model->info_n]['resource'] as $value) {

                                    foreach ($value as $key => $v) {
                                        $html .= Html::encode($key) . ": " . Html::encode($v) . "<br />";
                                    }

                                    $html .= "<br /><hr /><br />";
                                }
                            }

                            return $html;
                        }
                    ]
                ],
            ]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3>Incidents</h3>
            <?php 
            $i = ConCapMessageIncident::find()->where(['id_cap_message'=>$model->id])->all();

            foreach ($i as $incident) {
                $m = CapMessages::findOne(['identifier'=>$incident->incident]);
                
                if($m) $list_incidents[] = $m->identifier;

                if($m) echo Html::a($m->identifier, [
                    'single-message', 'id' => $m->id
                ], [
                    'class' => '',
                    'target' => '_blank'
                ]) . "<br />";
            }
            ?>
            <h3>References</h3>
            <?php 
            $i = ConCapMessageReference::find()->where(['id_cap_message'=>$model->id])->all();

            foreach ($i as $reference) {
                $m = CapMessages::findOne(['identifier'=>$reference->reference]);
                
                if($m) $list_references[] = $m->identifier;

                if($m) echo Html::a($m->identifier, [
                    'single-message', 'id' => $m->id
                ], [
                    'class' => '',
                    'target' => '_blank'
                ]) . "<br />";
            }
            ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3>Messaggi collegati per incident</h3>
            <?php 
                $mrelated = ConCapMessageIncident::find()->where(['in', 'incident', $list_incidents])
                ->joinWith('message')->asArray()->all();
                foreach ($mrelated as $_m) {
                    if(
                        isset($_m['message']) &&
                        ( 
                            $_m['message']['id'] != $model->id || 
                            $_m['message']['info_n'] != $model->info_n
                        )
                    ) echo Html::a($_m['message']['identifier'], [
                        'single-message', 'id' => $_m['message']['id']
                    ], [
                        'class' => '',
                        'target' => '_blank'
                    ]) . "<br />";
                }
            ?>
        </div>

    </div>

    

</div>
