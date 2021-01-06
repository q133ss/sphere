require('./bootstrap');
require('jquery-mask-plugin')
require('./board')
window.Vue = require('vue')
window.moment = require('moment-timezone')
require('moment/locale/ru')
Vue.component('profile-photo', require('./components/ProfilePhoto.vue').default)
Vue.component('profile-docs', require('./components/ProfileDocuments.vue').default)
Vue.component('lesson', require('./components/Lesson.vue').default)
// Vue.component('lesson-chat', require('./components/LessonChat.vue').default)
// Vue.component('lesson-video', require('./components/LessonVideo.vue').default)
// Vue.component('lesson-board', require('./components/LessonBoard.vue').default)
Vue.component('teacher-schedule', require('./components/TeacherSchedule.vue').default)
Vue.component('student-schedule', require('./components/StudentSchedule.vue').default)
Vue.component('notifications', require('./components/Notifications.vue').default)
Vue.component("video-chat", require("./components/VideoChat.vue").default);
import VueMoment from 'vue-moment'
Vue.use(VueMoment, { moment })
const app = new Vue({
    el: '#app',
});

$(document).ready(function(){
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
})