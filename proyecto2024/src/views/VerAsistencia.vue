<template>
  <div>
    <div class="main-content">
      <h1>Asistencias Registradas</h1>
      <table>
        <thead>
          <tr>
            <th>Materia</th>
            <th>Grupo</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Registro</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="asistencia in asistencias" :key="asistencia.reg_fecha">
            <td>{{ asistencia.idmateria }}</td>
            <td>{{ asistencia.idgrupo }}</td>
            <td>{{ asistencia.fecha }}</td>
            <td>{{ asistencia.hora }}</td>
            <td>{{ asistencia.fecha }} {{ asistencia.hora }}</td>
          </tr>
        </tbody>
      </table>
      <button @click="$router.push('/main')">Volver</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "VerAsistencia",
  data() {
    return {
      asistencias: [],
    };
  },
  async created() {
    const { idmateria, idgrupo, idprofesor } = this.$route.query;
    try {
      const response = await axios.get(
        `http://localhost:3000/asistencias/${idmateria}/${idgrupo}/${idprofesor}`,
        { withCredentials: true }
      );
      this.asistencias = response.data;
    } catch (error) {
      console.error("Error al obtener asistencias:", error);
    }
  },
};
</script>

<style scoped>
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
  margin-top: 20px;
}

h1 {
  text-align: center;
  color: #ffffff;
  background: #000000;
  padding: 20px;
  margin-bottom: 10px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
  margin-top: -62px;
  border: 1px solid #ccc;
}

.main-content {
  padding: 20px;
  margin-top: -20px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}
</style>
