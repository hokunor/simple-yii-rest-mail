<?php
namespace app\common\jobs;
use Yii;
use filsh\yii2\gearman\JobBase;

use app\models\MailGearman;


class MailJob extends JobBase
{
    public function execute(\GearmanJob $job = null)
    {
        $data = unserialize($job->workload());
        $params = $data->getParams();
        $mail = MailGearman::findOne($params['data']);

        Yii::$app->mailer->compose()
            ->setTo($mail->to)
            ->setFrom($mail->from)
            ->setSubject($mail->subject)
            ->setTextBody($mail->message)
            ->send();
        $mail->status =1;
        $mail->save();
        return true;
    }
}

/*yii gearman/start --fork=true // start the workers as a daemon and fork proces
yii gearman/restart --fork=true // restart workers
yii gearman/stop // stop workers*/