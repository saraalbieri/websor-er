<?php

namespace common\models\app;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class AppConfig extends \yii\db\ActiveRecord
{
    
    public function init() {
        parent::init();
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => 'sammaye\audittrail\LoggableBehavior'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_config';
    }
    

    public function rules() {
        return [
            [['key','value','label'], 'required'],
            [['key','label'], 'string'],
            [['value'], 'safe'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    
    

}
