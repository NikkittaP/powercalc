<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnergySourceTypes".
 *
 * @property int $id
 * @property string $name Название источника энергии ["Гидросистема", "Электросистема"]
 */
class EnergySourceTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EnergySourceTypes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
}
