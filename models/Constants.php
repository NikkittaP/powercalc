<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Constants".
 *
 * @property int $id
 * @property string $name
 * @property string $value
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
            [['name', 'value'], 'string', 'max' => 255],
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
        ];
    }

    public static function getValue($name){
        $data = Constants::find()->where(['name' => $name])->one();
        if ($data != null)
            return $data->value;
        else
            return null;
    }
}
