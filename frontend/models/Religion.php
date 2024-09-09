<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "religion".
 *
 * @property int $id
 * @property string $name
 * @property string $is_active
 *
 * @property Opd[] $opds
 */
class Religion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'religion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['is_active'], 'string', 'max' => 1],
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
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Opds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpds()
    {
        return $this->hasMany(Opd::class, ['religion_id' => 'id']);
    }
}
