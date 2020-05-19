<template>
    <div class="d-flex flex-column">
        <div class="mb-2">Текущий рейтинг <b v-text="$props.value.rating"></b></div>
        
        <div class="btn-group">
            <button
                type="button"
                @click="rating($direction.inc, $props.type, $props.value.id)"
                class="btn btn-success"
            >Ничего не понял, но круто &#128077;
            </button>
            <button
                type="button"
                @click="rating($direction.dec, $props.type, $props.value.id)"
                class="btn btn-danger"
            >Плохо &#128078;
            </button>
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
                        
                        if(direction === this.$direction.inc) {
                            data.rating++;
                        } else {
                            data.rating--;
                        }
                        
                        this.$emit('input', data);
                        
                        alert('Рейтинг учтен');
                    } else {
                        alert('Произошло что-то плохое(');
                    }
                }).catch(error => {
                    alert('Произошло что-то плохое(');
                });
            },
        },
    };
</script>

<style scoped>

</style>