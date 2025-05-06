<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';
include_once 'save_dish.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dish</title>

    <link rel="stylesheet" href="./css/dishForm.css">

</head>

<body>
    <nav>
        <div>
            <img src="./img/ccsLogoWhite.png" alt="Cook Code System Logo">
            <button>III</button>
        </div>
        <ul>
            <a href="dashboard.php">
                <li> <object data="./svg/dashboard.svg" type="image/svg+xml"></object>Dashboard</li>
            </a>
            <a href="analytics.php">
                <li> <object data="./svg/graph.svg" type=""></object>Analytics</li>
            </a>
            <a href="stock.php">
                <li> <object data="./svg/stock.svg" type=""></object>Stock</li>
            </a>
            <a href="receipts.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Receipts</li>
            </a>
            <a href="dishForm.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Dish preparation</li>
            </a>
            <a href="dishes.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Dishes</li>
            </a>
            <a href="dish.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Dish preparation</li>
            </a>
            <a href="orders.php">
                <li> <object data="./svg/orders.svg" type=""></object>Orders</li>
            </a>
            <a href="tpv.html">
                <li> <object data="./svg/tpv.svg" type=""></object>TPV</li>
            </a>
            <a href="settings.php">
                <li> <object data="./svg/settings.svg" type=""></object>Settings</li>
            </a>
        </ul>
    </nav>

    <main>

        <div id="header">
            <h2 id="mainTitle">Dish</h2>
            <div id="userBubble">
                <img src="./img/test.jpg" alt="">
                <h4 class="user_data-username">Not logged</h3>
                    <span>···</span>
            </div>
        </div>

        <section>
            <form id="elaboracionForm" action="dishForm.php" method="POST" enctype="multipart/form-data">
                <card>




                    <!-- Campo para la imagen -->




                    <label for="imagen" style="cursor: pointer;">
                        <div id="contenedorimagenCh">
                            <img src="./svg/image.svg" id="imagenCh" alt="Insert Image" width="150" height="150" />
                        </div>
                    </label>
                    </div>
                    <div class="form-group col-md-10">
                        <p id="pCh">Click on the photo to Insert Image</p>
                        <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)" style="display: none" ;>
                    </div>








                    <!-- Campo para el nombre del plato -->
                    <label>Nombre del plato:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Introduce el nombre del plato" required>











                    <!-- Tabla para los platos elaborados -->
                    <h3>Platos Preelaborados:</h3>
                    <table id="platosElaboradosTabla">
                        <tr>
                            <th>Nombre del Plato</th>
                            <th>Cantidad</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="platos_elaborados[nombre][]" class="platoElaborado" placeholder="Nombre del plato preelaborado"></td>
                            <td><input type="number" name="platos_elaborados[cantidad][]" class="cantidadPlatoElaborado" placeholder="Cantidad"></td>
                        </tr>
                    </table>

                    <!-- Tabla para los ingredientes -->
                    <h3>Ingredientes:</h3>
                    <table id="ingredientesTabla">
                        <tr>
                            <th>Ingrediente</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="ingredientes[nombre][]" class="ingrediente" placeholder="Ingrediente"></td>
                            <td><input type="number" name="ingredientes[cantidad][]" class="cantidad" placeholder="Cantidad"></td>
                            <td>
                                <select name="ingredientes[unidad][]" class="unidad" required>
                                    <option value="qty">Qty</option>
                                    <option value="kg">Kg</option>
                                    <option value="g">g</option>
                                    <option value="l">l</option>
                                    <option value="ml">ml</option>
                                    <option value="lb">lb</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <!-- Campo para las instrucciones -->
                    <label>Instrucciones:</label>
                    <textarea id="instrucciones" name="instrucciones" rows="4" cols="50" placeholder="Introduce las instrucciones para la preparación" required></textarea>


                    <button type="submit">Guardar Plato</button>
                </card>
            </form>
        </section>
    </main>
</body>

</html>



<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagenCh');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }



    // Función para mostrar vista previa de la imagen
    document.getElementById('imagen').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result; // Establecer la fuente de la imagen a la vista previa
                preview.style.display = 'block'; // Mostrar la imagen
            }

            reader.readAsDataURL(file); // Leer la imagen como Data URL
        } else {
            preview.src = ''; // Reiniciar la vista previa
            preview.style.display = 'none'; // Ocultar la imagen si no hay archivo
        }
    });










    // Función para añadir automáticamente nueva fila de ingredientes cuando se llena una fila
    function agregarIngredienteAutomaticamente() {
        var tabla = document.getElementById("ingredientesTabla");
        var fila = tabla.insertRow(-1);
        var celda1 = fila.insertCell(0);
        var celda2 = fila.insertCell(1);
        var celda3 = fila.insertCell(2);

        celda1.innerHTML = '<input type="text" class="ingrediente" placeholder="Ingrediente">';
        celda2.innerHTML = '<input type="number" class="cantidad" placeholder="Cantidad">';
        celda3.innerHTML = '<select class="unidad"><option value="g">g</option><option value="ml">ml</option><option value="unidad">Unidad</option></select>';
    }

    // Función para añadir automáticamente nueva fila de platos elaborados cuando se llena una fila
    function agregarPlatoElaboradoAutomaticamente() {
        var tabla = document.getElementById("platosElaboradosTabla");
        var fila = tabla.insertRow(-1);
        var celda1 = fila.insertCell(0);
        var celda2 = fila.insertCell(1);

        celda1.innerHTML = '<input type="text" class="platoElaborado" placeholder="Nombre del plato elaborado">';
        celda2.innerHTML = '<input type="number" class="cantidadPlatoElaborado" placeholder="Cantidad">';
    }

    // Detectar cambios en los ingredientes y añadir fila automáticamente
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('ingrediente') || event.target.classList.contains('cantidad') || event.target.classList.contains('unidad')) {
            var ultimaFila = document.querySelectorAll('#ingredientesTabla tr:last-child input');
            if ([...ultimaFila].every(input => input.value !== "")) {
                agregarIngredienteAutomaticamente();
            }
        }

        // Detectar cambios en los platos elaborados y añadir fila automáticamente
        if (event.target.classList.contains('platoElaborado') || event.target.classList.contains('cantidadPlatoElaborado')) {
            var ultimaFilaElaborado = document.querySelectorAll('#platosElaboradosTabla tr:last-child input');
            if ([...ultimaFilaElaborado].every(input => input.value !== "")) {
                agregarPlatoElaboradoAutomaticamente();
            }
        }
    });
</script>