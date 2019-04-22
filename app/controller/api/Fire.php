<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Fire extends ApiController {
  
  public function realtime() {
    $serviceAccount = ServiceAccount::fromJsonFile(PATH .'firebase_credentials.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();

    $db = $firebase->getDatabase();
    $reference = $db->getReference('users/PkjdDi1nVVYDi1XgBqZfVYGkIm82');
    // $snapshot = $reference->getSnapshot();
    // $value = $snapshot->getValue();
    $reference->set([
       'email' => 'test134@com.tw',
       'profile_picture' => 'https://app.domain.tld',
       'username' => 'test13'
    ]);

    // $snap = $db->getReference('users')->orderByChild('email')->equalTo('cherry51120@gmail.com')->getSnapshot()->getValue();
    
    // ->equalTo('cherry51120@gmail.com')->getSnapshot();
    // $value = $snap->hasChildren();
    print_r($reference);
    die;
  }
  
}