<template>
    <div>
      <h2>Gestión de Alumnos</h2>
      <form @submit.prevent="addAlumno">
        <input v-model="alumno.noControl" placeholder="No. Control" />
        <input v-model="alumno.nombre" placeholder="Nombre" />
        <input v-model="alumno.apellidos" placeholder="Apellidos" />
        <input v-model="alumno.email" placeholder="Email" />
        <input v-model="alumno.telefono" placeholder="Telefono" />
        <input v-model="alumno.password" type="password" placeholder="Password" />
        <input v-model="alumno.status" type="number" placeholder="Status" />
        <button type="submit">Agregar Alumno</button>
      </form>
      <ul>
        <li v-for="alumno in alumnos" :key="alumno.noControl">
          {{ alumno.noControl }} - {{ alumno.nombre }} - {{ alumno.apellidos }}
          <button @click="deleteAlumno(alumno.noControl)">Eliminar</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'AlumnoPage',
    data() {
      return {
        alumno: [],
      };
    },
    mounted() {
      this.getAlumnos();
    },
    methods: {
      async getAlumnos() {
        try {
          const response = await axios.get('http://localhost:3000/alumnos');
          this.alumno = response.data;
        } catch (error) {
          console.error(error);
        }
      },
      async addAlumno() {
        try {
          await axios.post('http://localhost:3000/alumnos', this.alumno);
          this.getAlumnos();
        } catch (error) {
          console.error(error);
        }
      },
      async deleteAlumno(noControl) {
        try {
          await axios.delete(`http://localhost:3000/alumnos/${noControl}`);
          this.getAlumnos();
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>
  
  <style>
  /* Agrega estilos aquí */
  </style>
  