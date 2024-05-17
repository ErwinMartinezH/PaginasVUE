<!-- TableComponent.vue -->
<template>
    <div class="card-body">
      <table id="miTabla" class="dataTable">
        <thead>
          <tr>
            <th>Id</th>
            <th>Gpo</th>
            <th>Materia</th>
            <th>Id</th>
            <th>Profesor</th>
            <th colspan="2">Proceso</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in data" :key="index">
            <td>{{ row.id }}</td>
            <td>{{ row.grupo }}</td>
            <td>{{ row.materia }}</td>
            <td>{{ row.idProfesor }}</td>
            <td>{{ row.profesor }}</td>
            <td><a :href="'pasedelista/index.php?idmateria=' + row.id + '&idgrupo=' + row.grupo + '&idprofesor=' + row.idProfesor + '&nombremateria=' + row.materia + '&nombreprofesor=' + row.profesor" class="btn btn-primary">Pasar Lista</a></td>
            <td><a :href="'asistencia/index.php?idmateria=' + row.id + '&idgrupo=' + row.grupo + '&idprofesor=' + row.idProfesor + '&nombremateria=' + row.materia + '&nombreprofesor=' + row.profesor" class="btn btn-success">Asistencia</a></td>
          </tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      data: {
        type: Array,
        required: true
      }
    }
  }
  </script>
  
  <style>
  /* Estilos CSS necesarios */
  .dataTable {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
    font-size: 14px;
    line-height: 1.5;
    color: #333;;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)
  }

  .dataTable th,
  .dataTable td {
    padding: 10px;
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid #ccc;
  }

  .dataTable th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
  }

  .dataTable td {
    background-color: #fff;
    border-bottom: 1px solid #ccc;

  }

  .dataTable td:last-child {
    text-align: center;

  }

  .dataTable td:last-child a {
    display: inline-block;
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    transition: background-color 0.3s ease;
  }

  .dataTable td:last-child a:hover {
    background-color: #0056b3;
  }

  </style>
  