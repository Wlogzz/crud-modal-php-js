<?php
require('../config/db.php');

session_start();

// Traer datos tabla Género
$sqlGenero = "SELECT * FROM genero";
$generos = $conn->query($sqlGenero);


// Traer datos tabla pelicula
$sqlPeliculas = "SELECT p.id, p.nombre, p.descripcion, g.nombre AS genero, p.fecha_alta FROM pelicula AS p 
                    INNER JOIN genero as g ON p.id_genero = g.id ORDER BY p.id DESC";
$peliculas = $conn->query($sqlPeliculas);

// Definir ruta imágenes
$dir = "posters/";
?>

<?php include('../templates/header.php'); ?>

<body>
    <div class="container py-3">
        <h2 class="text-center">Películas</h2>
        <div class="row justify-content-end">
            <div class="col-auto">
                <a class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-circle-plus"></i> Agregar Registro</a>
            </div>
        </div>

        <table class="table table-dark table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Género</th>
                    <th scope="col">Poster</th>
                    <th scope="col">Fecha Lanzamiento</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_pelicula = $peliculas->fetch_assoc()) { ?>
                    <tr>
                        <td scope="row"><?= $row_pelicula['id']; ?></td>
                        <td><?= $row_pelicula['nombre']; ?></td>
                        <td><?= $row_pelicula['descripcion']; ?></td>
                        <td><?= $row_pelicula['genero']; ?></td>
                        <td>
                            <img src="<?= $dir .$row_pelicula['id'].'.jpg'; ?>" alt="<?= $row_pelicula['nombre'];?>" width="80">
                        </td>
                        <td><?= $row_pelicula['fecha_alta']; ?></td>
                        <td class="text-center">
                            <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="<?= $row_pelicula['id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row_pelicula['id']; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Alert -->
        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
            <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['msg']);
            unset($_SESSION['color']);
        } ?>


        <?php include('nuevoModal.php') ?>

        <!-- Reinicia el select de editaModal -->
        <?php $generos->data_seek(0); ?>

        <?php include('editaModal.php') ?>

        <?php include('eliminaModal.php') ?>

    </div><!-- .container -->

    <script>
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')

        // Función editar
        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            // Acceder a los datos del formulario para editar
            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
            let inputGenero = editaModal.querySelector('.modal-body #genero')
            let poster = editaModal.querySelector('.modal-body #img_poster')

            //Ajax
            let url = "getPelicula.php"
            let formData = new FormData()
            formData.append('id', id)

            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    inputId.value = data.id
                    inputNombre.value = data.nombre
                    inputDescripcion.value = data.descripcion
                    inputGenero.value = data.id_genero
                    poster.src = '<?= $dir ?>' + data.id + '.jpg';
                }).catch(err => console.log(err))
        })

        // Función Eliminar
        eliminaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            eliminaModal.querySelector('.modal-body #id').value = id
        })
    </script>

    <?php include('../templates/footer.php'); ?>