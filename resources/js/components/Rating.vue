<template>
    <div class="d-flex flex-column">
        <div class="mb-2">Текущий рейтинг <b v-text="$props.value.rating"></b></div>
        
        <div class="btn-group">
            <div class="btn-rate mr-2" v-whorated="$props.value.likes_from">
                <button
                    type="button"
                    @click="rating($direction.like, $props.type, $props.value.id)"
                    class="btn btn-success"
                    :disabled="$props.value.likes_from.includes($user)"
                >Ничего не понял, но круто &#128077;
                </button>
            </div>
            
            <div class="btn-rate" v-whorated="$props.value.dislikes_from">
                <button
                    type="button"
                    @click="rating($direction.dislike, $props.type, $props.value.id)"
                    class="btn btn-danger"
                    :disabled="$props.value.dislikes_from.includes($user)"
                >Плохо &#128078;
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    
    export default {
        name: 'Rating',
        
        props: {
            value: {
                type:     Object,
                required: true,
            },
            
            type: {
                type:     String,
                required: true,
            },
        },
        
        methods: {
            rating(direction, type, id) {
                axios.post('/ajax/rating/' + direction, {
                    type,
                    id,
                }).then(response => {
                    let data = response.data;
                    if(data.status === this.STATUS_OK) {
                        let data = this.$props.value;
                        
                        if(direction === this.$direction.like) {
                            data.rating++;
                            
                            if(!data.likes_from.includes(this.$user)) {
                                data.likes_from.push(this.$user);
                            }
                            if(data.dislikes_from.includes(this.$user)) {
                                data.dislikes_from.splice(data.dislikes_from.indexOf(this.$user), 1);
                            }
                        } else {
                            data.rating--;
                            
                            if(!data.dislikes_from.includes(this.$user)) {
                                data.dislikes_from.push(this.$user);
                            }
                            if(data.likes_from.includes(this.$user)) {
                                data.likes_from.splice(data.likes_from.indexOf(this.$user), 1);
                            }
                        }
                        
                        this.$emit('input', data);
                        
                        alert('Рейтинг учтен');
                    } else {
                        alert('Произошло что-то плохое(');
                    }
                }).catch(error => {
                    console.error(error);
                    
                    alert('Произошло что-то плохое(');
                });
            },
        },
    };
</script>

<style scoped>

</style>