<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";

export default {
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarOptions: {
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
          alert(
            info.event.title +
              " was dropped on " +
              info.event.start.toISOString()
          );
        },
      },
    };
  },
  methods: {
    events() {
      axios
        .get("/events")
        .then((response) => {
          this.calendarOptions.events = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {
    console.log("Component mounted.");
    this.events();
  }
};
</script>
<template>
  <FullCalendar :options="calendarOptions" />
</template>