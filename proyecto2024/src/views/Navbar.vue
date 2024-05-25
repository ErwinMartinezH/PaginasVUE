<template>
  <nav class="navbar">
    <div class="navbar-left">
      <!--Si esta en la pagina /main, muestra los botones-->
      <button @click="$router.push('/main')">Inicio</button>
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
import axios from "axios";

export default {
  name: "NavBar",
  props: ["nombreCompleto"],
  methods: {
    joinGroup() {
      // Implementar la lógica para unirse a un grupo
      alert("Funcionalidad para unirse a un grupo próximamente");
    },
    aboutUs() {
      // Implementar la lógica para unirse a un grupo
      this.$router.push("/about");
    },
    async logout() {
      try {
        await axios.get("http://localhost:3000/logout", {
          withCredentials: true,
        });
        localStorage.removeItem("noControl");
        localStorage.removeItem("isAuthenticated");
        this.$router.push("/loginAuth"); // Redirigir al login después de cerrar sesión
      } catch (error) {
        console.error("Error al cerrar sesión:", error);
      }
    },
  },
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  background-color: #4caf50;
  padding: 10px;
  color: white;
  margin-top: -10px;
  border-radius: 10px;
}

.navbar-left,
.navbar-center,
.navbar-right {
  display: flex;
  align-items: center;
}

.navbar-left button {
  margin-left: 10px;
  background-color: #3e8e41;
  border: hsl(from color h s l);
  padding: 10px;
  color: white;
  cursor: pointer;
  border-radius: 10px;
}

.navbar-left button:hover {
  background-color: #2e6e31;
}

.navbar-right span {
  margin-left: 10px;
}
.navbar-right button {
  margin-left: 10px;
}
</style>
