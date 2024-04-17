<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <a
        :href="href"
        class="text-white bg-gray-500 hover:bg-gray-500 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-gray-500 dark:hover:bg-gray-500 dark:focus:ring-gray-400 dark:border-gray-400 float-right "

    >
        <slot />
    </a>
</template>
