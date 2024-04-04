<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import FullCalendar from "@/Components/FullCalendar.vue";

defineProps({
    calendars: {
        type: Array,
        required: true,
    },
});

</script>

<template>

    <Head title="Agendas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Agendas de Eventos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- filtros -->
                        <div class="flex flex-col sm:flex-row sm:justify-end">
                            <div>
                                <button @click="window"
                                    class="bg-slate-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                                    Adicionar Agenda
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Agenda
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Quantidade de Eventos
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Atualizado em
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cadastrada em
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(calendar, index) in calendars" :key="index">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ calendar.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ calendar.appointments.length }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ calendar.updated_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ calendar.created_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a :href="route('calendar.edit', calendar.id)"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
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
