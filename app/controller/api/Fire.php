<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Fire extends ApiController {
  
  public function realtime() {
    $serviceAccount = ServiceAccount::fromJsonFile(PATH .'firebase_credentials.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();

    // $db = $firebase->getDatabase();
    // $reference = $db->getReference('cs/1');
    // $reference->set([
    //    'date' => date('Y-m-d H:i:s'),
    // ]);

    $messaging = $firebase->getMessaging();
        
    $messaging->send($message);
    print_r($messaging);
    die;
  }
  
}