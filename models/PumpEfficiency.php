<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PumpEfficiency".
 *
 * @property string $id
 * @property double $QCurQmax Qтек/Qmax
 * @property double $pumpEfficiency КПД насоса
 * @property double $pumpEfficiencyRK КПД насоса + РК
 */
class PumpEfficiency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PumpEfficiency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QCurQmax', 'pumpEfficiency', 'pumpEfficiencyRK'], 'number'],
            [['QCurQmax'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'QCurQmax' => 'Qтек/Qmax',
            'pumpEfficiency' => 'КПД насоса',
            'pumpEfficiencyRK' => 'КПД насоса + РК',
        ];
    }
}
