<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;
 
    public function rules()
    {
        return [
            [['newPassword','confirmNewPassword', 'oldPassword'], 'required'],
            [['newPassword','confirmNewPassword'], 'string', 'min' => 5],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'confirmNewPassword' => 'Repeat New Password',
        ];
    }
}
