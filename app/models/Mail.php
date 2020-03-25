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
            ->setUsername()
            ->setPassword();

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

    public function sendResponse($comment, $response)
    {
        $message = (new \Swift_Message())
        ->setSubject('Ответ на Ваш отзыв')
        ->setFrom($this->from, 'BestStore Smart')
        ->setTo($this->to);

        $inline_attachment = \Swift_Image::fromPath(HOST . '/images/' . $comment['img']);
        $cid = $message->embed($inline_attachment);
        ob_start();
        require VIEWS .  '/Mail/response_comment.php';
        $mailBody = ob_get_clean();
        $message->setBody($mailBody, 'text/html');
        $this->mailer->send($message);
    }

    public function sendCheckoutOrder($products)
    {
         $message = (new \Swift_Message())
        ->setSubject('Оформлен заказ')
        ->setFrom($this->from, 'BestStore Smart')
        ->setTo($this->to);

        $simbolCurrency = \store\Register::get('simbolCurrency');
        ob_start();
        require VIEWS .  '/Mail/checkoutOrder.php';
        $mailBody = ob_get_clean();
        $message->setBody($mailBody, 'text/html');
        $this->mailer->send($message);
    }


}
