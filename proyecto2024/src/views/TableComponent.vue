<!--Esta pagina muestra los datos de la base de datos en una tabla, muestra
id, grupo, materia, id, Profesor, proceso a realizar-->

<template>
  <div class="dataTable">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Grupo</th>
          <th>Materia</th>
          <th>ID</th>
          <th>Profesor</th>
          <th>Proceso</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in tableData" :key="data.id">
          <td>{{ data.id }}</td>
          <td>{{ data.grupo }}</td>
          <td>{{ data.materia }}</td>
          <td>{{ data.id }}</td>
          <td>{{ data.profesor }}</td>
          <td>{{ data.proceso }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
  
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
  