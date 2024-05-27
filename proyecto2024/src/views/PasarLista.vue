<template>
  <div class="main-content">
  <div>
    <div class="title">
    <h1>PASE DE LISTA</h1>
    </div>
    <table>
      <tr>
        <td>Fecha</td>
        <td>{{ fecha }}</td>
      </tr>
      <tr>
        <td>Hora</td>
        <td>{{ hora }}</td>
      </tr>
      <tr>
        <td>Materia</td>
        <td>{{ nombremateria }}</td>
      </tr>
      <tr>
        <td>Id Materia</td>
        <td>{{ datos.idmateria }}</td>
      </tr>
      <tr>
        <td>Gpo</td>
        <td>{{ datos.idgrupo }}</td>
      </tr>
      <tr>
        <td>Profesor</td>
        <td>{{ nombreprofesor }}</td>
      </tr>
      <tr>
        <td>Id Profesor</td>
        <td>{{ datos.idprofesor }}</td>
      </tr>
    </table>
    <button @click="$router.push('/main')">Volver</button>
    <button @click="pasarLista()">Confirmar Pase de Lista</button>
  </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "PasarLista",
  data() {
    return {
      datos: [],
      fecha: "",
      hora: "",
      nombremateria: "",
      nombreprofesor: "",
    };
  },
  created() {
    this.obtenerDatosPasarLista();
    this.obtenerFechaYHora();
  },
  methods: {
    async obtenerDatosPasarLista() {
      const {
        idmateria,
        idgrupo,
        idprofesor,
        nombremateria,
        nombreprofesor,
        fecha,
        hora,
      } = this.$route.query; // Obtener los datos de la ruta
      try {
        const response = await axios.get(
          `http://localhost:3000/datosPasarLista/${idmateria}/${idgrupo}/${idprofesor}`,
          {
            params: { nombremateria, nombreprofesor, fecha, hora }, // Pasar la fecha y hora como parámetros de consulta
            withCredentials: true,
          }
        );
        this.datos = response.data;
        this.nombremateria = nombremateria; // Mostrar la materia obtenida en la interfaz
        this.nombreprofesor = nombreprofesor; // Mostrar el profesor obtenido en la interfaz
        this.fecha = fecha; // Mostrar la fecha obtenida en la interfaz
        this.hora = hora; // Mostrar la hora obtenida en la interfaz
      } catch (error) {
        console.error("Error al obtener datos para pasar lista:", error);
      }
    },
    obtenerFechaYHora() {
      const now = new Date();
      this.fecha = now.toISOString().split("T")[0];
      this.hora = now.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
      });
    },

    //metodo para confirmar pase de lista,
    async pasarLista() {
      const { idmateria, idgrupo, idprofesor } = this.$route.query;

      try {
        const noControl = localStorage.getItem("noControl");
        console.log("Valor de noControl:", noControl);
        //añador la fecha y hora de registro de hoy
        const fecha = new Date().toISOString().split("T")[0];
        const hora = new Date().toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
          hour12: false,
        });
        console.log("Fecha:", fecha);
        console.log("Hora:", hora);
        const response = await axios.post(`http://localhost:3000/pasarLista`, {
          noControl: noControl,
          idmateria,
          idgrupo,
          idprofesor,
          fecha, // Enviar la fecha al backend
          hora, // Enviar la hora al backend
        });

        console.log("Asistencia registrada exitosamente:", response.data);

        this.$router.push("/main");
      } catch (error) {
        console.error("Error al registrar asistencia:", error);
      }
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales para la vista de pasar lista */

.main-content{
  padding: 20px;
  margin-top: -10px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}

.title{
  text-align: center;
  font-size: 24px;
  font-weight: bold;
  margin-top: -70px;
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

table {
  width: 50%;
  border-collapse: collapse;
  border: 5px solid #000000;
  margin: 0 auto;
  margin-top: 20px;
  margin-bottom: 20px;
}

th,
td {
  padding: 10px;
  text-align: center;
}

th {
  background-color: #f2f2f2;
}

td {
  border-bottom: 1px solid #ccc;
  border-right: 1px solid #ccc;
}

a {
  text-decoration: none;
  color: #000;
}

a:hover {
  text-decoration: underline;
}

button {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

button:active {
  background-color: #3e8e41;
}

button:focus {
  outline: none;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.card {
  width: 400px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
