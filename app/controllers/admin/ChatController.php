<?php

namespace app\controllers\admin;

class ChatController extends MainController
{
    public function indexAction()
    {
        $filePath = TMP . "/chats/tmp";
        $files = [];
        $newChats = [];

        $d = dir($filePath);
        while (false !== ($entry = $d->read())) {
            if($entry != '.' && $entry != '..'){
                $files[] = $entry;
            }
        }
        $d->close();

        if(!empty($files)){
            foreach ($files as $file) {
                $data = explode("\r\n\r\n", file_get_contents($filePath . '/' . $file), 2);
                $headers = $data[0];
                $body = $data[1];
                $headersArr = explode("\r\n", $headers);
                $date = new \DateTime($headersArr[0]);
                $chat['date'] = $date->format('H:i:s d-m-Y');
                $chat['name'] = $headersArr[1];
                $chat['msg'] = explode('#|&', $body)[1];
                $chat['hash'] = str_replace('.txt', '', $file);
                $newChats[] = $chat;
            }
        }

        $dbChat = $this->db->query("SELECT * FROM chats WHERE admin_id={$_SESSION['user']['id']}");

        $this->setParams(['newChats' => $newChats]);

    }

    public function viewAction()
    {
        $filePath = TMP . '/chats/tmp/' . $_GET['chat'] . '.txt';
        if(empty($_GET['chat']) || !file_exists($filePath))
            redirect();

        $data = explode("\r\n\r\n", file_get_contents($filePath), 2);

        $headers = $data[0];
        $userName = explode("\r\n", $headers)[1];
        $messages = explode("\r\n", trim($data[1], "\r\n"));
        $arrMessages = [];

        foreach ($messages as $message){
            $dataMessage = explode('#|&', $message);
            $arrMessage['type'] = ($dataMessage[0] != $_SESSION['user']['name']) ? 'your-msg' : 'my-msg';
            $arrMessage['msg'] = $dataMessage[1];
            $dataOdj = new \DateTime($dataMessage[2]);
            $arrMessage['date'] = $dataOdj->format('H:i');
            $arrMessages[] = $arrMessage;
        }

        $this->setParams(['userName' => $userName, 'messages' => $arrMessages, 'chatHash' => $_GET['chat']]);
    }
}