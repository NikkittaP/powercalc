<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VehicleLayout;
use yii\helpers\VarDumper;

/**
 * VehicleLayoutSearch represents the model behind the search form of `app\models\VehicleLayout`.
 */
class VehicleLayoutSearch extends VehicleLayout
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vehicleLayoutName_id', 'consumer_id'], 'integer'],
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
    public function search($params, $vehicleLayoutName_id)
    {
        $query = VehicleLayout::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutName_id])->indexBy('id');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $sort = $dataProvider->getSort();
        $newSort = ['id'=>$sort->attributes['id']]; //'vehicleLayoutName_id'=>$sort->attributes['vehicleLayoutName_id'], 'consumer_id'=>$sort->attributes['consumer_id']];
        $sort->attributes = $newSort;

        return $dataProvider;
    }
}
