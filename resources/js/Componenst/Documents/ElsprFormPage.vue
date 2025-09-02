<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ElsprFormPage",
    data() {
        return{
            a: 0,
        }
    },
    methods: {
        increment() {
            this.a++;
        }
    }
})
</script>

<template>
    <h1 @click="increment">Hello, world {{ a }}</h1>
</template>
