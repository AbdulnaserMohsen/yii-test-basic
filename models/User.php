<?php

namespace app\models;

use Yii;
use \yii\helpers\VarDumper;

/**
 * This is the model class for table "my_users".
 *
 * @property int $id
 * @property string $user_name
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public $password_confirmation;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['user_name', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['user_name', 'email', 'password','password_confirmation'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            // username, email and password are all required in "register" scenario
            [['user_name', 'password','password_confirmation'], 'required', 'on' => self::SCENARIO_REGISTER],
            ['password_confirmation','compare', 'compareAttribute'=>'password', 'on' => self::SCENARIO_REGISTER],

            // username and password are required in "login" scenario
            [['user_name', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            
            [['user_name', 'password', 'auth_key', 'access_token'], 'required'],
            [['user_name'], 'string','min'=>4, 'max' => 55],
            [['user_name'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This User Name123456 has already been taken.'],
            [['password', 'auth_key', 'access_token'], 'string', 'min'=>8 ,'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        //return self::find()->where(['id'=> $id])->one();
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['access_token'=> $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        //return self::find()->where(['user_name'=> $username])->one();
        return self::findOne(['user_name'=> $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function register()
    {
        $user = new User();
        $user->user_name = $this->user_name;
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
