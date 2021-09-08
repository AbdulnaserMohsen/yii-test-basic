<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;
/**
 * class RegisterForm 
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password_confirmation;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password','password_confirmation'], 'required'],
            ['username', 'string','min'=>4,'max'=>55],
            [['password','password_confirmation'], 'string','min'=>8, 'max'=>255],
            ['password_confirmation','compare', 'compareAttribute'=>'password']

        ];
    }

    public function register()
    {
        if ($this->validate())
        {
            $user = new User();
            $user->user_name = $this->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->access_token = Yii::$app->security->generateRandomString();
            if($user->save())
            {
                return true;
            }
            Yii::error("Not Registered " .VarDumper::dumpAsString($user->errors));
            return false;
        }
    }

}
