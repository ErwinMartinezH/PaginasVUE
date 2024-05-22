<template>
  <div>
    <form @submit.prevent="login" >
      <h2>Iniciar sesión</h2>
      <div>
        <label for="noControl">Número de Control:</label>
        <input type="text" v-model="noControl" id="noControl" required>
      </div>
      <div>
        <label for="password">Contraseña:</label>
        <input type="password" v-model="password" id="password" required>
      </div>
      <button type="submit">Iniciar sesión</button>
      <a href="/register">¿No tienes cuenta?</a>
    </form>
    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LoginForm',
  data() {
    return {
      noControl: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://localhost:3000/login', {
          noControl: this.noControl,
          password: this.password
        });
        alert(response.data.message);
        this.$router.push('/main');
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.error = 'Credenciales incorrectas';
        } else {
          this.error = 'Error al iniciar sesión';
        }
      }
    },
  }
};
</script>
  
  <style> /* Estilos CSS */
  
  body {
    background-color: #f2f2f2;
  }
  
  h2 {
    text-align: center;
  }
  
  form {
    max-width: 400px;
    margin: 0 auto;
    margin-top: 50px;
    margin-bottom: 50px;
    padding: 30px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  label {
    display: block;
    margin-bottom: 5px;
  }
  
  input[type="text"],
  input[type="password"] {
    width: 95%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;
  }
  
  button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  
  button[type="submit"]:hover {
    background-color: #3e8e41;
  }
  
  a {
    display: block;
    text-align: center;
    margin-top: 10px;
  }
  
  router-link {
    display: block;
    text-align: center;
    margin-top: 10px;
  }

  router-link:hover {
    text-decoration: underline;
    text-align: center;
  }

  </style>

