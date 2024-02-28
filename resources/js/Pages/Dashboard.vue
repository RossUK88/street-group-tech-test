<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    csv: null,
})

const upload = () => {
    form.post('/upload', {
        onSuccess: () => {
            form.clearErrors()
        }
    })
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-black">Upload Home Owner CSV</h1>

                        <div class="rounded-md bg-red-50 p-4 mt-4 mb-4" v-if="form.errors.csv">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul role="list" class="list-disc space-y-1 pl-5">
                                            <li>
                                                {{ form.errors.csv }}</li>
                                        </ul>
                                    </div>
                                </div>
                        </div>

                        <form class="col-span-full" @submit.prevent="upload">
                            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span v-if="form.csv" v-text="form.csv.name"></span>
                                            <span v-else>Upload a CSV</span>
                                            <input id="file-upload" name="file-upload" type="file" accept="text/csv" class="sr-only" @input="form.csv = $event.target.files[0]"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-5 inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Upload
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="ml-2">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
