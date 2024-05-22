<template>
    <nav class="navbar">
      <div class="navbar-left">
        <button @click="joinGroup">Unirse a un Grupo</button>
        <button @click="aboutUs">Acerca de</button>
        <button @click="logout">Salir</button>
      </div>
      <div class="navbar-right">
        <span>Bienvenido {{ nombreCompleto }}</span>
      </div>
    </nav>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'NavBar',
    props: ['nombreCompleto'],
    methods: {
      joinGroup() {
        // Implementar la lógica para unirse a un grupo
        alert('Funcionalidad para unirse a un grupo próximamente');
      },
      aboutUs() {
        // Implementar la lógica para unirse a un grupo
        alert('Funcionalidad Acerca de próximamente');
      },
      async logout() {
        try {
          await axios.get('http://localhost:3000/logout', { withCredentials: true });
          this.$router.push('/loginAuth'); // Redirigir al login después de cerrar sesión
        } catch (error) {
          console.error('Error al cerrar sesión:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .navbar {
    display: flex;
    justify-content: space-between;
    background-color: #4CAF50;
    padding: 10px;
    color: white;
    margin-top: -18px;
  }
  
  .navbar-left, .navbar-center, .navbar-right {
    display: flex;
    align-items: center;
  }
  
  .navbar-center button {
    margin-left: 10px;
    margin-right: 10px;
    background-color: #3e8e41;
    border: none;
    padding: 10px;
    color: white;
    cursor: pointer;
    border-radius: 3px;
  }
  
  .navbar-center button:hover {
    background-color: #2e6e31;
  }

  .button{
    margin-left: 10px;
    background-color: #3e8e41;
    border: none;
    padding: 10px;
    color: white;
    cursor: pointer;
    border-radius: 3px;
  }
  
  .button:hover {
    background-color: #2e6e31;
  }

  .navbar-right span {
    margin-left: 10px;
  }

  </style>
  