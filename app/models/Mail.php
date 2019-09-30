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

    public function cacheConfirmEmail($code)
    {
        $path = TMP . '/mail/confirmed/' . date('h:i:s||d-m-Y') . '.txt';
        $data = HOST . '/signup/confirm?code='.$code;
        file_put_contents($path, $data);
    }

    public function sendConfirmEmail($code, $type = false)
    {
        $type = ($type) ? '&fast' : '';

        ob_start();
        $href_confirm = HOST . '/signup/confirm?code='.$code . $type;

        require VIEWS .  '/Mail/confirm_email.php';

        $mailBody = ob_get_clean();
        
        $message = (new \Swift_Message())
        ->setSubject('Подтвердите адрес электронной почты')
        ->setFrom($this->from, 'BestStore Smart')
        ->setTo($this->to)
        ->setBody($mailBody, 'text/html');
       
        $this->mailer->send($message);
    }

    public function sendRestorePassword($email, $name, $code)
    {
        ob_start();
        

        require VIEWS .  '/Mail/restore_pass_code.php';

        $mailBody = ob_get_clean();
        
        

        $message = (new \Swift_Message())
        ->setSubject('Код восстановления пароля')
        ->setFrom($this->from, 'BestStore Smart')
        ->setTo($this->to)
        ->setBody($mailBody, 'text/html');
       
        $this->mailer->send($message);
    }

    public function sendConfirmRegister($to){}
}