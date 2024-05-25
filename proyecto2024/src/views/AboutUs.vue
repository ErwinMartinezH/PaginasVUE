<template>
  <div>
    <div class="main-content">
      <h1>Acerca de nosotros</h1>
      <NavBar :nombreCompleto="nombreCompleto" />
      <div
        id="carouselExampleIndicators"
        class="carousel slide"
        data-bs-ride="carousel"
      >
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../assets/gatito.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption d-none d-md-block">
              <h5>Martinez Herrera Erwin Brown</h5>
              <h4>20021244</h4>
              <p>Programador fullstack</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/gatito.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption d-none d-md-block">
              <h5>Rosario del Carmen Cantarel Rosales</h5>
              <h4>E19021050</h4>
              <p>Programador</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/gatito.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption d-none d-md-block">
              <h5>Angel Martinez Prieto</h5>
              <h4>E18021570</h4>
              <p>Programador</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/gatito.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption d-none d-md-block">
              <h5>Jade Anastacio Montalvo</h5>
              <h4>20021191</h4>
              <p>Programador</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "./NavBar.vue";
import axios from "axios";
export default {
  name: "AboutPage",
  components: {
    NavBar,
  },
  data() {
    return {
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
      } catch (error) {
        console.error("Error al obtener los datos del alumno:", error);
        this.$router.push("/loginAuth");
      }
    }
  },
};
</script>

<style scoped>
/* Estilos adicionales para el carrusel */
.main-content {
  padding: 20px;
  margin-top: -20px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: 1px solid #ccc;
}
h1 {
  text-align: center;
  color: #ffffff;
  background: #000;
  padding: 20px;
  margin-bottom: 10px;
  border-radius: 5px;
  margin-left: -27px;
  margin-right: -27px;
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: -62px;
}
.carousel-item {
  display: inline-block;
  margin-left: 10px;
}

.carousel-item img {
  width: 100px;
  height: auto;
  border-radius: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.carousel-inner {
  display: relative;
}

.carousel-control-prev,
.carousel-control-next {
  top: auto;
  bottom: 0;
}

.carousel-caption {
  background-color: rgba(0, 0, 0, 0.033);
  padding: 10px;
  border-radius: 5px;
}

.carousel-caption h5 {
  margin-bottom: 0px;
  font-weight: bold;
  color: #000;
  font-size: 12px;
}

.carousel-caption p {
  margin-bottom: 0;
  font-weight: bold;
  color: #000;
  font-size: 18px;
}

.carousel-indicators {
  bottom: 0;
}

.carousel-indicators button {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin: 0 5px;
}

.carousel-indicators .active {
  background-color: #000;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  width: 20px;
  height: 20px;
}

.carousel-control-prev-icon {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3e%3c/svg%3e");
}

.carousel-control-next-icon {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3e%3c/svg%3e");
}

.carousel-indicators button {
  background-color: #000;
}

.carousel-indicators .active {
  background-color: #000;
}
</style>
