<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import CustomButton from '../../Components/CustomButton.vue';
    import CustomDangerButton from '../../Components/CustomDangerButton.vue';
    import VueSweetalert2 from 'vue-sweetalert2';
    defineProps({
        categories: {
            type: Array,
            default: () => [],
        },
    });

</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Category

                <CustomButton :href="route('category.create')">Add Category</CustomButton>


            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="category in categories" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                <td class="px-6 py-4">
                                    {{ category.id }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ category.name }}
                                </th>

                                <td class="px-6 py-4">
                                    <span v-if="category.status == 1"> Active</span>
                                    <span v-else> InActive</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <CustomDangerButton @click="deletecategory(category)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline hover:anchor">Delete</CustomDangerButton>
                                    |
                                    <CustomButton :href="route('category.edit', [category.id])" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</CustomButton>



                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

    export default {
        methods: {
            deletecategory(category){
                this.$swal({
                    title: 'Are you sure?',
                    text: "Are you sure want to delete this category!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.delete(route('category.destroy', [category]));
                    }
                });
            }
        }
    }
</script>
