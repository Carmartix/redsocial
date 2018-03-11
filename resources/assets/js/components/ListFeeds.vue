<template>
    <div class="justify-content-center">
        <create-feed v-bind:feed="feed_edit" v-if="id == 0 || id == auth.id" @submited="getResults"></create-feed>
        <div class="card card-default mb-3" :class="{ 'border-primary' : feed.user.id == auth.id }"  v-for="feed, index in feeds">
            <div class="card-header">
                <img :src="feed.user.profile.image" style="vertical-align: bottom" class="rounded d-inline-block" width="40" height="40">
                <div class="d-inline-block ml-2">
                    <strong class="d-block">{{ feed.user.name }}</strong>
                    <small>{{ feed.created_at | moment("from") }}</small>
                </div>
            </div>
            <div class="card-body">
                {{ feed.content }}
            </div>
            <div class="card-footer d-flex justify-content-between" v-if="auth.id == feed.user.id ">
                <button type="button" v-on:click="destroy(feed.id , index)" class="btn btn-danger">Eliminar</button>
                <button type="button" @click="edit(feed)" class="btn btn-info">Editar</button>
            </div>
        </div>
        <div class="justify-content-start">
            <pagination class="justify-content-center" v-bind:limit="2" :data="paginate" v-on:pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>

<script>
    import CreateFeed from './CreateFeed.vue';
    export default {
        data: function () {
            return {
                feeds: [],
                paginate: {
                    current_page: 1,
                },
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
            auth : { // usuario logeado
                type: Object,
                default: function () {
                    return { 
                        id: 0
                    }
                }
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page) {
                var app = this;
                var url = '/feeds';
                if (app.id != 0) {
                    url = '/user/'+ app.id +'/feeds';
                }
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get(url + '?page=' + page)
                    .then(function (resp) {
                        app.feeds = resp.data.data;
                        app.paginate = resp.data;
                        app.feed_edit = {
                            id: 0,
                            content: ''
                        }
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT LOAD FEEDS"); 
                    });
            },
            destroy: function(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/feeds/' + id)
                        .then(function (resp) {
                            app.feeds.splice(index, 1);
                            app.$toastr.s("FEED DELETED"); 
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$toastr.e("COULD NOT DELETE FEED"); 
                        });
                }
            },
            edit(feed) {
                let app = this;
                app.feed_edit = feed;
                app.$toastr.i("EDITING FEED"); 
            }
        }
    }
</script>
