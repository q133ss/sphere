<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Фамилия</label>
                    <input :class="{'is-invalid': errors.surname}" v-model="model.surname" type="text" class="form-control" placeholder="Фамилия">
                    <div v-if="errors.surname" class="invalid-feedback">{{errors.surname[0]}}</div>
                </div>
                <div class="form-group">
                    <label>Имя</label>
                    <input :class="{'is-invalid': errors.name}" v-model="model.name" type="text" class="form-control" placeholder="Имя">
                    <div v-if="errors.name" class="invalid-feedback">{{errors.name[0]}}</div>
                </div>
                <div class="form-group">
                    <label>Отчество</label>
                    <input :class="{'is-invalid': errors.lastname}" v-model="model.lastname" type="text" class="form-control" placeholder="Отчество">
                    <div v-if="errors.lastname" class="invalid-feedback">{{errors.lastname[0]}}</div>
                </div>
                <div class="form-group">
                    <label>Ваш возраст</label>
                    <input :class="{'is-invalid': errors.age}" v-model="model.age" type="number" step="1" min="1" max="110" class="form-control" placeholder="Возраст">
                    <div v-if="errors.age" class="invalid-feedback">{{errors.age[0]}}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Дополнительная информация</label>
                    <textarea v-model="model.about" name="about" rows="3" class="form-control" noresize placeholder="Напишите что-нибудь о себе"></textarea>
                </div>
                <div class="form-group">
                    <label>Стоимость урока</label>
                        <input :class="{'is-invalid': errors.lesson_price}" v-model="model.lesson_price" type="number" placeholder="Стоиомть урока" min="0" name="lesson_price" class="form-control">
                        <div v-if="errors.lesson_price" class="invalid-feedback">{{errors.lesson_price[0]}}</div>
                    </div>
                <div class="form-group">
                    <label>Что вы преподаёте?</label>
                    <multiselect
                        v-model="model.subjects"
                        :options="subjects"
                        trackBy="id"
                        searchable
                        multiple
                        label="name"
                        :show-labels="false"
                        :close-on-select="false"
                        placeholder="Выберите из списка">
                    </multiselect>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>E-mail</label>
                    <input v-model="model.email" disabled type="email" class="form-control" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <label>Номер телефона</label>
                    <input :class="{'is-invalid': errors.phone}" v-model="model.phone" type="text" class="form-control phone" placeholder="Телефон">
                    <div v-if="errors.phone" class="invalid-feedback">{{errors.phone[0]}}</div>
                </div>
                <hr>
                <p class="text-muted">Изменить пароль</p>
                <div class="form-group">
                    <input :class="{'is-invalid': errors.password}" v-model="model.password" type="password" name="password" class="form-control" placeholder="Новый пароль">
                    <div v-if="errors.password" class="invalid-feedback">{{errors.password[0]}}</div>
                </div>
                <div class="form-group">
                    <input type="password" v-model="model.password_confirmation" class="form-control" placeholder="Подтверждение пароля">
                </div>
            </div>
        </div>
        <hr>
        <div class="text-right">
            <button class="btn btn-sm btn-primary" @click="save">Сохранить</button>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            model: {},
            errors: {},
            subjects: []
        }
    },
    async created(){
        this.model = this.$store.getters.user
        const {data} = await axios.get('/subjects')
        this.subjects = data
    },
    methods:{
        async save(){
            this.errors = {}
            this.model.subjects_ids = this.model.subjects.map(s => s.id)
            try{
                const {data} = await axios.post('/users/updateProfile', this.model)
                this.$store.commit('setUser', data)
                this.$toast.success('Профиль успешно обновлен')
            }catch(e){
                this.errors = e.response.data.errors
                this.$toast.error('Ошибка')
            }
        }
    }
}
</script>