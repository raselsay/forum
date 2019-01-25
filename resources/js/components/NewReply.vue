<template>
<div>
    <div v-if="siginIn">
        <div class="form-group">
            <textarea v-model="body"
                      class="form-control"
                      cols="30"
                      rows="5"
                      placeholder="Have something to say ">
            </textarea>
        </div>
        <button class="btn btn-primary" @click="addReply">Reply</button>
    </div>
    <p class="text-center mt-3" v-else >Please <a href="/login">sign in</a> to participate in this discussion</p>
</div>
</template>

<script>
    export default {
        data(){
            return{
                body : '',
            }
        },
        computed:{
            siginIn()
            {
                return window.App.signedIn;
            }
        },
        methods:{
            addReply()
            {
                axios.post(location.pathname +'/replies', {body : this.body})
                        .then(({data}) =>{
                        this.body= '';
                        flash('Your Reply has been posted');
                        this.$emit('created',data);
                  });
            }
        }
    }
</script>