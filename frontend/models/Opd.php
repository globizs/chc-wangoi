<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "opd".
 *
 * @property int $id
 * @property int $opd_registration_no
 * @property string|null $abha_id
 * @property string $patient_name
 * @property string $care_taker_name
 * @property int $age
 * @property string|null $gender
 * @property int|null $religion_id
 * @property string $address
 * @property string $diagnosis
 * @property int $fee_amount
 * @property string $opd_date
 * @property int $opd_session_id
 * @property int $department_id
 * @property int $created_by_user_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string $is_active
 *
 * @property User $createdByUser
 * @property Department $department
 * @property OpdSession $opdSession
 * @property Religion $religion
 */
class Opd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_registration_no', 'patient_name', 'care_taker_name', 'age', 'address', 'diagnosis', 'fee_amount', 'opd_date', 'opd_session_id', 'department_id'], 'required'],
            [['opd_registration_no', 'age', 'religion_id', 'fee_amount', 'opd_session_id', 'department_id'], 'integer'],
            [['gender', 'address', 'diagnosis'], 'string'],
            [['opd_date'], 'string', 'min' => 10, 'max' => 11],
            [['abha_id'], 'match', 'pattern' => '/^\d{14}$/', 'message' => 'ABHA ID must be a 14-digit number'],
            [['patient_name', 'care_taker_name'], 'string', 'max' => 255],
            [['is_active'], 'string', 'max' => 1],
            [['opd_registration_no'], 'unique'],
            [['religion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Religion::class, 'targetAttribute' => ['religion_id' => 'id']],
            [['opd_session_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpdSession::class, 'targetAttribute' => ['opd_session_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'opd_registration_no' => 'OPD reg. no.',
            'abha_id' => 'ABHA ID',
            'patient_name' => 'Patient name',
            'care_taker_name' => 'Caretaker name',
            'age' => 'Age',
            'gender' => 'Gender',
            'religion_id' => 'Religion',
            'address' => 'Address',
            'diagnosis' => 'Diagnosis',
            'fee_amount' => 'Fee (Rs.)',
            'opd_date' => 'OPD date',
            'opd_session_id' => 'OPD session',
            'department_id' => 'Department',
            'created_by_user_id' => 'Entry by',
        ];
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[OpdSession]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpdSession()
    {
        return $this->hasOne(OpdSession::class, ['id' => 'opd_session_id']);
    }

    /**
     * Gets query for [[Religion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReligion()
    {
        return $this->hasOne(Religion::class, ['id' => 'religion_id']);
    }
}
