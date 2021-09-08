<?php 

namespace app\handler;

class LanguageHandler extends \yii\base\Behavior
{
    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'handleBeginRequest',
        ];
    }

    public function handleBeginRequest($event) 
    {
        if(\Yii::$app->getRequest()->getCookies()->has('lang'))
        {
            \Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('lang');
        }
    }
}

?>