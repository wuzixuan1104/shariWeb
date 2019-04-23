$(function () {
    function token2Server() {
        this.set2Send = function(sent) {
            window.localStorage.setItem('sentToServer', sent ? '1' : '0');
        },

        this.isSend = function() {
            return window.localStorage.getItem('sentToServer') === '1';
        },

        this.send = function(token) {
            if (!this.isSend()) {
              console.log('將 Token 更新至資料庫');
              this.set2Send(true);
            } else {
              console.log('Token 已是最新狀態');
            }
        }
    }

    getFirebaseConfig().then(function(config) {
        firebase.initializeApp(config);

        console.log(firebase);
        const messaging = firebase.messaging();

        getCurrentToken();
        
        // Token 更新
        messaging.onTokenRefresh(function() {
            messaging.getToken().then(function(refreshedToken) {
                console.log('Token 重新更新');
                //將token更新 呼叫後端ＡＰＩ
                setTokenSentToServer(false);
                sendTokenToServer(refreshedToken);

            }).catch(function(err) {
                console.log('無法取得最新 Token ', err);
            });
        });

        // 前景收到推播訊息
        messaging.onMessage(function(payload) {
            console.log('收到推播：', payload);
            const title = payload.data.title;
            const options = {
                body: payload.data.status,
                icon: payload.data.icon,        
            };
        });


        // realtime DB
        var csRef = firebase.database().ref('cs/1');
        csRef.on('value', function(snapshot) {
            var key = snapshot.key;
            console.log('key:', key);
            console.log(snapshot.val());
        });


        // 取得目前的 Token
        function getCurrentToken() {
            messaging.getToken().then(function(token) {
                if (token) {
                    sendTokenToServer(token);
                } else {
                    setRequestPermission();
                    setTokenSentToServer(false);
                }
            }).catch(function(err) {
                console.log('取得 Token 發生錯誤. ', err);
                setTokenSentToServer(false);
            });
        }

        // 設置推播權限
        function setRequestPermission() {
            messaging.requestPermission().then(function() {
                getCurrentToken();
                console.log('允許推播的權限');

            }).catch(function(err) {
                console.log('不允許推播', err);
            });
        }
    }); 

    function getFirebaseConfig() {
        return $.getJSON('/firebaseConfig.json').then(function(data){
            return data;
        });
    }
    
    function sendTokenToServer(currentToken) {
        if (!isTokenSentToServer()) {
          console.log('將 Token 更新至資料庫');
          setTokenSentToServer(true);
        } else {
          console.log('Token 已是最新狀態');
        }
    }

    function isTokenSentToServer() {
        return window.localStorage.getItem('sentToServer') === '1';
    }

    function setTokenSentToServer(sent) {
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
    } 
});
