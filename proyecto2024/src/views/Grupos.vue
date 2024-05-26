<template>
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
