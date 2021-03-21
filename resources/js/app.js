require('./bootstrap');
require('jquery-mask-plugin')
window.Vue = require('vue')
window.moment = require('moment-timezone')
require('moment/locale/ru')
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);
Vue.use(VueToast, { position: 'top' });
import Multiselect from 'vue-multiselect'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
Vue.component('multiselect', Multiselect)
Vue.component('profile-photo', require('./components/ProfilePhoto.vue').default)
Vue.component('profile-docs', require('./components/ProfileDocuments.vue').default)
Vue.component('lesson', require('./components/Lesson.vue').default)
Vue.component('teacher-schedule', require('./components/TeacherSchedule.vue').default)
Vue.component('student-schedule', require('./components/StudentSchedule.vue').default)
Vue.component('notifications', require('./components/Notifications.vue').default)
Vue.component('tickets', require('./components/Tickets.vue').default)
Vue.component("video-chat", require("./components/VideoChat.vue").default);
Vue.component("repetitors-list", require("./components/RepetitorsList.vue").default);
Vue.component("button-timer", require("./components/ButtonTimer.vue").default);
Vue.component("profile", require("./components/Profile.vue").default);
Vue.component("chat", require("./components/Chat.vue").default);
import VueMoment from 'vue-moment'
Vue.use(VueMoment, { moment })
const app = new Vue({
    el: '#app',
});
let ww;

$(document).ready(function(){
    ww = $(window).width()
    $('.phone').mask('+7 000-000-00-00')
    $('[data-toggle="tooltip"]').tooltip()
    $('form.confirm').on('submit', function(e){
        if(!confirm('Подтвердите удаление')){
            e.preventDefault()
            return false
        }
    })
    $('#app').on('change', '.custom-file-input.simple-file', function(e){
        const count = e.target.files.length - 1
        let text = e.target.files[0].name
        if(count > 0) text += ' (+'+count+')'
        $(this).next().html(text)
    })
    $('.sidebar-toggle').click(function(e){
        e.preventDefault();
        toggleSidebar()
    })
    $('.sidebar').mouseover(function(){
        $('body').addClass('sidebar-open')
    })
    $('.sidebar').mouseleave(function(){
        $('body').removeClass('sidebar-open')
    })
    // $(window).resize(function(e){
    //     ww = $(window).width()
    //     if(ww < 991 && $('body').hasClass('sidebar-open'))
    //     $('body').removeClass('sidebar-open')
    // })
    // toggleSidebar()
})

function toggleSidebar(){
    if(ww > 991){
        $('body').addClass('sidebar-active').toggleClass('sidebar-open')
    }else{
        $('body').removeClass('sidebar-open').toggleClass('sidebar-active')
    }
}