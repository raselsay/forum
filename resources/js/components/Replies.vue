<template>
    <div>
        <div v-for="(reply,index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <paginator :dataSet="dataSet" @changes="fetch"></paginator>
        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue'
    import NewReply from './NewReply'
    import collection from '../mixins/collection'
    export default{
        // props:['data'],
        components:{ Reply,NewReply },
        mixins:[collection],
        data(){
            return {
                dataSet:false,
                items: []
            }
        },
        created(){
            this.fetch();
        },
        methods:{
            fetch(page =1 ){
                if (! page)
                {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1]:1;
                }
                axios.get(this.url(page)).then(this.refresh)
            },

            url(page){
                return `${location.pathname}/replies?page=`+page;
            },
            refresh({data})
            {
                this.dataSet = data;
                this.items = data.data;
            },

        }
    }
</script>