<template>
  <div class="about-page">
    <h1>Acerca de</h1>

    <!-- Carrusel de imágenes en horizontal -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../assets/gatito.jpg" class="d-block w-100" alt="Carlos">
          <div class="carousel-caption d-none d-md-block">
            <h5>Carlos</h5>
            <p>Programador</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/gatito.jpg" class="d-block w-100" alt="Ana">
          <div class="carousel-caption d-none d-md-block">
            <h5>Ana</h5>
            <p>Diseñadora</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/gatito.jpg" class="d-block w-100" alt="Luis">
          <div class="carousel-caption d-none d-md-block">
            <h5>Luis</h5>
            <p>Tester</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutPage',
};
</script>

<style scoped>
.about-page {
  text-align: center;
  padding: 20px;
}

.carousel-item img {
  max-height: 500px;
  object-fit: cover;
}

.carousel-caption h5,
.carousel-caption p {
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
  border-radius: 5px;
}
</style>
