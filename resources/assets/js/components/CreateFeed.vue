<template>
    <div class="justify-content-center mb-3">
        <div class="card card-primary">
            <div class="card-header">{{ feed.id ? 'Editar' : 'Crear'}} Publicación</div>
            <form v-on:submit="saveFeed">
                <div class="card-body">
                    <textarea class="form-control" name="content" v-model="feed.content" placeholder="¿Deseas publicar una noticia?"></textarea>
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
        mounted () {
            console.log('Created Feed');
        },
        methods: {
            saveFeed: function (event) {
                var app = this;
                var url = '/feeds';
                if (app.feed.id != 0) {
                    url += '/'+ app.feed.id ;
                    app.feed._method = 'PUT';
                }
                var newFeed = app.feed;
                axios.post(url, newFeed)
                    .then(function (resp) {
                        app.feed = {content :'',image: ''};
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your feed");
                    });
            }
        }
    }
</script>
