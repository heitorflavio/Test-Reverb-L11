<template>

  <Head title="Calendário" />

  <AuthenticatedLayout>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Calendário de Eventos
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

          <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- filtros -->
            <div class="flex flex-col sm:flex-row sm:justify-between">
              <div>
                <button @click="newEvent()"
                  class="bg-slate-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                  Adicionar Evento
                </button>
              </div>
              <div>
                <select id="filter" name="filter" v-model="calendar_id"
                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300  bg-slate-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                  <option value="">Todos</option>
                  <option v-for="(calendar, index) in calendars" :key="index" :value="calendar.id">
                    {{ calendar.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- calendário -->
            <FullCalendar v-if="events.length > 0" :events="events" :calendars="schedules" />
            <div class="text-center" v-else>
              <p>Nenhum evento encontrado</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import FullCalendar from "@/Components/FullCalendar.vue";
import Swal from 'sweetalert2';
import flatpickr from "flatpickr";
import { Portuguese as Pt } from "flatpickr/dist/l10n/pt.js";


export default {
  components: {
    FullCalendar,
    AuthenticatedLayout,
    Head,
  },
  props: {
    calendars: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      events: [],
      calendar_id: "",
      schedules: []
    }
  },
  methods: {
    newEvent() {
      Swal.fire({
        title: 'Adicionar Evento',
        html: `
      <input
        id="title"
        name="title"
        type="text"
        required
        placeholder="Título"
        class="mt-4 block w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm"
      />

      <select
        id="calendar"
        name="calendar"
        required
        class="mt-4 block w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm"
      >
        <option value="all">Selecione uma agenda</option>
        ${this.calendars.map((calendar) => `<option value="${calendar.id}">${calendar.name}</option>`).join('')}
      </select>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input
          id="start"
          name="start"
          type="text"
          required
          placeholder="Data de início"
          data-input
          class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm flatpickr"
        />
        <input
          id="end"
          name="end"
          type="text"
          required
          placeholder="Data de término"
          data-input
          class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm flatpickr"
        />
      </div>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <select
          id="status"
          name="status"
          required
          class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
        >
          <option value="">Selecione um Status</option>
          <option value="pending">Pendente</option>
          <option value="approved">Aprovado</option>
          <option value="rejected">Rejeitado</option>
        </select>
        <select
          id="color"
          name="color"
          required
          class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
        >
          <option value="">Selecione uma Cor</option>
          <option value="#C0392B">Vermelho</option>
          <option value="#1E8449">Verde</option>
          <option value="#2874A6">Azul</option>
          <option value="##7D3C98">Roxo</option>

        </select>
      </div>

        <textarea
          id="description"
          name="description"
          required
          placeholder="Descrição"
          class="mt-4 block w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm"
        ></textarea>
      `,
        showCancelButton: true,
        confirmButtonText: 'Salvar',
        preConfirm: () => {
          // validate form
          const title = document.getElementById('title').value;
          const calendar_id = document.getElementById('calendar').value;
          let start = document.getElementById('start').value;
          let end = document.getElementById('end').value;
          const status = document.getElementById('status').value;
          const color = document.getElementById('color').value;
          const description = document.getElementById('description').value;

          if (!title || !calendar_id || !start || !end || !status || !color || !description) {
            Swal.showValidationMessage('Preencha todos os campos');
          }

          return {
            title,
            calendar_id,
            start,
            end,
            status,
            color,
            description,
          };
        },
      }).then((result) => {
        if (result.isConfirmed) {
          console.log(result.value);
          axios.post(route('appointment.store'), result.value)
            .then(() => {
              Swal.fire('Evento adicionado com sucesso', '', 'success');
            })
            .catch((error) => {
              Swal.fire('Erro ao adicionar evento', error.response.data.message, 'error');
            });
        }
      });
      this.mountFlatpickr();
    },
    mountFlatpickr() {
      flatpickr('.flatpickr', {
        locale: Pt,
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
      });
    },
    getEvents() {
      axios.get(route("appointment.index"), {
        params: {
          calendar_id: this.calendar_id
        }
      }).then((response) => {
        this.events = response.data;
      });
    }
  },
  watch: {
    calendar_id() {
      this.getEvents();
    }
  },
  created() {
    this.getEvents();
    this.schedules = this.calendars;
  },
  mounted() {
    window.Echo.channel('Calendar')
      .listen('.Calendar', (event) => {
        this.getEvents();
      });
  }
};
</script>