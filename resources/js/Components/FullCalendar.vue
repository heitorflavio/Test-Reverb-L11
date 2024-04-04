<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import Swal from "sweetalert2";
import flatpickr from "flatpickr";
import { Portuguese as Pt } from "flatpickr/dist/l10n/pt.js";
import axios from "axios";

export default {
  components: {
    FullCalendar,
  },
  props: {
    events: {
      type: Array,
    },
    calendars: {
      type: Array,
    },
  },
  data() {
    return {
      calendarOptions: {

      },
    };
  },
  methods: {
    mountFlatpickr(event) {
      flatpickr('.start', {
        locale: Pt,
        enableTime: true,
        dateFormat: 'd-m-Y H:i',
        defaultDate: event.start ? event.start : new Date(),
      });

      flatpickr('.end', {
        locale: Pt,
        enableTime: true,
        dateFormat: 'd-m-Y H:i',
        defaultDate: event.end ? event.end : new Date(),
      });
    },
  },
  watch: {
    events() {
      this.calendarOptions.events = this.events;
    },
  },
  created() {
    let calendars = this.calendars;
    const mountFlatpickr = this.mountFlatpickr;
    this.calendarOptions = {
      plugins: [dayGridPlugin, interactionPlugin],
      locale: "pt-br",
      events: [

      ],
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth",
      },
      buttonText: {
        today: "Hoje",
        month: "Mês",
        week: "Semana",
        day: "Dia",
      },
      editable: true,
      eventDrop: function (info) {
        axios
          .put(`/events/update/${info.event.id}`, {
            start: info.event.start,
            end: info.event.end,
          })
          .then((response) => {
            
          })
          .catch((error) => {
            console.log(error);
          });
      },
      eventClick: function (info) {
        Swal.fire({
          title: info.event.title,
          html: `
            <input
              id="title"
              name="title"
              type="text"
              value="${info.event.title}"
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
              <option value="">Selecione uma agenda</option>
              ${calendars.map((calendar) => `<option ${calendar.id == info.event._def.extendedProps.calendar_id ? 'selected' : ''} value="${calendar.id}">${calendar.name}</option>`).join('')}
            </select>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input
                id="start"
                name="start"
                type="text"
                required
                placeholder="Data de início"
                data-input
                class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm start"
              />
              <input
                id="end"
                name="end"
                type="text"
                required
                placeholder="Data de término"
                data-input
                class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm end"
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
                <option value="pending" ${info.event._def.extendedProps.status == 'pending' ? 'selected' : ''}>Pendente</option>
                <option value="approved" ${info.event._def.extendedProps.status == 'approved' ? 'selected' : ''}>Aprovado</option>
                <option value="rejected" ${info.event._def.extendedProps.status == 'rejected' ? 'selected' : ''}>Rejeitado</option>
              </select>
              <select
                id="color"
                name="color"
                required
                class="w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
              >
                <option value="">Selecione uma Cor</option>
                <option value="#C0392B" ${info.event.backgroundColor == '#C0392B' ? 'selected' : ''}>Vermelho</option>
                <option value="#1E8449" ${info.event.backgroundColor == '#1E8449' ? 'selected' : ''}>Verde</option>
                <option value="#2874A6" ${info.event.backgroundColor == '#2874A6' ? 'selected' : ''}>Azul</option>
                <option value="#7D3C98" ${info.event.backgroundColor == '#7D3C98' ? 'selected' : ''}>Roxo</option>

              </select>
            </div>
              <textarea
                id="description"
                name="description"
                required
                placeholder="Descrição"
                value="${info.event._def.extendedProps.description}"
                class="mt-4 block w-full pl-4 pr-10 py-3 text-base border-gray-300 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm"
              >
              ${info.event._def.extendedProps.description}
              </textarea>
            `,
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          confirmButtonText: "Salvar",
          cancelButtonText: "Excluir",
        }).then((result) => {
          if (result.isConfirmed) {
            axios
              .put(`/events/update/${info.event.id}`, {
                title: document.getElementById("title").value,
                start: document.getElementById("start").value,
                end: document.getElementById("end").value,
                status: document.getElementById("status").value,
                color: document.getElementById("color").value,
                description: document.getElementById("description").value,
                calendar_id: document.getElementById("calendar").value,
              })
              .then((response) => {
              
              })
              .catch((error) => {
                console.log(error);
              });

          } else if (result.dismiss === Swal.DismissReason.cancel) {
            axios.delete(`/events/delete/${info.event.id}`).then((response) => {
             
            });
          }
        });
        mountFlatpickr(info.event);
      }
    };
  },
  mounted() {
    this.calendarOptions.events = this.events;
  }
};
</script>
<template>
  <FullCalendar :options="calendarOptions" />
</template>