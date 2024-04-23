<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head} from '@inertiajs/vue3';
    import CustomButton from '../../Components/CustomButton.vue';
    import CustomDangerButton from '../../Components/CustomDangerButton.vue';
    import VueSweetalert2 from 'vue-sweetalert2';
    import {ref, watch} from "vue";
    import {router} from '@inertiajs/vue3'

    defineProps({
        categories: {
            type: Array,
            default: () => [],
        },
      
    });

    let search = ref('');
    watch(search, (value) => {
        router.get(
            route('category.index'),
            {search: value},
            {
                preserveState: true,
            }
        );
    });

</script>

<template>
    <Head title="Category"/>

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
                        <div class="mb-2">


                            <CustomDangerButton @click="downloadcategory(search)"
                                                class="font-medium bg-white  hover:underline m-2 float-right">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                          d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                                          clip-rule="evenodd"/>
                                    <path fill-rule="evenodd"
                                          d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </CustomDangerButton>

                            <input
                                    type="text"
                                    v-model="search"
                                    placeholder="Search..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2 m-2 float-right"
                            />


                        </div>
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
                            <tr v-if="categories.length" v-for="category in categories"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                <td class="px-6 py-4">
                                    {{ category.id }}
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ category.name }}
                                </th>

                                <td class="px-6 py-4">
                                    <span v-if="category.status == 1"> Active</span>
                                    <span v-else> InActive</span>
                                </td>
                                <td class="px-6 py-4 text-right">


                                    <CustomButton :href="route('category.edit', [category.id])"
                                                  class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Edit
                                    </CustomButton>

                                    <CustomDangerButton @click="deletecategory(category)"
                                                  class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">
                                        Delete
                                    </CustomDangerButton>


                                </td>
                            </tr>

                            <tr v-else
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                <td class="px-6 py-4 text-center" colspan="4">
                                    No record found
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
            deletecategory(category) {
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
            },
            downloadcategory(term){

                let data = {
                    "search" : term
                };

                let postConfig = {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    responseType: 'blob',
                };

                axios.post(route('category.download'), data, postConfig)
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'category.pdf');
                        document.body.appendChild(link);
                        link.click();
                    })

                /*router.get(
                    route('category.download'),
                    {search: term},
                    {
                        preserveState: true,
                    }
                );*/

            }
        }


    }
</script>
