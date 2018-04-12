<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "FlightModes".
 *
 * @property string $id
 * @property string $name Название режима полета ["Руление", "Взлёт"]
 * @property double $reductionFactor Коэффициент понижения оборотов
 *
 * @property FlightModesToVehicleLayout[] $flightModesToVehicleLayouts
 */
class FlightModes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FlightModes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reductionFactor'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'reductionFactor' => 'Коэффициент понижения оборотов',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlightModesToVehicleLayouts()
    {
        return $this->hasMany(FlightModesToVehicleLayout::className(), ['flightMode_id' => 'id']);
    }
}
