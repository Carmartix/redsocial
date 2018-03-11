<template>
    <div class="justify-content-center">         
        <div class="card card-default">
            <div class="card-header">Amigos</div>
            <ul class="list-group">
                <li class="list-group-item" v-for="friend, index in friends">
                    <img :src="friend.profile.image" style="vertical-align: bottom" class="rounded d-inline-block" width="40" height="40">
                    <div class="d-inline-block">
                        <a :href="'/user/' + friend.id" class="d-block"><strong>{{ friend.name }}</strong></a>
                        <small>{{ friend.pivot.created_at  | moment("from") }}</small>
                    </div>
                    <div class="d-inline-block float-right">
                        <button class="btn btn-danger" @click="destroy(friend.id, index)">x</button>
                    </div>
                </li>
            </ul>
            <pagination class="justify-content-center my-2" v-bind:limit="1" :data="paginate" v-on:pagination-change-page="getResults"></pagination>                    
        </div>       
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                friends: [],
                paginate: {}
            }
        },            
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var app = this;
                axios.get('/friends?page=' + page)
                    .then(function (resp) {
                        app.friends = resp.data.data;
                        app.paginate = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT LOAD FRIENDS"); 
                    });
            },
            destroy: function(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/friends/' + id)
                        .then(function (resp) {
                            app.friends.splice(index, 1);
                            app.$toastr.s("FRIEND DELETED"); 
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$toastr.e("COULD NOT DELETE FRIEND"); 
                        });
                }
            }
        }
    }
</script>
