<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consumers;

/**
 * ConsumersSearch represents the model behind the search form of `app\models\Consumers`.
 */
class ConsumersSearch extends Consumers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'aircraftPart_id'], 'integer'],
            [['name'], 'safe'],
            [['efficiencyHydro', 'efficiencyElectric', 'q0', 'qMax'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $selectedConsumerGroup)
    {
        $query = Consumers::find();

        if ($selectedConsumerGroup == 0)
            $query = Consumers::find();
        else
            $query = Consumers::find()->where(['consumerGroup_id' => $selectedConsumerGroup]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'aircraftPart_id' => $this->aircraftPart_id,
            'efficiencyHydro' => $this->efficiencyHydro,
            'efficiencyElectric' => $this->efficiencyElectric,
            'q0' => $this->q0,
            'qMax' => $this->qMax,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
