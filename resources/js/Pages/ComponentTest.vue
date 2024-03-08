<script setup>
// コンポーネントのパーツをインポート
import Label from "@/components/Label.vue";
import Input from "@/components/Input.vue";

// LayoutsフォルダのGuest.vueをインポート
import GuestLayout from "@/Layouts/Guest.vue";
</script>

<template>
    <!-- 「GuestLayout」という名前でインポートしたものをタグとして定義 -->
    <GuestLayout>
        <!-- 読み込んだパーツを定義 -->
        <Label>タイトル</Label>
        <Input modelValue="初期値です"></Input>
    </GuestLayout>
</template>

<!-- -----------------------------------------------Guest.vue ↓　↓　↓
<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template> -->

<!-- ---------------------------------------------resources\js\Components\Input.vue
<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template> -->

<!-- -----------------------------------------------resources\js\Components\Label.vue
<script setup>
defineProps(['value']);
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template> -->
