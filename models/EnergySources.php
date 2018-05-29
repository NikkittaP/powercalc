<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnergySources".
 *
 * @property int $id
 * @property string $name Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]
 * @property int $energySourceType_id Является ли электросистемой
 * @property double $qMax Qmax для расчёта Q располагаемого
 * @property double $pumpPressureNominal Pнас ном
 * @property double $pumpPressureWorkQmax Pнас раб при Qmax
 * @property double $NMax Nmax для электросистем
 * @property int $energySourceLinked_id Электросистема от которой берет энергию
 *
 * @property Energysourcetypes $energySourceType
 * @property Energysources $energySources
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
            [['name', 'energySourceType_id'], 'required'],
            [['energySourceType_id', 'energySourceLinked_id'], 'integer'],
            [['qMax', 'pumpPressureNominal', 'pumpPressureWorkQmax', 'NMax'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['energySourceType_id'], 'exist', 'skipOnError' => true, 'targetClass' => Energysourcetypes::className(), 'targetAttribute' => ['energySourceType_id' => 'id']],
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
            'energySourceType_id' => 'Тип энергосистемы',
            'qMax' => 'Q max',
            'pumpPressureNominal' => 'Pнас ном',
            'pumpPressureWorkQmax' => 'Pнас раб при Qmax',
            'NMax' => 'N max',
            'energySourceLinked_id' => 'Энергопитание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnergySourceType()
    {
        return $this->hasOne(Energysourcetypes::className(), ['id' => 'energySourceType_id']);
    }

    public function getEnergySourceLinked()
    {
        return $this->hasOne(Energysources::className(), ['id' => 'energySourceLinked_id']);
    }
}
