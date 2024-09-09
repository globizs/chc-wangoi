<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class SignupForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $status;
    public $reset_password;
    public $new_password;
    public $permissions;

    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.', 'on' => 'create'],
            ['username', 'customUnique', 'on' => 'update'],
            ['username', 'string', 'min' => 6, 'max' => 255],

            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            [['password', 'new_password'], 'string', 'min' => 6],

            [['status'], 'integer', 'min' => 9, 'max' => 10],
            [['id', 'reset_password', 'permissions'], 'safe'],
        ];
    }

    public function customUnique($attribute, $params)
    {
        if(User::find()->where([$attribute=>$this->$attribute])->andFilterWhere(['!=', 'id', $this->id])->exists()) {
            $this->addError($attribute, 'This '.strtoupper($attribute).' already exists.');
        }
    }

    // this function only to be used for adding staff users. Do not use for creating student user account!
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $rnd = Yii::$app->security->generateRandoMString(6);
        $user->username = $this->username;
        $user->email = $this->username . $rnd . '@domain.com';
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if($user->save()) {
            return $user->id;
        } else {
            return null;
        }
    }
}
