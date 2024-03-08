<script setup>
import { Link } from "@inertiajs/inertia-vue3";

// コントローラーから渡ってくる場合は definProps を使う
defineProps({
    blogs: Array, //Laravelのコレクション型を連想配列で受け取る
});
</script>

<template>
    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>

    <!-- 一覧表示 -->
    <ul>
        <!-- 単数形 in 複数形 :keyもつける(ソートや削除などで順序変わっても状態を保持するため) -->
        <li v-for="blog in blogs" :key="blog.id">
            件名:
            <Link
                class="text-blue-400"
                :href="route('inertia.show', { id: blog.id })"
                >{{ blog.title }}</Link
            >
            本文:
            {{ blog.content }}
        </li>
    </ul>
</template>
