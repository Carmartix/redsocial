<template>
    <div class="justify-content-center">
        <create-feed v-bind:feed="feed_edit" v-if="id == 0"></create-feed>
        <div class="card card-default mb-3"  v-for="feed, index in feeds">
            <div class="card-header">
                <img :src="feed.user.profile.image" style="vertical-align: baseline" class="rounded d-inline-block" width="40" height="40">
                <div class="d-inline-block ml-2">
                    <strong class="d-block">{{ feed.user.name }}</strong>
                    <small>{{ feed.created_at | moment("from") }}</small>
                </div>
            </div>
            <div class="card-body">
                {{ feed.content }}
            </div>
            <div class="card-footer" v-if="user.id == feed.user.id ">
                <button type="button" v-on:click="destroy(feed.id , index)" class="btn btn-outline-danger">Eliminar</button>
                <button type="button" @click="edit(feed)" class="btn btn-outline-info">Editar</button>
            </div>
        </div>
    </div>
</template>

<script>
    import CreateFeed from './CreateFeed.vue';
    export default {
        data: function () {
            return {
                feeds: [],
                feed_edit: {
                    id: 0,
                    content: ''
                }
            }
        },
        props: {
            id: { //id de perfil visitado
                type: Number,
                default: 0,
            },
            user : { // usuario logeado
                type: Object,
                default: {
                    id: 0
                }
            }
        },
        mounted() {
            var app = this;
            var url = '/feeds';
            if (app.id != 0) {
                url = '/user/'+ app.id +'/feeds';
            }
            axios.get(url)
                .then(function (resp) {
                    app.feeds = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load feeds");
                });
        },
        methods: {
            destroy: function(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/feeds/' + id)
                        .then(function (resp) {
                            app.feeds.splice(index, 1);
                            alert("Feed Delete");
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not delete feed");
                        });
                }
            },
            edit(feed) {
                let app = this;
                app.feed_edit = feed;
            }
        }
    }
</script>
