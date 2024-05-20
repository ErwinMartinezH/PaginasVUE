<template>
    <div class="container">
      <!-- Barra de menú en la parte superior de la página -->
      <div class="menu-bar">
        <!-- Nombre de usuario -->
        <a class="menu-item" href="#">Softdcc</a>
        <!-- Elemento del menú: Unirse a un Grupo -->
        <a class="menu-item" href="/unirgrupo">Unirse a un Grupo</a>
        <!-- Elemento del menú: Cerrar Sesión -->
        <a @click="Logout()" class="menu-item" type="button">Cerrar Sesión</a>
        <!-- Elemento del menú: nombre de usuario de la base de datos-->
        <a class="name-user" ><h4></h4></a>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NavbarPage',
   
    
  };
  </script>
  
  <style scoped>
  /* Estilos CSS para la barra de menú */
  .name-user {
    color: #fff;
    font-size: 18px;
    margin-left: 800px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
  }


  .menu-bar {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    background-color: #000000;
    padding: 1px;
    border-radius: 5px;
    margin-bottom: 10px;
    margin-left: 27px;
    margin-right: 27px;
  }
  
  .menu-item {
    color: #fff;
    margin-left: 10px;
    text-decoration: none;
    align-items: center;
  }
  
  .menu-item:hover {
    color: #000000;
    background-color: #fff;
    padding: 5px;
    border-radius: 5px;
    transition: all 0.3s ease;
  }
  
  .menu-item:active {
    color: #000000;
    background-color: #fff;
    padding: 5px;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

/*añadir formato negrita*/
a{
  font-weight: bold;
}
  
  </style>
  