<template>
    <div>
      <h2>Sistema de Gestión de Asistencias (Alumnos)</h2>
      <button @click="joinGroup">Unirse a un grupo</button>
      <button @click="logout">Cerrar sesión</button>
      <div>
        <h3>Mis materias:</h3>
        <ul>
          <li v-for="materia in materias" :key="materia.idmateria">{{ materia.nombre }}</li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        materias: []
      };
    },
    mounted() {
      // Lógica para obtener las materias del alumno al cargar la página
    },
    methods: {
      joinGroup() {
        // Lógica para unirse a un grupo
      },
      logout() {
        // Lógica para cerrar sesión
      }
    }
  };
  </script>
  