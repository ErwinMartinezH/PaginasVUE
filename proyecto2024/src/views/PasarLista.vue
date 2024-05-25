<template>
    <div>
      <h1>PASE DE LISTA</h1>
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
          <td>{{ datos.nombremateria }}</td>
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
          <td>{{ datos.nombreprofesor }}</td>
        </tr>
        <tr>
          <td>Id Profesor</td>
          <td>{{ datos.idprofesor }}</td>
        </tr>
      </table>
      <!-- Aquí puedes agregar más detalles o acciones, como confirmar asistencia -->
      <button @click="$router.go(-1)">Volver</button>
      <button @click="pasarLista()">Pasar Lista</button>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "PasarLista",
    data() {
      return {
        datos: {}, // Objeto para almacenar los datos de la materia, grupo y profesor
        fecha: "", // Variable para almacenar la fecha
        hora: "", // Variable para almacenar la hora
      };
    },
    created() {
      // Cuando se carga el componente, obtener los datos para pasar lista
      this.obtenerDatosPasarLista();
      this.obtenerFechaYHora();
    },
    methods: {
      async obtenerDatosPasarLista() {
        try {
          const response = await axios.get("http://localhost:3000/datosPasarLista");
          this.datos = response.data;
        } catch (error) {
          console.error("Error al obtener datos para pasar lista:", error);
        }
      },
      obtenerFechaYHora() {
        // Obtener la fecha y hora actuales del sistema
        const now = new Date();
        // Formatear la fecha en formato YYYY-MM-DD
        this.fecha = now.toISOString().split("T")[0];
        // Formatear la hora en formato HH:MM
        this.hora = now.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", hour12: false });
      },
    },
  };
  </script>
  
  <style scoped>
    /* Estilos adicionales para la vista de pasar lista */
    h1 {
      text-align: center;
      color: #000;
      background: #fff;
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
      border: 5px solid #ccc;
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
  