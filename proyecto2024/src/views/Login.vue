<template>
    <div>
      <form @submit.prevent="login">
        <label for="title" text-align="center"><h2>Modulo Alumno</h2></label>
        <label for="noControl" align="left">Número de control:</label>
        <input type="text" v-model="noControl" required=""
          title="Ingresa tu número de control ej. E20021244 o 20021244"
          pattern="E?[0-9]{8}"
          placeholder="Capture su No. de Control"><br>
        <label for="password" align="left">Contraseña:</label>
        <input type="password" v-model="password" required=""
          placeholder="Capture su Contraseña"><br>
        <button type="submit">Iniciar sesión</button>
        <router-link to="/register">¿No tienes cuenta?</router-link>
        <router-link to="/main">pruebas</router-link>
      </form>
    </div>
  </template>
  
  <style>
  
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

<script>
export default {
    name: 'LoginForm',
  data() {
    return {
      noControl: '',
      password: ''
    };
  },
  methods: {
  login() {
    this.$axios.post('http://localhost:8080/db/login.php', {
      noControl: this.noControl,
      password: this.password
    })
    .then(response => {
      console.log(response.data);
      // Aquí puedes manejar la respuesta del servidor
      if (response.data.message === 'Inicio de sesión exitoso') {
        // Redireccionar al usuario a la página principal si el inicio de sesión es exitoso
        this.$router.push('/main');
      } else {
        // Manejar el caso en que las credenciales sean inválidas
        alert(response.data.error);
      }
    })
    .catch(error => {
      console.error(error);
    });
  }
}

};

</script>