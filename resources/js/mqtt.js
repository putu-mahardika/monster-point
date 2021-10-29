let mqtt = require('mqtt');
let host = 'monstercode.ip-dynamic.com';
let port = 9001;
let protocol = 'mqqt://';
let fullHost = `${protocol}${host}:${port}`;
let client = null;
window.mqttUserKey = '';
window.mqttOnMessage = () => {};
let baseTopic = '/monsterpoint/';
const option = {
    username: 'monster_sby',
    password: 'P@ssw0rd'
}

try {
    client = mqtt.connect(fullHost, option);
} catch (error) {
    // console.log('Connection error', error);
}

client.on('connect', (connect) => {
    console.log('Connected');
    client.subscribe(`${baseTopic}#`);
})

client.on('disconnect', (packet) => {
    // console.log(packet);
});

client.on('error', (params) => {
    // console.log('Error', params)
})

client.on('message', function (topic, message) {
    if (isValidJson(message.toString())) {
        let data = JSON.parse(message.toString());
        if (topic == `${baseTopic}${mqttUserKey}/tickets` || topic == `${baseTopic}${mqttUserKey}/comments`) {
            Toast.fire({
                icon: 'info',
                title: data.title ?? "",
                text: data.text ?? ""
            });
            mqttOnMessage();
        }
    }
})

function isValidJson(string) {
    try {
        JSON.parse(string);
        return true;
    } catch (e) {
        return false;
    }
}
