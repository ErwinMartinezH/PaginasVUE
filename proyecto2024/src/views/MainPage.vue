<template>
  <div>
    <div class="main-content">
      <div class="Title">
        <h1>Página Principal del Alumno</h1>
      </div>
      <!-- NavBar aquí -->
      <NavBar :nombreCompleto="nombreCompleto" />
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Gpo</th>
            <th>Materia</th>
            <th>Id</th>
            <th>Profesor</th>
            <th>Proceso</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="grupo in grupos"
            :key="grupo.idmateria + grupo.idgrupo + grupo.idprofesor"
          >
            <td>{{ grupo.idmateria }}</td>
            <td>{{ grupo.idgrupo }}</td>
            <td>{{ grupo.nombremateria }}</td>
            <td>{{ grupo.idprofesor }}</td>
            <td>{{ grupo.nombreprofesor }} {{ grupo.apellidosprofesor }}</td>
            <td>
              <button
                @click="
                  pasarLista(
                    grupo.idmateria,
                    grupo.idgrupo,
                    grupo.idprofesor,
                    grupo.nombremateria,
                    grupo.nombreprofesor
                  )
                "
                type="button-primary"
              >
                Pasar Lista
              </button>
              <button
                @click="
                  verAsistencia(
                    grupo.idmateria,
                    grupo.idgrupo,
                    grupo.idprofesor
                  )
                "
                type="button-secondary"
              >
                Ver Asistencia
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import NavBar from "./NavBar.vue";
import axios from "axios";

export default {
  name: "MainPage",
  components: {
    NavBar,
  },
  data() {
    return {
      nombreCompleto: "",
      grupos: [],
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
        this.$router.push("/loginAuth");
      }
    }
  },

  methods: {
    async pasarLista(
      idmateria,
      idgrupo,
      idprofesor,
      nombremateria,
      nombreprofesor
    ) {
      try {
        const now = new Date();
        const fecha = now.toISOString().split("T")[0];
        const hora = now.toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
          hour12: false,
        });

        this.$router.push({
          path: "/pasarlista",
          query: {
            idmateria,
            idgrupo,
            idprofesor,
            nombremateria,
            nombreprofesor,
            fecha,
            hora,
          },
        });
      } catch (error) {
        console.error("Error al pasar lista:", error);
      }
    },

    verAsistencia(idmateria, idgrupo, idprofesor) {
      this.$router.push({
        path: "/verasistencia",
        query: { idmateria, idgrupo, idprofesor },
      });
    },
  },
};
</script>

<style scoped>
.Title {
  text-align: center;
  color: #ffffff;
  background: #000;
  padding: 20px;
  margin-bottom: 5px;
  margin-top: -40px;
  border-radius: 5px;
  margin-left: -20px;
  margin-right: -20px;
}

.main-content {
  padding: 20px;
  margin-top: -45px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}

table {
  width: 100%;
  margin-bottom: 20px;
  margin-top: 20px;
  border-collapse: separate;
  border-spacing: 0;
  border: 1px solid #000000;
  border-radius: 5px;
}

th,
td {
  padding: 15px;
  text-align: center;
  border-bottom: 1px solid #000000;
  border-left: 1px solid #000000;
  border-right: 1px solid #000000;
}

button[type="button-primary"] {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px;
}

button[type="button-secondary"] {
  background-color: #008cba;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px;
}

button[type="button-primary"]:hover {
  background-color: #45a049;
}

button[type="button-secondary"]:hover {
  background-color: #007bb5;
}
</style>
