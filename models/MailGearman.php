<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use filsh\yii2\gearman\JobWorkload;
/**
 * ContactForm is the model behind the contact form.
 */
class MailGearman extends ActiveRecord  implements Linkable
{

/*    public $to;
    public $from;
    public $subject;
    public $body;
    public $attachment;
    public $status;
    public $priority;*/
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['to', 'from', 'subject', 'message'], 'required'],
            // email has to be a valid email address
            ['to', 'email'],
            ['from', 'email']
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['mails/view', 'id' => $this->id], true),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
      //  die;
        /* $priority range low =1 normal =2 high=3*/
        //background($name, $data = null, $priority = self::NORMAL, $unique = null)
            Yii::$app->gearman->getDispatcher()->background(
                'mailJob', new JobWorkload([
                'params' => [
                    'data' => $this->id
                ]
            ]), $this->priority
            );
    }
}
