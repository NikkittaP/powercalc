<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Vehicles".
 *
 * @property string $id
 * @property string $name Название аппарата ["B737", "Дрон 1", "МС-21 Базовый"]
 *
 * @property VehiclesLayoutsNames[] $vehiclesLayoutsNames
 */
class Vehicles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Vehicles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiclesLayoutsNames()
    {
        return $this->hasMany(VehiclesLayoutsNames::className(), ['vehicle_id' => 'id']);
    }
}
