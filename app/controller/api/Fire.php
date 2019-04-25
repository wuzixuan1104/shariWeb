<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;

class Fire extends ApiController {
  
  public function realtime() {
    $serviceAccount = ServiceAccount::fromJsonFile(PATH .'firebase_credentials.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();

    $messaging = $firebase->getMessaging();

    $db = $firebase->getDatabase();

    do {
        if (!$msgs = $db->getReference('msg')->getValue())
            break;

        foreach ($msgs as $key => $msg) {
            //先立馬刪除
            $db->getReference('msg/' . $key)->remove();

            // 用 token 取得 cs_chat_room
            // $room = $this->chat_model->getRoom($msg['type'], $msg['token']);
            // 更新 room.unread_cnt++ 

            // 用 profile_id 取得所有 cs_chat_assign
            
            $assigns = [
                [
                    'ae_sn' => '',
                    'notify_token' => 'fJrRjIzAiGs:APA91bErclLyTMBw_ZqykvVpVAsB11LfqYydpQyQ9Ynr1VkDfhGfrpE7NjxL6WfXEDKb1WT7sRNio1cTZvIjIqHukvDH3tz8SWUl8GN8fmd67Ikx3i1TqcYWVzBH40RD3IezzoyN6Xj5',
                    'unread_cnt' => 0,
                ]
            ];

            foreach ($assigns as $assign) {
                // assign.unread_cnt++
                // assign.notify 推播（目前都要推播）
                $message = CloudMessage::fromArray([
                    'token' => $assign['notify_token'],
                    'data' => [
                        'title' => 'Shari 傳送訊息',
                        'body' => $msg['text'],
                        'icon' => '/asset/img/me.png',
                        'click_action' => 'https://trip.web.shari.tw/chat/2',
                    ],
                ]);

                $messaging->send($message);

                
            }
            die (json_encode(['finish']));
            // 取得客服 token 
                   
            // 新增 cs_chat_dialog
            // $params = [
            //     'cs_chat_room_id' => $room['id'],
            //     'ae_sn' => $assign['ae_sn'],
            //     'us_profile_id' => $room['us_profile_id'],
            //     'content' => $msgs['text'],
            // ]

            echo $key . "\r\n";
            break;
        }

    } while ($msgs);

    // do {
        

    //     $msg = array_shift(array);
    //     die;
    // } while ($msgs);

    die;
  }


  
}