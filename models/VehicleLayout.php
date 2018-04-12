<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "VehicleLayout".
 *
 * @property string $id
 * @property string $vehicleLayoutName_id
 * @property string $consumer_id
 *
 * @property ArchitectureToVehicleLayout[] $architectureToVehicleLayouts
 * @property FlightModesToVehicleLayout[] $flightModesToVehicleLayouts
 * @property Consumers $consumer
 * @property VehiclesLayoutsNames $vehicleLayoutName
 */
class VehicleLayout extends \yii\db\ActiveRecord
{
    public $architecureAttrs;
    public $architecureAttrNames;

    public function attributes()
    {
        $architecturesNames = ArchitecturesNames::find()->orderBy('id')->all();
        $this->architecureAttrs = [];
        foreach ($architecturesNames as $architecturesName)
        {
            $this->architecureAttrs[]='architectureToVehicleLayouts_'.$architecturesName->id;
            $this->architecureAttrNames[]=$architecturesName->name;
        }
        return array_merge(
            parent::attributes(),
            $this->architecureAttrs
        );
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VehicleLayout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $string=[];
        foreach ($this->architecureAttrs as $architecureAttr)
            $string[]=$architecureAttr;

        $out = [
            [['vehicleLayoutName_id', 'consumer_id'], 'required'],
            [['vehicleLayoutName_id', 'consumer_id'], 'integer'],
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consumers::className(), 'targetAttribute' => ['consumer_id' => 'id']],
            [['vehicleLayoutName_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehiclesLayoutsNames::className(), 'targetAttribute' => ['vehicleLayoutName_id' => 'id']],
            [$string, 'safe'],
        ];

        return $out;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $arc = [];
        for($i = 0;$i < count($this->architecureAttrs);$i++)
            $arc[$this->architecureAttrs[$i]] = $this->architecureAttrNames[$i];

        $arr= [
            'id' => 'ID',
            'vehicleLayoutName_id' => 'Компоновка',
            'consumer_id' => 'Потребитель',
        ];

        return array_merge($arr,$arc);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchitectureToVehicleLayouts()
    {
        return $this->hasMany(ArchitectureToVehicleLayout::className(), ['vehicleLayout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlightModesToVehicleLayouts()
    {
        return $this->hasMany(FlightModesToVehicleLayout::className(), ['vehicleLayout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumer()
    {
        return $this->hasOne(Consumers::className(), ['id' => 'consumer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleLayoutName()
    {
        return $this->hasOne(VehiclesLayoutsNames::className(), ['id' => 'vehicleLayoutName_id']);
    }
}