<template>
  <div>
    <div class="main-content">
    <div class="title-grupos">
    <h1>Tus grupos son:</h1>
    </div>
    <NavBar :nombreCompleto="nombreCompleto" />
    <table>
      <thead>
        <tr>
          <th>ID Materia</th>
          <th>Gpo</th>
          <th>Materia</th>
          <th>ID Profesor</th>
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
            <button @click="pasarLista(grupo)">Pasar Lista</button>
            <button @click="darDeBaja(grupo)" type="delete-button">Dar de baja</button>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</template>

<script>
import NavBar from "./NavBar2.vue";
import axios from "axios";
export default { 
  name: "GruposAlt",
  components: {
    NavBar,
  },
  data() {
    return {
      grupos: [],
      nombreCompleto: "",
    };
  },
  async created() {
    if (localStorage.getItem("isAuthenticated") !== "true") {
      this.$router.push("/loginAuth");
    } else {
      try {
        const response = await axios.get("http://localhost:3000/alumno", {
          withCredentials: true,
        });
        this.nombreCompleto = `${response.data.nombre} ${response.data.apellidos}`;
        localStorage.setItem("nombreCompleto", this.nombreCompleto); // Guardar en localStorage
      } catch (error) {
        console.error("Error al obtener los datos del alumno:", error);
        this.$router.push("/loginAuth");
      }
    }
  },
  methods: {
    async obtenerGrupos() {
      const noControl = localStorage.getItem("noControl");
      if (!noControl) {
        console.error("NoControl no encontrado en localStorage");
        return;
      }
      try {
        const response = await fetch(`http://localhost:3000/grupos?noControl=${noControl}`, {
          credentials: "include"
        });
        if (!response.ok) {
          throw new Error("Error al obtener los grupos");
        }
        const data = await response.json();
        this.grupos = data;
      } catch (error) {
        console.error("Error al obtener los grupos:", error);
      }
    },
    async pasarLista(grupo) {
      const fecha = new Date().toISOString().split("T")[0]; // YYYY-MM-DD
      const hora = new Date().toTimeString().split(" ")[0]; // HH:MM:SS
      const noControl = localStorage.getItem("noControl");

      try {
        const response = await fetch("http://localhost:3000/pasarLista", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          credentials: "include",
          body: JSON.stringify({
            noControl,
            idmateria: grupo.idmateria,
            idgrupo: grupo.idgrupo,
            idprofesor: grupo.idprofesor,
            fecha,
            hora
          })
        });

        if (response.ok) {
          alert("Asistencia registrada exitosamente");
        } else {
          throw new Error("Error al registrar asistencia");
        }
      } catch (error) {
        console.error("Error al pasar lista:", error);
      }
    },
    async darDeBaja(grupo) {
      const noControl = localStorage.getItem("noControl");

      try {
        const response = await fetch("http://localhost:3000/darseDeBaja", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          credentials: "include",
          body: JSON.stringify({
            noControl,
            idmateria: grupo.idmateria,
            idgrupo: grupo.idgrupo,
            idprofesor: grupo.idprofesor
          })
        });

        if (response.ok) {
          alert("Te has dado de baja exitosamente");
          this.obtenerGrupos(); // Refresca la lista de grupos
        } else {
          throw new Error("Error al dar de baja");
        }
      } catch (error) {
        console.error("Error al dar de baja:", error);
      }
    }
  },
  mounted() {
    this.obtenerGrupos();
  }
};
</script>

<style scoped>
table {
  margin-top: 20px;
  width: 100%;
  border-collapse: collapse;  
}

th,
td {
  padding: 8px;
  text-align: center;
  border-bottom: 1px solid #000000;
  border-right: 1px solid #000000;
  border-left: 1px solid #000000;
  border-top: 1px solid #000000;
  
  font-size: 15px;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

button {
  margin-top: 5px;
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  cursor: pointer;
  /* Centrar el botón horizontalmente*/
  display: inline-block;
  /*centrar el boton verticalmente*/
  vertical-align: middle;
  margin-right: 10px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  font-size: 15px;
}

button[type="delete-button"] {
  background-color: #f44336;
  
}

button:hover[type="delete-button"] {
  background-color: #d32f2f;
}

button:hover {
  background-color: #3e8e41;
}

button:last-child {
  margin-right: 0;
}

.title-grupos {
  text-align: center;
  margin-top: -20px;
  margin-bottom:10px;
  color: #ffffff;
  background: #000;
  padding: 20px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: -62px;
}

.main-content {
  padding: 20px;
  margin-top: -45px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}

.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>
