<template>
<<<<<<< HEAD
  <div>
    <h1>Tus grupos son:</h1>
  
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
          </td>
          <td>
            <button @click="darDeBaja(grupo)">Dar de baja de la materia</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

=======
  <div class="row justify-content-center">
    <div class="card">
      <div class="card-header bg-dark text-white text-center">
        <h3>Tus grupos <!--{{ userName }}--></h3>
      </div>
      <div class="card-body">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary m-0">
          <div class="container">
            <a class="navbar-brand" href="NavBar.vue">Softdcc</a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="MainPage.vue">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="insertar.html">Alta a un Grupo</a>
                </li>
                <li class="nav-item">
                  <button class="btn btn-dark" @click="goBack">Regresar</button>
                </li>
              </ul>
              <form class="d-flex" role="search">
                <span class="badge text-bg-secondary">{{ userName }}</span>
              </form>
            </div>
          </div>
        </nav>
        <div class="card-body">
          <TableComponent />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.row {
  margin: 0;
}

.card {
  width: 100%;
  max-width: 800px;
  margin-top: 20px;
}

.card-header {
  background-color: #343a40;
  color: white;
}

.text-center {
  text-align: center;
}

.navbar {
  margin: 0;
}

.nav-link.active {
  color: #fff;
}

.btn-dark {
  color: #fff;
  background-color: #343a40;
  border-color: #343a40;
}

.badge {
  padding: 0.5em 1em;
  font-size: 1em;
  color: #6c757d;
  background-color: #e9ecef;
}
</style>

>>>>>>> be6fa156caaffba0b7794f5844ab0353bd6f3bb4
<script>
export default {
  name: "GruposAlt",
  methods: {
    pasarLista(grupo) {
      // Aquí puedes implementar la lógica para pasar la lista
      console.log("Pasar lista del grupo:", grupo);
    },
    darDeBaja(grupo) {
      // Aquí puedes implementar la lógica para dar de baja de la materia
      console.log("Dar de baja del grupo:", grupo);
    }
  }
}
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
} 

th {
  background-color: #f2f2f2;
}

button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #3e8e41;
}
</style>
