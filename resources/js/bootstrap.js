try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = require('pusher-js');
Pusher.logToConsole = true;
// window.pusher = new Pusher('28c7685e9cd2cfb49a84', {
//     cluster: 'ap3',
//     forceTLS: true,
//     auth: {
//         headers: { 'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content }
//     }
// })
// const auth_meta = document.head.querySelector('meta[name="auth"]')
// if(auth_meta) window.channel = pusher.subscribe('user.' + auth_meta.content)

import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});