<?php

require dirname(__DIR__) . '/vendor/app/Db.php';

class Chat
{
    public static function sendHeaders($connection, $headers)
    {
        if(empty($headers) || empty($connection))
            die('-');

        $headersArr = explode("\r\n", $headers);

        foreach ($headersArr as $header) {
            if(preg_match("#Sec-WebSocket-Key:\s(?<key>\S+)#i", $header, $m)){
                $key = $m['key'];
                break;
            }
        }

        $hKey = base64_encode(pack('H*', sha1($key.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $sendHeaders = "HTTP/1.1 101 Switching Protocols\r\nUpgrade: websocket\r\nConnection: Upgrade\r\nSec-WebSocket-Accept: {$hKey}\r\n\r\n";

        socket_write($connection, $sendHeaders, strlen($sendHeaders));
    }

    public static function encode($payload, $type = 'text', $masked = false)
    {
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    public static function decode($data)
    {
        $unmaskedPayload = '';
        $decodedData = array();

        // estimate frame type:
        $firstByteBinary = sprintf('%08b', ord($data[0]));
        $secondByteBinary = sprintf('%08b', ord($data[1]));
        $opcode = bindec(substr($firstByteBinary, 4, 4));
        $isMasked = ($secondByteBinary[0] == '1') ? true : false;
        $payloadLength = ord($data[1]) & 127;

        // unmasked frame is received:
        if (!$isMasked) {
            return array('type' => '', 'payload' => '', 'error' => 'protocol error (1002)');
        }

        switch ($opcode) {
            // text frame:
            case 1:
                $decodedData['type'] = 'text';
                break;

            case 2:
                $decodedData['type'] = 'binary';
                break;

            // connection close frame:
            case 8:
                $decodedData['type'] = 'close';
                break;

            // ping frame:
            case 9:
                $decodedData['type'] = 'ping';
                break;

            // pong frame:
            case 10:
                $decodedData['type'] = 'pong';
                break;

            default:
                return array('type' => '', 'payload' => '', 'error' => 'unknown opcode (1003)');
        }

        if ($payloadLength === 126) {
            $mask = substr($data, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($data, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($data[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($data, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }

        /**
         * We have to check for large frames here. socket_recv cuts at 1024 bytes
         * so if websocket-frame is > 1024 bytes we have to wait until whole
         * data is transferd.
         */
        if (strlen($data) < $dataLength) {
            return false;
        }

        if ($isMasked) {
            for ($i = $payloadOffset; $i < $dataLength; $i++) {
                $j = $i - $payloadOffset;
                if (isset($data[$i])) {
                    $unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
                }
            }
            $decodedData['payload'] = $unmaskedPayload;
        } else {
            $payloadOffset = $payloadOffset - 4;
            $decodedData['payload'] = substr($data, $payloadOffset);
        }

        return $decodedData;
    }

    public static function createTmpFile($userName)
    {
        $fileHash = md5(mt_rand(0000, 9999));
        $headers =  date('Y-m-d h:i:s') . "\r\n";
        $headers .= $userName;
        self::writeHeadersFile($fileHash, $headers);
        return $fileHash;
    }

    public static function writeHeadersFile($fileHash, $head)
    {
        $filePath = dirname(__DIR__) . '/tmp/chats/tmp/' . $fileHash . '.txt';
        fclose(fopen($filePath, 'w+b'));
        $file = fopen($filePath, 'wb');
        $fileData = $head . "\r\n\r\n";
        fwrite($file,$fileData);
        fclose($file);
    }

    public static function issetTmpFile($fileHash)
    {
        $filePath = dirname(__DIR__) . '/tmp/chats/tmp/' . $fileHash . '.txt';
        return file_exists($filePath);
    }

    public static function removeTmpFile($fileHash)
    {
        $filePath = dirname(__DIR__) . '/tmp/chats/tmp/' . $fileHash . '.txt';
        unlink($filePath);
    }


    public static function addMsg($fileName, $nameUser, $message, $folder)
    {
        $filePath = dirname(__DIR__) . '/tmp/chats/tmp/' . $fileName . '.txt';
        if(!file_exists($filePath)){
            $filePath = dirname(__DIR__) . '/tmp/chats/' . $folder . '/' . $fileName . '.txt';
            if(!file_exists($filePath)){
                return;
            }
        }

        $dataFile = file_get_contents($filePath);
        $dataFile .= $nameUser . '#|&' . $message . '#|&' . date('Y-m-d H:i:s') . "\r\n";
        $f = fopen($filePath, 'r+b');
        fwrite($f, $dataFile);
        fclose($f);
    }

    public static function send($connection, $msg, $type)
    {
        $dataSend = json_encode(['msg' => $msg, 'time' => date('H:i'), 'type' => $type]);
        $msg = self::encode($dataSend);
        @socket_write($connection, $msg);
    }

    public static function moveFileToAdmin($admin_id, $fileName)
    {
        $filePath = dirname(__DIR__) . '/tmp/chats/tmp/' . $fileName . '.txt';
        $folder = dirname(__DIR__) . '/tmp/chats/' . $admin_id;
        $newPath = $folder . '/' . $fileName . '.txt';
        if(!file_exists($folder))
            mkdir($folder);

        if(file_exists($filePath)){
            rename($filePath, $newPath);
        }
    }

    public static function addDb($admin_id, $hashFile)
    {
        $file = $hashFile . '.txt';
        $db = self::connectDb();
        $sql = $db->prepare("INSERT INTO chats (admin_id, chat_name) VALUES (?,?)");
        $sql->execute([$admin_id, $file]);
    }

    public static function connectDb()
    {
        $config = require dirname(__DIR__) . '/config/db.php';
        $connect = sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['dbname']);
        return new \PDO($connect, $config['login'], $config['password'], $config['attr']);
    }
}