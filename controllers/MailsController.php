<?php

namespace app\controllers;

use yii\rest\ActiveController;

use app\models\MailGearman;

class MailsController extends ActiveController
{
    public $modelClass = 'app\models\MailGearman';

}