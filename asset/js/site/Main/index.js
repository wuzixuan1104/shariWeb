$(function () {
    function tokenSendToServer(url, params) {
        this.url = url,
        this.params = params,

        this.ready = function(sent) {
            window.localStorage.setItem('sentToServer', sent ? '1' : '0');
        },

        this.isSend = function() {
            return window.localStorage.getItem('sentToServer') === '1';
        },

        this.send = function(token) {
            if (!this.isSend()) {
              console.log('將 Token 更新至資料庫');
              this.ready(true);
            } else {
              console.log('Token 已是最新狀態');
            }
        }
    }

    getFirebaseConfig().then(function(config) {
        const server = new tokenSendToServer('url', '123');

        firebase.initializeApp(config);

        const messaging = firebase.messaging();

        getCurrentToken();

        // Token 更新
        messaging.onTokenRefresh(function() {
            messaging.getToken().then(function(refreshedToken) {
                console.log('Token 重新更新');
                //將token更新 呼叫後端ＡＰＩ
                server.ready(false);
                server.send(refreshedToken);

            }).catch(function(err) {
                console.log('無法取得最新 Token ', err);
            });
        });

        // 前景收到推播訊息
        messaging.onMessage(function(payload) {
            console.log('收到推播：', payload);

            const notify = payload.notification;
            const data = payload.data;

            if (data.us_profile_id != '3' ) {
                //不在最新推播的頁面需要變動頁面
                const notification = new Notification(notify.title, {
                    body: notify.body,
                    icon: data.icon
                });

                notification.onclick = function (e) {
                    e.preventDefault();
                    console.log('trigger change user');
                    // window.open(payload.data.click_action);
                }
            } else {
                console.log('目前已在所屬位置');
            }
        });

        // realtime DB
        var csRef = firebase.database().ref('cs/1');
        csRef.on('value', function(snapshot) {
            var key = snapshot.key;
            console.log('key:', key);
            console.log(snapshot.val());
            $('.name').text('Shari');
            $('.date').text(snapshot.val().date);
        });

        // 取得目前的 Token
        function getCurrentToken() {
            messaging.getToken().then(function(token) {
                if (token) {
                    console.log(token);
                    server.send(token);
                } else {
                    setRequestPermission();
                    server.ready(false);
                }
            }).catch(function(err) {
                console.log('取得 Token 發生錯誤. ', err);
                server.ready(false);
            });
        }

        // 設置推播權限
        function setRequestPermission() {
            messaging.requestPermission().then(function() {
                getCurrentToken();
                console.log('允許推播的權限');

            }).catch(function(err) {
                console.log('設定推播發生錯誤', err);
            });
        }
    }); 

    function getFirebaseConfig() {
        return $.getJSON('/firebaseConfig.json').then(function(data){
            return data;
        });
    }
});
