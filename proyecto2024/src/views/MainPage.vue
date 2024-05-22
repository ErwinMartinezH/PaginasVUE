<template>
  <div>
    <div class="main-content">
      <h2>Página Principal del Alumno</h2>
      <NavBar :nombreCompleto="nombreCompleto" />
      <!-- Aquí va el contenido principal de la página -->
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
      nombreCompleto: ''
    };
  },
  async created() {
    try {
      const response = await axios.get('http://localhost:3000/alumno', { withCredentials: true });
      this.nombreCompleto = response.data.nombreCompleto;
    } catch (error) {
      console.error('Error al obtener los datos del usuario:', error);
      //this.$router.push('/loginAuth'); // Redirigir al login si hay un error
    }
  }
};
</script>

<style scoped>
.main-content {
  padding: 20px;
  
}

h2 {
  text-align: center;
  color: #ffffff;
  margin-bottom: 20px;
  margin-top: -80px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
  padding: 20px;
  background: #000000;
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
</style>
