/*import Vue from 'vue'

//Main pages
import Emails from './components/Emails.vue';
import SendEmail from './components/SendEmail.vue'


const app = new Vue({
    el: '#app',
    components: { Emails, SendEmail }
});
*/

window.Vue = require('vue');
Vue.component('emails', require('./components/Emails.vue').default);
Vue.component('send-email', require('./components/SendEmail.vue').default);
const app = new Vue({
    el: '#app'

});
