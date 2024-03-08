<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue'
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';




defineProps({
    customers: Object,
    // searchWord: String
})

const search = ref('')

// ref の値を取得するには .valueが必要
const searchCustomers = () => {
    Inertia.get(route('customers.index', { search: search.value }))
}






</script>
<script>
// export default {
//     data() {
//         return {
//             inquiries: [],//レコード軍がこの後格納される配列
//             total: null,//ヒットしたレコードの数
//             current_page: 1,//現在のページ番号（初期値は1）
//             key: null,//検索キーワード
//             searchKeyword: null, //「○○」の検索結果に使う変数
//         }
//     }
// }
</script>
<template>
    <Head title="顧客一覧" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客一覧
            </h2>
        </template>


        <!-- {{ inquiries }}
        {{ total }}
        {{ current_page }}
        {{ key }}
        {{ searchKeyword }} -->






        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <!-- フラッシュメッセージ -->
                                <FlashMessage />
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <!-- 検索結果 -->
                                    <!-- TODO 検索機能付きページネーションをちゃんとつくる！ -->
                                    <p v-if="searchWord">「{{ searchWord }}」の検索結果 {{ "???" }}件ヒット</p>
                                    <!-- <div v-if="searchWord !== null" v-text="'検索: ' + searchWord" class="mb-2"></div> -->
                                    <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                        <!-- 検索ボタン -->
                                        <div>
                                            <input type="text" name="search" v-model="search">
                                            <button class="bg-blue-300 text-white py-2 px-2"
                                                @click="searchCustomers">検索</button>
                                        </div>
                                        <!-- 顧客登録ボタン -->
                                        <Link as="button" :href="route('customers.create')"
                                            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        顧客登録</Link>
                                    </div>
                                    <!-- 顧客一覧表 -->
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    Id</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    氏名</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    カナ</th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    電話番号</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="customer in customers.data" :key="customer.id">
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    {{ customer.id }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ customer.name }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ customer.kana }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ customer.tel }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <Pagination class="mt-6" :searchWord="searchWord" :links="customers.links"></Pagination>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
