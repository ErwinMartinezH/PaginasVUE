<template>
  <div class="main-content">
  <div class="Title"><h1>Grupos Disponibles</h1></div>
  <NavBar :nombreCompleto="nombreCompleto" />
    <table>
      <thead>
        <tr>
          <th>ID Grupo</th>
          <th>Gpo</th>
          <th>Materia</th>
          <th>Id Profesor</th>
          <th>Profesor</th>
          <th>Proceso</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="filteredGrupos.length === 0">
          <td colspan="6">No hay grupos disponibles</td>
        </tr>
        <tr v-for="(grupo, index) in filteredGrupos" :key="index">
          <td>{{ grupo.idmateria }}</td>
          <td>{{ grupo.idgrupo }}</td>
          <td>{{ grupo.nombremateria }}</td>
          <td>{{ grupo.idprofesor }}</td>
          <td>{{ grupo.nombreprofesor }}</td>
          <td><button @click="darseDeAlta(grupo)">Darse de alta</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import NavBar from './NavBar2.vue';
import axios from "axios";

export default {
  components: {
    NavBar,
  },
  data() {
    return {
      grupos: [],
      perPage: 10,
      perPageOptions: [10, 20, 30, "todos"],
      search: "",
      nombreCompleto: "",
    };
  },
  async created() {
    if (!localStorage.getItem("noControl")) {
      this.$router.push("/loginAuth");
    } else {
      try {
        const response = await axios.get("http://localhost:3000/alumno", {
          withCredentials: true,
          params: {
            noControl: localStorage.getItem("noControl"),
          },
        });
        this.nombreCompleto = `${response.data.nombre} ${response.data.apellidos}`;

        const responseAsistencias = await axios.get(
          "http://localhost:3000/asistencias",
          {
            withCredentials: true,
            params: {
              noControl: localStorage.getItem("noControl"),
            },
          }
        );
        this.grupos = responseAsistencias.data;
      } catch (error) {
        console.error(
          "Error al obtener los datos del alumno o de la tabla de asistencia:",
          error
        );
       
      }
    }
  },
  computed: {
    filteredGrupos() {
      //buscamos por numero o por nombre
      let grupos = this.grupos;
      if (this.search) {
        grupos = grupos.filter((grupo) =>
          grupo.grupo.toLowerCase().includes(this.search.toLowerCase())
        );
      }
      if (this.perPage !== "todos") {
        return grupos.slice(0, this.perPage);
      }
      return grupos;
    },
  },
  methods: {
    async fetchGrupos() {
      try {
        const response = await fetch("http://localhost:3000/gruposDisponibles");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log("Grupos obtenidos:", data); // Log para depuración
        this.grupos = data;
      } catch (error) {
        console.error("Error al obtener grupos:", error);
      }
    },
    async darseDeAlta(grupo) {
      try {
        const {noControl = localStorage.getItem("noControl"),idprofesor, idmateria, idgrupo } = grupo;
        console.log(noControl, idprofesor, idmateria, idgrupo);

        const response = await fetch("http://localhost:3000/darseDeAlta", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          credentials: "include",
          body: JSON.stringify({
            noControl,
            idprofesor,
            idmateria,
            idgrupo,
          }),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert("Alumno dado de alta exitosamente");
          this.fetchGrupos();
        }
      } catch (error) {
        console.error("Error al darse de alta:", error);
      }
    },
  },
  mounted() {
    this.fetchGrupos();
  },
};
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}

th,
td {
  text-align: center;
  padding: 8px;
  margin-top: 30px;
  border-top: 1px solid #000000;
  border-right: 1px solid #000000;
  border-left: 1px solid #000000;
  border-bottom: 1px solid #000000;
}

th {
  background-color: #f2f2f2;
}

input[type="text"] {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
  margin-top: 10px;
}

button {
  padding: 5px 10px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

select {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
}

.main-content {
  padding: 20px;
  margin-top: -45px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}

.Title {
  text-align: center;
  color: #ffffff;
  background: #000;
  padding: 20px;
  margin-bottom: 5px;
  margin-top: -65px;
  border-radius: 5px;
  margin-left: -20px;
  margin-right: -20px;
  /* Esquinas redondeadas */
  border-radius: 5px;
  
}

h1 {
  text-align: center;
  font-style: bold;
}
</style>
