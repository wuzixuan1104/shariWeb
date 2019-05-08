<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;

class Fire extends ApiController {
  public $firebase = null;
  public function __construct() {
    
    $serviceAccount = ServiceAccount::fromJsonFile(PATH .'firebase_credentials.json');
    $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
  }

  public function notify() {
    $token = Input::post('token');
    if (!$token)
      return false;

    

    $messaging = $this->firebase->getMessaging();

    $messaging->send(CloudMessage::fromArray([
        'token' => $assign['notify_token'],
        'data' => [
            'title' => 'Shari 傳送訊息',
            'body' => $posts['text'],
            'icon' => '/asset/img/me.png',
            'click_action' => config('other', 'baseUrl') . 'chat',
        ],
    ]));
  }

  public function realtime() {
    $messaging = $this->firebase->getMessaging();

    $db = $this->firebase->getDatabase();
    $db->getReference('cs/1')
       ->set([
            'date' => date('Y-m-d H:i:s', strtotime('+3 min')),
        ]);

    $posts = Input::post();
    
    $assign = [
        'ae_sn' => '',
        'notify_token' => 'fJrRjIzAiGs:APA91bErclLyTMBw_ZqykvVpVAsB11LfqYydpQyQ9Ynr1VkDfhGfrpE7NjxL6WfXEDKb1WT7sRNio1cTZvIjIqHukvDH3tz8SWUl8GN8fmd67Ikx3i1TqcYWVzBH40RD3IezzoyN6Xj5',
        'unread_cnt' => 0,
    ];
    
    $messaging->send(CloudMessage::fromArray([
        'token' => $assign['notify_token'],
        'data' => [
            'title' => 'Shari 傳送訊息',
            'body' => $posts['text'],
            'icon' => '/asset/img/me.png',
            'click_action' => 'https://trip.web.shari.tw/chat/2',
        ],
    ]));
    
    return true;
  }
  
}