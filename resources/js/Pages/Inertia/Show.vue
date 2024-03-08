<script setup>
import { Inertia } from "@inertiajs/inertia";
defineProps({ id: String, blog: Object });

// JSのアロー関数は (blog.id) → (id) といった具合に引数だけで書ける
const deleteConfirm = (id) => {
    // JSのテンプレート構文 バックスラッシュで囲む 変数箇所を${}で囲む
    Inertia.delete(`/inertia/${id}`, {
        onBefore: () => confirm("本当に削除しますか?"), //イベントコールバック
    });
};
</script>

<template>
    {{ id }}<br />
    {{ blog.title }}<br />
    <button @click="deleteConfirm(blog.id)">削除</button>
</template>
