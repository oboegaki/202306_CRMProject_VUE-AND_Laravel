<script setup>
import Label from "@/components/Label.vue";
import Input from "@/components/Input.vue";
import GuestLayout from "@/Layouts/Guest.vue";

// 実行スクリプト(emitTest)
const emitTest = (e) => console.log(e);
</script>

<template>
    <GuestLayout>
        <Label>タイトル</Label>
        <!-- 子供のコンポーネントで親のコンポーネントを動かせる -->
        <Input modelValue="初期値です" @update:modelValue="emitTest"></Input>
    </GuestLayout>
</template>

<!-- $emit(カスタムイベント名、渡したい値) -->
<!-- <input @input="$emit('update:modelValue', $event.target.value)"> -->

<!-- ---------------------------------------------resources\js\Components\Input.vue
<script setup>
省略・・・


■カスタムイベント名
defineEmits(['update:modelValue']);

・・・省略
</script>
 -->
