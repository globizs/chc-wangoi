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
            [['age', 'religion_id', 'fee_amount', 'opd_session_id', 'department_id', 'created_by_user_id', 'contact_no'], 'integer'],
            [['opd_registration_no', 'abha_id', 'patient_name', 'care_taker_name', 'gender', 'address', 'diagnosis', 'opd_date', 'is_active', 'aadhaar_no'], 'safe'],
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

        $this->opd_date = date('d-M-Y') . ' - ' . date('d-M-Y');

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

        $ori_opd_registration_no = $this->opd_registration_no;
        $opd_reg_no = explode('/', $this->opd_registration_no);
        $this->opd_registration_no = $opd_reg_no[0];
        $this->serial_no = isset($opd_reg_no[1]) ? $opd_reg_no[1] : null;

        // grid filtering conditions
        $query->andFilterWhere([
            'is_active' => $this->is_active,
            'serial_no' => $this->serial_no,
            'opd_registration_no' => $this->opd_registration_no,
            'religion_id' => $this->religion_id,
            'fee_amount' => $this->fee_amount,
            'opd_session_id' => $this->opd_session_id,
            'department_id' => $this->department_id,
            'created_by_user_id' => $this->created_by_user_id,
            'abha_id' => str_replace(' ', '', $this->abha_id),
            'aadhaar_no' => str_replace(' ', '', $this->aadhaar_no),
            'gender' => $this->gender,
            'contact_no' => $this->contact_no,
        ]);

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'care_taker_name', $this->care_taker_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'diagnosis', $this->diagnosis])
            ->andFilterWhere(['BETWEEN', 'DATE(opd_date)', $startDate, $endDate]);

        $this->opd_registration_no = $ori_opd_registration_no;

        return $dataProvider;
    }
}
