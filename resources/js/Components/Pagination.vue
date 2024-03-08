<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'
defineProps({ links: Array, searchWord: String })
// : href = "link.url + '&search=' + `${encodeURI(searchWord)}`" v - html="link.label" />

// const p = () => { encodeURI(searchWord); }

</script>
<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">



            <template v-for="(link, index) in links" :key="index">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <Link v-else id="ur"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
<script>

// export default {
//     setup() {
//         const aa = stringifyQuery("あいうえお")
//         return {
//             aa
//         }
//     },
//     data() {
//         return {
//             searchQuery: encodeURI(this.searchWord)
//         }
//     },
//     computed: {
//         p() {
//             return encodeURI("あいうえお");
//         },
//         double() {
//             return this.number * 2;
//         },
//         numberClass() {
//             if (this.number > 50) {
//                 return "red";
//             }

//             return "blue";
//         }
//     }
// };


</script>
