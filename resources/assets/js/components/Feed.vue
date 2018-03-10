<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="d-inline">
                <strong class="d-block">{{ feed.user.name }}</strong>
                <small>{{ feed.created_at | moment("from") }}</small>
            </div>
        </div>
        <div class="card-body">
            {{ p.content }}
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary">Me Gusta</button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                feed: {
                    id: 1,
                    image: '',
                    content: 'Soy una Publicación',
                    user: {
                        name: 'Soy un usuario',
                    },
                    likes: 20,
                    created_at: '8-03-2018 11:50am',
                }
            }
        },    
    }
</script>
