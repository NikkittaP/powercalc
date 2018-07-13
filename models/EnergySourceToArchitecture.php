<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnergySource_to_Architecture".
 *
 * @property int $id
 * @property int $energySource_id
 * @property int $architectureName_id
 * @property int $energySourceLinked_id Электросистема от которой берет энергию
 * @property double $qMax Qmax для расчёта Q располагаемого
 * @property double $pumpPressureNominal Pнас ном
 * @property double $pumpPressureWorkQmax Pнас раб при Qmax
 * @property double $NMax Nmax для электросистем
 *
 * @property ArchitecturesNames $architectureName
 * @property EnergySources $energySource
 * @property EnergySources $energySourceLinked
 */
class EnergySourceToArchitecture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EnergySource_to_Architecture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['energySource_id', 'architectureName_id'], 'required'],
            [['energySource_id', 'architectureName_id', 'energySourceLinked_id'], 'integer'],
            [['qMax', 'pumpPressureNominal', 'pumpPressureWorkQmax', 'NMax'], 'number'],
            [['architectureName_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchitecturesNames::className(), 'targetAttribute' => ['architectureName_id' => 'id']],
            [['energySource_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnergySources::className(), 'targetAttribute' => ['energySource_id' => 'id']],
            [['energySourceLinked_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnergySources::className(), 'targetAttribute' => ['energySourceLinked_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'energySource_id' => 'Energy Source ID',
            'architectureName_id' => 'Название архитектуры',
            'energySourceLinked_id' => 'Энергопитание',
            'qMax' => 'Q max',
            'pumpPressureNominal' => 'Pнас ном',
            'pumpPressureWorkQmax' => 'Pнас раб при Qmax',
            'NMax' => 'N max',
        ];
    }

    public function getArchitectureName()
    {
        return $this->hasOne(ArchitecturesNames::className(), ['id' => 'architectureName_id']);
    }
    public function getEnergySource()
    {
        return $this->hasOne(EnergySources::className(), ['id' => 'energySource_id']);
    }
    public function getEnergySourceLinked()
    {
        return $this->hasOne(EnergySources::className(), ['id' => 'energySourceLinked_id']);
    }
}