<template>
   <div>
       <div class="photo mb-1" :style="style"></div>
        <div class="form-group" v-if="~~edit">
            <div class="custom-file">
                <input type="file" class="custom-file-input" :class="{'is-invalid' : errors.photo}" id="photoFile" ref="input" @change="upload">
                <label class="custom-file-label" for="photoFile">Изменить фото</label>
                <div class="invalid-feedback" v-if="errors.photo">{{errors.photo[0]}}</div>
            </div>
        </div>
   </div>
</template>

<script>
    export default {
        props: ['photo', 'edit'],
        computed: {
            style(){
                return this.photo ? { 'background-image': 'url('+this.photo+')'} : {}
            }
        },
        data(){
            return {
                errors: {},
                img: this.photo
            }
        },
        methods: {
            async upload(){
                this.errors = {}
                const formData = new FormData()
                formData.append('photo', this.$refs.input.files[0])
                try{
                    const {data} = await axios.post('/profile/photo', formData)
                    this.img = data
                }catch(e){
                    this.errors = e.response.data.errors
                }
            }
        }
    }
</script>
