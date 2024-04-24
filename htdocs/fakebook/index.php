<!DOCTYPE html>
<html>
<head>
  <title>¡Bienvenido a Fakebook!</title>
  <style>
    .inicio {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url("/fakebook/assets/biblioteca.jpg");
      background-size: cover;
      background-position: center;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
    }

    .content {
      text-align: center;
      color: #fff;
      z-index: 1;
    }

    .title {
      font-size: 3rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    }

    .subtitle {
      font-size: 1.5rem;
      margin-bottom: 2rem;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
    }

    .buttons {
      display: flex;
      justify-content: center;
      margin-top: 2rem;
    }

    .button {
      display: inline-block;
      padding: 1rem 2rem;
      font-size: 1.5rem;
      font-weight: bold;
      color: #fff;
      background-color: #2196f3;
      border-radius: 6px;
      margin: 0 1rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }

    .button:hover {
      background-color: #1976d2;
    }
  </style>
</head>
<body>
  <div class="inicio">
    <div class="overlay"></div>
    <div class="content">
      <h1 class="title">¡Bienvenido a Fakebook!</h1>
      <p class="subtitle">Explora nuestro mundo de conocimiento y aventuras literarias</p>
      <div class="buttons">
        <a href="/fakebook/views/login.php" class="button">Iniciar sesión</a>
        <a href="/fakebook/views/registro.php" class="button">Crear cuenta</a>
      </div>
    </div>
  </div>
</body>
</html>