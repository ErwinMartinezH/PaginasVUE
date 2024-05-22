<template>
  <div>
    <div class="main-content">
      <h2>Página Principal del Alumno</h2>
      <NavBar :nombreCompleto="nombreCompleto" />
      <!-- Aquí va el contenido principal de la página -->
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
          <tr v-for="grupo in grupos" :key="grupo.idmateria + grupo.idgrupo + grupo.idprofesor">
            <td>{{ grupo.idmateria }}</td>
            <td>{{ grupo.idgrupo }}</td>
            <td>{{ grupo.nombremateria }}</td>
            <td>{{ grupo.idprofesor }}</td>
            <td>{{ grupo.nombreprofesor }} {{ grupo.apellidosprofesor }}</td>
            <td>
              <button @click="pasarLista(grupo.idmateria, grupo.idgrupo, grupo.idprofesor)" type="button-primary" >Pasar Lista</button>
              <button @click="verAsistencia(grupo.idmateria, grupo.idgrupo, grupo.idprofesor)" type="button-secondary" >Ver Asistencia</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import NavBar from './NavBar.vue';
  import axios from 'axios';
  
  export default {
    name: 'MainPage',
    components: {
      NavBar
    },
    data() {
      return {
        nombreCompleto: '',
        grupos: []
      };
    },
    async created() {
      if (localStorage.getItem('isAuthenticated') !== 'true') {
        this.$router.push('/loginAuth');
      } else {
        try {
          const response = await axios.get('http://localhost:3000/alumno', { withCredentials: true });
          this.nombreCompleto = `${response.data.nombre} ${response.data.apellidos}`;
        } catch (error) {
          console.error('Error al obtener los datos del alumno:', error);
          this.$router.push('/loginAuth');
        }
        try {
          const response = await axios.get('http://localhost:3000/asistencias', { withCredentials: true });
          this.grupos = response.data;
        } catch (error) {
          console.error('Error al obtener los datos de la tabla de asistencia:', error);
          // this.$router.push('/loginAuth');
        }
      }
    },
    methods: {
      async pasarLista(idmateria, idgrupo, idprofesor) {
        try {
          const response = await axios.post('http://localhost:3000/asistencias', { idmateria, idgrupo, idprofesor }, { withCredentials: true });
          console.log(response.data.message);
        } catch (error) {
          console.error(error);
        }
      },
      async verAsistencia(idmateria, idgrupo, idprofesor) {
        try {
          const response = await axios.get(`http://localhost:3000/asistencias/${idmateria}/${idgrupo}/${idprofesor}`, { withCredentials: true });
          console.log(response.data);
        } catch (error) {
          console.error(error);
        }
      }
    }
  };
  </script>

<style scoped>
/* Agregaremos estilos mas llamativos para el usuario*/

.main-content {
  padding: 20px;
  margin-top: 20px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
  
}

table {
  width: 100%;;
  margin-bottom: 20px;
  border-collapse: separate;
  border-spacing: 0;
  border: 1px solid #ccc;
  border-radius: 5px;
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ccc;
}

button[type="button-primary"] {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px;
}

button[type="button-secondary"] {
  background-color: #1e53e3;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px;
}

button[type="button-primary"]:hover {
  background-color: #45a049;
}

button[type="button-secondary"]:hover {
  background-color: #1e53e3;
}

/* Estilos adicionales para mejorar la apariencia */

h2 {
  text-align: center;
  color: #ffffff;
  background: #000;
  padding: 20px;
  margin-bottom: 10px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: -80px;
}

</style>
