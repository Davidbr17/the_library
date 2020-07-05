<template>
    <b-modal id="lendBook" hide-footer centered :title='row != null ? "Select a user to lend "+ row.name +"  book":""'>
       <b-form>
            <b-form-group
                label="User:"
            >
                <b-form-select :state="$v.user_id.required" v-model.trim="$v.user_id.$model" :options="users"></b-form-select>
                <div class="error" v-if="!$v.user_id.required">Field is required</div>
            </b-form-group>
            
            <b-button class="mt-2 w-100" @click="store() " :disabled="$v.$invalid" variant='success'>Save</b-button>
        </b-form>
    </b-modal>
</template>


<script>
import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
import { required } from 'vuelidate/lib/validators'
export default {
    props:['users','row'],
    data () {
        return {
            user_id:null
        }
    },
    computed:{
    },
    validations: {
        user_id:{
            required
        }
    },
    watch:{
    },
    methods:{
        store(){
            let id = this.row.id
            let user_id = this.user_id
            axios.put("/lend_book",{id,user_id}
            ).then(response => {
                if(response.data.success){
                    this.$store.commit('increment')
                    this.$bvModal.hide('lendBook')	
                }
            })
        },
    },
    components:{
    },
    mounted() {
    }
}
</script>