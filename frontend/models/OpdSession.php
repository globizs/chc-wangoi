<?php

namespace frontend\models;

/**
 * This is the model class for table "opd_session".
 *
 * @property int $id
 * @property string $name
 * @property int $fee
 * @property string $current_session
 * @property string $is_active
 */
class OpdSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opd_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fee'], 'required'],
            [['fee'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['current_session', 'is_active'], 'string', 'max' => 1],
            [['start_time'], 'match', 'pattern' => '/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', 'message' => 'The time must be in 24-hour format (HH:MM).'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'fee' => 'Fee (Rs.)',
            'current_session' => 'Current Session',
            'is_active' => 'Is Active',
        ];
    }
}
