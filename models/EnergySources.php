<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnergySources".
 *
 * @property string $id
 * @property string $name Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]
 * @property int $isElectric Является ли электросистемой
 * @property double $qMax Qmax для расчёта Q располагаемого
 * @property double $pumpPressureNominal Pнас ном
 * @property double $pumpPressureWorkQmax Pнас раб при Qmax
 *
 * @property ArchitectureToVehicleLayout[] $architectureToVehicleLayouts
 */
class EnergySources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EnergySources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['qMax', 'pumpPressureNominal', 'pumpPressureWorkQmax'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['isElectric'], 'boolean'],
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
            'isElectric' => 'Электросистема?',
            'qMax' => 'Q max',
            'pumpPressureNominal' => 'Pнас ном',
            'pumpPressureWorkQmax' => 'Pнас раб при Qmax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchitectureToVehicleLayouts()
    {
        return $this->hasMany(ArchitectureToVehicleLayout::className(), ['energySource_id' => 'id']);
    }
}
