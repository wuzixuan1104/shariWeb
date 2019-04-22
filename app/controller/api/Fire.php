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
    $deviceToken = 'cQP9tjgSnn4:APA91bHllq5fdKEnllCaIyyVh1roESpFOHZtUj_uuAXZDI-HRsuh8Ow-LmZLo1NUVbkSUEYqOvT3L8ZBTSZARZA1GC5FSZQjT8bV9BhvGGXZq7Gd2PN-mlKwRwyuB8pVbTBioV7j0tul';
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