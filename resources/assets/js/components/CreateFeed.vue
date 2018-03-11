<template>
    <div class="justify-content-center mb-3">
        <div class="card card-primary">
            <div class="card-header">{{ newFeed.id ? 'Editar' : 'Crear'}} Publicación</div>
            <form v-on:submit.prevent="saveFeed">
                <div class="card-body">
                    <textarea class="form-control" name="content" v-model="newFeed.content" placeholder="¿Deseas publicar una noticia?"></textarea>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary ml-auto">Publicar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            feed: {
                type: Object,
                default: function () {
                    return { 
                        id : 0,
                        image: '',
                        content: '', 
                    }
                }
            },
        },
        computed: {
            newFeed: function() {
                return {
                    id: this.feed.id,
                    content: this.feed.content,
                    image: this.feed.image,
                }
            }
        },
        methods: {
            saveFeed: function (event) {
                var app = this;
                var url = '/feeds';
                if (app.newFeed.id != 0) {
                    url += '/'+ app.newFeed.id ;
                    app.newFeed._method = 'PUT';
                }
                axios.post(url, app.newFeed)
                    .then(function (resp) {
                        app.feed = {id: 0,content :'',image: ''};
                        app.$toastr.s("CREATED FEED SUCCESSFULLY"); 
                        app.$emit('submited');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT CREATE FEED"); 
                    });
            }
        }
    }
</script>
