<template>
  <div>
    <form @submit.prevent="register">
      <label for="title"><h2>Registro Alumno</h2></label>
      <label for="noControl" align="left">Número de control:</label>
      <input
        type="text"
        v-model="noControl"
        required=""
        title="Ingresa tu número de control ej. E20021244 o 20021244"
        pattern="E?[0-9]{8}"
        placeholder="Capture su No. de Control"/>
      <br />
      <label for="nombre" align="left">Nombre:</label>
      <input
        type="text"
        v-model="nombre"
        required=""
        placeholder="Capture Nombre usando letras MAYUSCULAS"
        title="Capture su Nombre usando letras MAYUSCULAS, Ej: MARTHA ó BIBIANA"
        pattern="[A-ZÁÉÍÓÚÑ ]{2,32}"
        oninput="this.value = this.value.toUpperCase()"/>
      <br />
      <label for="apellidos" align="left">Apellido:</label>
      <input
        type="text"
        v-model="apellidos"
        required=""
        placeholder="Capture Apellidos usando letras MAYUSCULAS"
        title="Capture su Apellidos usando letras MAYUSCULAS, Ej: LOPEZ O RODRIGUEZ"
        pattern="[A-ZÁÉÍÓÚÑ ]{2,32}"
        oninput="this.value = this.value.toUpperCase()"/>
      <br />
      <label for="telefono" align="left">Telefono:</label>
      <input
        type="text"
        v-model="telefono"
        required=""
        placeholder="Capture su Telefono ej. 2291234567"
        title="Capture su Telefono ej. 2291234567"
        pattern="[0-9]{10}" />
      <br />
      <label for="email" align="left">Correo:</label>
      <input
        type="text"
        v-model="email"
        required=""
        placeholder="Capture su Correo ej. example@example.com"
        title="Capture su Correo ej. example@example.com" />
      <br />
      <label for="password" align="left">Contraseña:</label>
      <input
        type="password"
        v-model="password"
        required=""
        placeholder="Capture su Contraseña"
        title="Capture su Contraseña" />
      <br />
      <button type="submit">Registrarse</button>
      <router-link to="/loginAuth"><a>¿Ya tienes cuenta?</a></router-link>
    </form>
  </div>
</template>

<script>
export default {
  name: 'RegisterForm',
  data() {
    return {
      noControl: '',
      nombre: '',
      apellidos: '',
      telefono: '',
      email: '',
      password: '',
      status: 1
    };
  },
  methods: {
    async register() {
      try {
        const response = await fetch('http://localhost:3000/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            noControl: this.noControl,
            nombre: this.nombre,
            apellidos: this.apellidos,
            telefono: this.telefono,
            email: this.email,
            password: this.password,
            status: this.status
          })
        });
        const data = await response.json();
        if (data.message === 'Usuario registrado exitosamente') {
          alert('Usuario registrado exitosamente');
          this.$router.push('/loginAuth');
        } else {
          alert('Error al registrar el usuario');
        }
      } catch (error) {
        console.error('Error al registrar el usuario: ', error);
        alert('Error al registrar el usuario');
      }
    }
  }
};
</script>

<style>

body {
  background-color: #f2f2f2;
}

h2 {
  text-align: center;
  color: #ffffff;
  background: #000;
  padding: 20px;
  margin-bottom: 10px;
  margin-top: -28px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
}

a {
  text-decoration: none;
  color: #000000;
}

form {
  max-width: 400px;
  margin: 0 auto;
  margin-top: -50px;
  margin-bottom: 10px;
  padding: 30px;
  background-color: #ffffff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  font-size: 16px;
  font-weight: bold;
  color: #333;
  text-align: center;
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
  width: 180px;
  
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  font-size: 16px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #45a049;
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