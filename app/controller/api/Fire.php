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

    /* realtime */
    $db = $firebase->getDatabase();
    $reference = $db->getReference('cs/1');
    $reference->set([
       'date' => date('Y-m-d H:i:s'),
    ]);


    /* notification */
    $deviceToken = 'fJrRjIzAiGs:APA91bErclLyTMBw_ZqykvVpVAsB11LfqYydpQyQ9Ynr1VkDfhGfrpE7NjxL6WfXEDKb1WT7sRNio1cTZvIjIqHukvDH3tz8SWUl8GN8fmd67Ikx3i1TqcYWVzBH40RD3IezzoyN6Xj5';
    $messaging = $firebase->getMessaging();
    $message = CloudMessage::fromArray([
        'token' => $deviceToken,
        'data' => [
            'icon' => '/asset/img/me.png',
            'title' => 'Shari 傳送訊息',
            'status' => '你今天吃飽沒？',
            'click_action' => 'https://trip.web.shari.tw/',
        ],
    ]);

    $messaging->send($message);
    

    print_r($messaging);
    die;
  }
  
}