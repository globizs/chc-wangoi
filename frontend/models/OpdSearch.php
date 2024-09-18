<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Opd;

/**
 * OpdSearch represents the model behind the search form of `frontend\models\Opd`.
 */
class OpdSearch extends Opd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_registration_no', 'age', 'religion_id', 'fee_amount', 'opd_session_id', 'department_id', 'created_by_user_id'], 'integer'],
            [['abha_id', 'patient_name', 'care_taker_name', 'gender', 'address', 'diagnosis', 'opd_date', 'is_active'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params)
    {
        $query = Opd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->is_active = '1';

        $this->opd_date = date('d-m-Y') . ' - ' . date('d-m-Y');

        $this->load($params);

        $startDate = $endDate = null;

        if ($this->opd_date) {
            $dateRange = explode(' - ', $this->opd_date);
            $startDate = date('Y-m-d', strtotime($dateRange[0]));
            $endDate = date('Y-m-d', strtotime($dateRange[1]));
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'is_active' => $this->is_active,
            'opd_registration_no' => $this->opd_registration_no,
            'age' => $this->age,
            'religion_id' => $this->religion_id,
            'fee_amount' => $this->fee_amount,
            'opd_session_id' => $this->opd_session_id,
            'department_id' => $this->department_id,
            'created_by_user_id' => $this->created_by_user_id,
            'abha_id' => str_replace(' ', '', $this->abha_id),
            'gender' => $this->gender,
        ]);

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'care_taker_name', $this->care_taker_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'diagnosis', $this->diagnosis])
            ->andFilterWhere(['BETWEEN', 'DATE(opd_date)', $startDate, $endDate]);

        return $dataProvider;
    }
}
