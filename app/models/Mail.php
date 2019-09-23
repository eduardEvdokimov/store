<?php

namespace app\models;

class Mail{
    
    private $transport;
    private $mailer;
    private $message;
    private $from = 'eduard.evdokimov@inbox.ru';

    public function __construct($to)
    {
        $transport = (new \Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
            ->setUsername('eduard.evdokimov@inbox.ru')
            ->setPassword('kosmas746');

        $mailer = new \Swift_Mailer($transport);
        $message = new \Swift_Message();

        $this->to = $to;
        $this->transport = $transport;
        $this->mailer = $mailer;
        $this->message = $message;

    }

    public function sendConfirmEmail($code)
    {


        ob_start();
        $href_confirm = HOST . '/signup/confirm?kode='.$code;

        require VIEWS .  '/Mail/confirm_email.php';

        $mailBody = ob_get_clean();
        
        

        $message = (new \Swift_Message())
        ->setSubject('Подтвердите адрес электронной почты')
        ->setFrom($this->from, 'BestStore Smart')
        ->setTo($this->to)
        ->setBody($mailBody, 'text/html');
       
        $this->mailer->send($message);
    }

    public function sendRestorePassword($to){}

    public function sendConfirmRegister($to){}
}