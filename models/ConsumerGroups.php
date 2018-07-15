<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ConsumerGroups".
 *
 * @property int $id
 * @property string $name Название группы потребителей
 *
 * @property Consumers[] $consumers
 */
class ConsumerGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ConsumerGroups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
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
        return $this->hasMany(Consumers::className(), ['consumerGroup_id' => 'id']);
    }
}
