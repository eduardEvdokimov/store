<?php

require dirname(__DIR__) . '/libs/Chat.php';
require dirname(__DIR__) . '/libs/functions.php';

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP );
socket_bind($socket, '192.168.0.105', 7000);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 100);
socket_listen($socket);


$conectionSockets = [];
$chatFiles = [];
$chats = [];
$idsAdmin = [];
$write = $except = null;
$count = 0;

while(1){
    $newConnections = $conectionSockets;
    $newConnections[] = $socket;

    socket_select($newConnections, $write, $except, 1);

    if(in_array($socket, $newConnections)){

        $connection = socket_accept($socket);

        $headers = socket_read($connection, 1024);
        Chat::sendHeaders($connection, $headers);

        unset($newConnections[array_search($socket, $newConnections)]);

        $conectionSockets[] = $connection;
    }

    foreach ($newConnections as $key => $conn) {
        $dataSocket = Chat::decode(socket_read($conn, 1024));

        if($dataSocket['type'] == 'close'){
            socket_write($conn, Chat::encode('', 'close'));
            socket_shutdown($conn);
            socket_close($conn);
            unset($conectionSockets[array_search($conn, $conectionSockets)]);

            foreach ($chats[$chatFiles[$conn]] as $key => $c){
                if($conn == $c){
                    unset($chats[$chatFiles[$conn]][$key]);
                }else{
                    if($key == 'user'){
                        Chat::send($c, 'Консультант отключился от чата', 'info');
                    }else{
                        Chat::send($c, 'Пользователь отключился от чата', 'info');
                    }
                }
            }

            if(empty($chats[$chatFiles[$conn]])){
                unset($chats[$chatFiles[$conn]]);
            }

            unset($chatFiles[$conn]);
            if(Chat::issetTmpFile($chatFiles[$conn])){
                Chat::removeTmpFile($chatFiles[$conn]);
            }
            continue;
        }

        $dataMsg = json_decode($dataSocket['payload'], 1);

        if($dataMsg['from'] == 'user'){
            if($dataMsg['type'] == 'connect'){
                $fileHash = Chat::createTmpFile($dataMsg['name']);
                $chatFiles[$conn] = $fileHash;
                $chats[$chatFiles[$conn]]['user'] = $conn;
            }

            if($dataMsg['type'] == 'msg'){
                if(isset($chats[$chatFiles[$conn]]['admin'])){
                    Chat::send($chats[$chatFiles[$conn]]['admin'], $dataMsg['msg'], 'msg');
                }
                Chat::addMsg($chatFiles[$conn], $dataMsg['name'], $dataMsg['msg'], $idsAdmin[$chats[$chatFiles[$conn]]['admin']]);
            }

            if($dataMsg['type'] == 'write'){
                if(isset($chats[$chatFiles[$conn]]['admin'])){
                    Chat::send($chats[$chatFiles[$conn]]['admin'], '', 'write');
                }
            }

        }else{
            if($dataMsg['type'] == 'connect'){
                $chatFiles[$conn] = $dataMsg['hash'];
                $chats[$dataMsg['hash']]['admin'] = $conn;
                $idsAdmin[$conn] = $dataMsg['admin_id'];
                Chat::moveFileToAdmin($dataMsg['admin_id'], $dataMsg['hash']);
                Chat::addDb($dataMsg['admin_id'], $dataMsg['hash']);
                Chat::send($chats[$chatFiles[$conn]]['user'], "Консультант {$dataMsg['name']} подключен к чату!", 'info');
            }

            if($dataMsg['type'] == 'msg'){
                if(isset($chats[$chatFiles[$conn]]['user'])){
                    Chat::send($chats[$chatFiles[$conn]]['user'], $dataMsg['msg'], 'msg');
                }

                Chat::addMsg($chatFiles[$conn], $dataMsg['name'], $dataMsg['msg'], $idsAdmin[$conn]);

            }

            if($dataMsg['type'] == 'write'){
                if(isset($chats[$chatFiles[$conn]]['user'])){
                    Chat::send($chats[$chatFiles[$conn]]['user'], '', 'write');
                }
            }

        }

    }

    var_dump($chats);

}
die;