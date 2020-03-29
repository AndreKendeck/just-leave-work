window.axios = require("axios");
window.collect = require("collect.js");
window.Vue = require("vue");
window.moment = require("moment");
window.Chart = require("chart.js");
window.voca = require("voca");

moment.updateLocale("en", {
    week: {
        dow: 1
    }
});

Vue.component("VueLoader", require("vue-element-loading"));
Vue.component("LeaveCard", require("../components/LeaveCard"));
Vue.component("UserLeaveCard", require("../components/UserLeaveCard"));
Vue.component("WeekSelector", require("../components/WeekSelector"));

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error("CSRF token not found");
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
