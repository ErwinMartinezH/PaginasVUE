<template>
  <div class="container-md">
    <div class="row">
      <div class="card">
        <div class="card-header bg-dark text-white" >
          <h2 class="text-center">Sistema de Gestión de Asistencias (Alumnos)</h2>
        </div>
        <div class="card-body">
          <navbar></navbar>
          <table-component :data="tableData"></table-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '../views/Navbar.vue'
import TableComponent from '../views/TableComponent.vue'

export default {
  components: {
    Navbar,
    TableComponent
  },
}
</script>

<style>
/* Estilos CSS necesarios */
.card {
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.card-header {
  margin-top: -45px;
  padding: 10px;
  background-color: #f5f5f5;
  border-bottom: 1px solid #ccc;
  border-radius: 5px 5px 0 0;
  
}

.card-body {
  padding: 20px;
  border-radius: 0 0 5px 5px;
}


</style>
