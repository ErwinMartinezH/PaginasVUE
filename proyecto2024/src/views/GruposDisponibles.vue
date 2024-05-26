<template>
    <div class="row">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="text-center">Grupos Disponibles</h3>
            </div>
            <div class="card-body">
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary m-0">
                    <div class="container">
                        <a class="navbar-brand" href="NavBar.vue">Softdcc</a>
                        <button class="navbar-toggler"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="MainPage.vue">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="MainPage.vue" class="btn btn-dark">Regresar</a>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <span class="badge text-bg-secondary">{{ userName }}</span>
                            </form>
                        </div>
                    </div>
                </nav>
                <div class="card-body">
                    <TableComponent :tableData="groups" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .row {
        display: flex;
        justify-content: center;
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

    .navbar-brand {
        color: #fff;
    }

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.1);
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
