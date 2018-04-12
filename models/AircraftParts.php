<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "AircraftParts".
 *
 * @property string $id
 * @property string $name Название группы ["Крыло", "Нос"]
 *
 * @property Consumers[] $consumers
 */
class AircraftParts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AircraftParts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumers()
    {
        return $this->hasMany(Consumers::className(), ['aircraftPart_id' => 'id']);
    }
}
