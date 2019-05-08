<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;

class Fire extends ApiController {
  public $firebase = null;
  public function __construct() {
    parent::__construct();

    $serviceAccount = ServiceAccount::fromJson(json_encode(config('firebase', 'credentials')));
    $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
  }

  public function config() {
    return config('firebase', 'config');
  }

  public function notify() {
    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params,  'token',   'Token')->isVarchar(190);
      Validator::need($params,  'title',  '標題')->isVarchar(190);
      Validator::need($params, 'body', '內容')->isText();
    });

    $db = $this->firebase->getDatabase();
    $db->getReference('trip_web')
       ->push([
            'title' => $params['title'],
            'body' => $params['body'],
            'token' => $params['token'],
            'date' => date('Y-m-d H:i:s'),
        ]);

    $messaging = $this->firebase->getMessaging();

    $messaging->send(CloudMessage::fromArray([
      'token' => $params['token'],
      'data' => [
          'title' => $params['title'],
          'body' => $params['body'],
          'icon' => '/asset/img/me.png',
          'click_action' => config('other', 'baseUrl') . 'chat',
      ],
    ]));

    return true;
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