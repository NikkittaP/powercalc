<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Constants".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $description
 */
class Constants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Constants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'description'], 'string', 'max' => 255],
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
            'value' => 'Значение',
            'description' => 'Описание',
        ];
    }

    public static function getValue($name){
        $data = Constants::find()->where(['name' => $name])->one();
        if ($data != null)
        {
            if ($name == "defaultChartColors")
            {
                return explode(',',$data->value);
            }

            return $data->value;
        }
        else
            return null;
    }
}
