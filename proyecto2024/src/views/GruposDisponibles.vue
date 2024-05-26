<template>
    <div class="row">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="text-center">Grupos Disponibles</h3>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary m-0">
                    <div class="container">
                        <a class="navbar-brand" href="index.php">Softdcc</a>
                        <button class="navbar-toggler" type="button" @click="toggleNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div :class="['collapse navbar-collapse', { show: isNavbarOpen }]">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="MainPage.vue">Home</a>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/router/index.js" class="btn btn-dark">Regresar</router-link>
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
        margin: 20px;
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

    .navbar-dark .navbar-toggler-icon {
        background-color: white;
    }

    .btn-dark {
        background-color: #343a40;
        border-color: #343a40;
    }

    .badge {
        background-color: #6c757d;
        color: white;
    }

    .bg-primary {
        background-color: #007bff;
    }

    .text-bg-secondary {
        background-color: #6c757d;
    }

    .navbar-nav .nav-item .nav-link.active {
        color: white;
    }

    .navbar-brand {
        color: white;
    }

    .collapse.show {
        display: block;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .m-0 {
        margin: 0;
    }

    .me-auto {
        margin-right: auto;
    }

    .mb-2 {
        margin-bottom: .5rem;
    }

    .mb-lg-0 {
        margin-bottom: 0;
    }
</style>