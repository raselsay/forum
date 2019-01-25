<template>
    <div :id="'reply-'+ id" class="card mt-2 mb-2">
        <div class="card-header lavel">
            <h5 class="flex">
                <a href=" '/profiles/'+data.owner.name " v-text="data.owner.name">
                </a> said
                 {{ ago }}
                <!--{{data.created_at }}...-->
            </h5>
            <div>
                <!--<form method="POST" action="/replies/{{$reply->id}}/favorites">-->
                    <!--@csrf-->
                    <!--<button class="btn"  {{$reply->isFavorited() ? 'disabled':''}}>-->
                        <!--{{$reply->favorites_count}} {{str_plural('Favorite',$reply->favorites_count)}}-->
                    <!--</button>-->
                <!--</form>-->
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" id="" cols="30" rows="2" class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update">update</button>
                <button class="btn btn-link btn-sm" @click="editing= false">cancel</button>
            </div>
            <div v-else v-text="body">
            </div>
        </div>
        <!--@can('update',$reply)-->
        <div class="card-footer lavel" v-if="canUpdate">
            <button class="btn btn-secondary btn-sm mr-2" @click="editing=true">Edit</button>
            <button type="submit" class="btn btn-danger btn-sm" @click="destroy">Delete</button>
        </div>
        <!--@endcan-->
    </div>
</template>
<script>
    import moment from 'moment'
    export default {
        props:['data'],
        data(){
            return{
                body:this.data.body,
                id:this.data.id,
                editing : false
            }
        },
        computed:{
            signedIn(){
                return window.App.signedIn;
            },
            canUpdate()
            {
                // return this.data.user_id == window.App.user.id;
                // console.log(window.App.user.id);
                 return this.authorize(user=>this.data.user_id == user.id);

            },
            ago(){
                return moment(this.data.created_at).fromNow();
            }
        },
        methods:{
            update()
            {
                axios.patch('/replies/'+ this.data.id,{
                    body : this.body
                });
                this.editing = false;
            },
            destroy()
            {
                axios.delete('/replies/'+ this.data.id);
                this.$emit('deleted',this.data.id);
                // $(this.$el).fadeOut(300, ()=>{
                //     flash("Your reply has been delete !")
                // });
            }
        }
    }
</script>