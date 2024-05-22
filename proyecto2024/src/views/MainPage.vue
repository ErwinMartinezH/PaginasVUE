<template>
  <div>
    <h1>Sistema de Gestión de Asistencias (Alumnos)</h1>
    <button @click="logout">Cerrar Sesión</button>
    <div v-if="alumno && materias">
      <p><strong>Alumno:</strong> {{ alumno.nombre }} {{ alumno.apellidos }}</p>
      <p><strong>No. de Control:</strong> {{ alumno.noControl }}</p>
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Gpo</th>
            <th>Materia</th>
            <th>Profesor</th>
            <th>Proceso</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="materia in materias" :key="materia.idmateria">
            <td>{{ materia.idmateria }}</td>
            <td>{{ materia.idgrupo }}</td>
            <td>{{ materia.nombre }}</td>
            <td>{{ materia.profesor }}</td>
            <td>
              <button @click="pasarLista(materia.idmateria)">
                Pasar Lista
              </button>
              <button @click="verAsistencias(materia.idmateria)">
                Asistencia
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Cargando datos...</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "MainPage",
  data() {
    return {
      alumno: null,
      materias: [],
    };
  },
  created() {
    this.fetchAlumnoData();
  },
  methods: {
    async fetchAlumnoData() {
      try {
        const response = await fetch("http://localhost:3000/alumno/materias", {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            noControl: localStorage.getItem("noControl"), // Envía el número de control almacenado en el localStorage
          },
        });
        const data = await response.json();
        if (response.ok) {
          this.alumno = data.alumno;
          this.materias = data.materias;
        } else {
          console.error("Error al obtener los datos del alumno:", data.error);
        }
      } catch (error) {
        console.error("Error al obtener los datos del alumno:", error);
      }
    },
    pasarLista(materiaId) {
      console.log("Pasar lista para la materia con ID:", materiaId);
      // Aquí iría la lógica para pasar lista
    },
    verAsistencias(materiaId) {
      console.log("Ver asistencias para la materia con ID:", materiaId);
      // Aquí iría la lógica para ver asistencias
    },

    async logout() {
      try {
        const response = await fetch("http://localhost:3000/logout");
        if (response.ok) {
          // Borrar las credenciales almacenadas en el localStorage
          localStorage.removeItem("token");
          localStorage.removeItem("noControl");
          // Redirigir a la página de inicio de sesión
          this.$router.push("/login");
        } else {
          console.error("Error al cerrar sesión");
        }
      } catch (error) {
        console.error("Error al cerrar sesión:", error);
      }
    },
  },
};
</script>

<style>
/* Estilos CSS aquí */
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

button {
  padding: 5px 10px;
  margin: 2px;
  cursor: pointer;
}

button:hover {
  background-color: #ddd;
}
</style>
