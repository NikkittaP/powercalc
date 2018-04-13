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
    public $flightModeAttrs;
    public $flightModeAttrNames;

    public function attributes()
    {
        $architecturesNames = ArchitecturesNames::find()->orderBy('id')->all();
        $this->architecureAttrs = [];
        foreach ($architecturesNames as $architecturesName)
        {
            $this->architecureAttrs[]='architectureToVehicleLayouts_'.$architecturesName->id;
            $this->architecureAttrNames[]=$architecturesName->name;
        }

        $flightModeNames = FlightModes::find()->orderBy('id')->all();
        $this->flightModeAttrs = [];
        foreach ($flightModeNames as $flightModeName)
        {
            $this->flightModeAttrs[]='flightModesToVehicleLayout_'.$flightModeName->id;
            $this->flightModeAttrNames[]=$flightModeName->name;
        }

        return array_merge(
            parent::attributes(),
            $this->architecureAttrs,
            $this->flightModeAttrs
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

        $strArchitecureAttr=[];
        foreach ($this->architecureAttrs as $architecureAttr)
            $strArchitecureAttr[]=$architecureAttr;
        
        $strFlightModeAttr=[];
        foreach ($this->flightModeAttrs as $flightModeAttr)
                $strFlightModeAttr[]=$flightModeAttr;

        $out = [
            [['vehicleLayoutName_id', 'consumer_id'], 'required'],
            [['vehicleLayoutName_id', 'consumer_id'], 'integer'],
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consumers::className(), 'targetAttribute' => ['consumer_id' => 'id']],
            [['vehicleLayoutName_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehiclesLayoutsNames::className(), 'targetAttribute' => ['vehicleLayoutName_id' => 'id']],
            [$strArchitecureAttr, 'safe'],
            [$strFlightModeAttr, 'safe'],
        ];

        return $out;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $architecureAttrLabels = [];
        for($i = 0;$i < count($this->architecureAttrs);$i++)
            $architecureAttrLabels[$this->architecureAttrs[$i]] = $this->architecureAttrNames[$i];
            
        $flightModeAttrLabels = [];
        for($i = 0;$i < count($this->flightModeAttrs);$i++)
            $flightModeAttrLabels[$this->flightModeAttrs[$i]] = $this->flightModeAttrNames[$i];

        $staticLabels= [
            'id' => 'ID',
            'vehicleLayoutName_id' => 'Компоновка',
            'consumer_id' => 'Потребитель',
        ];

        return array_merge($staticLabels,$architecureAttrLabels, $flightModeAttrLabels);
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