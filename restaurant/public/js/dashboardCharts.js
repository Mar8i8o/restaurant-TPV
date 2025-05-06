


function getStock() {
    // URL del endpoint PHP
    const url = './api/getStock.php';

    // Datos que enviarás al servidor (el ID del restaurante)
    const data = {
        restaurant_id: 1 // Cambia este valor por el ID correcto
    };

    // Enviar la solicitud con fetch y retornar la promesa
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data) // Convierte el objeto 'data' a JSON
    })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .catch(error => {
            console.error('Error:', error);
            throw error; // Re-lanzar el error para que pueda ser manejado
        });
}


function filtrarIngredientesElaborados(stockList) {

    console.log(stockList);
    let elaborados = [];
    let ingredientes = [];

    stockList.forEach(stock => {
        if (stock['elaborado_id'] == null) {
            ingredientes.push(stock); // Agrega a la lista de ingredientes
        } else {
            elaborados.push(stock); // Agrega a la lista de elaborados
        }
    });

    let stock = {
        ingredientes: ingredientes,
        elaborados: elaborados
    };

    return stock;
}


function sumarCantidadesStockTotales(stockList, campo) {
    return stockList.reduce((acc, item) => {
        // Verifica si el campo a agrupar es válido
        if (!item[campo]) return acc;

        // Verifica si ya existe el campo en el acumulador
        if (!acc[item[campo]]) {
            // Si no existe, lo inicializa con el item y cantidad en 0
            acc[item[campo]] = { ...item, cantidad_stock: 0 }; // Inicializa con los datos del item
        }

        // Acumula la cantidad de 'cantidad_stock'
        acc[item[campo]].cantidad_stock += item.cantidad_stock || 0; // Si es null o undefined, suma 0

        return acc;
    }, {});
}

function sumarCantidadesEstado(stockList, campo) {
    return stockList.reduce((acc, item) => {
        // Verifica si el campo existe en el objeto
        let clave = item[campo];
        if (!clave) return acc;

        // Verifica si ya existe el campo en el acumulador
        if (!acc[clave]) {
            // Si no existe, lo inicializa con el item y cantidad en 0
            acc[clave] = { ...item, cantidad_stock: 0 }; // Inicializa con los datos del item
        }

        // Acumula la cantidad de 'cantidad_stock'
        acc[clave].cantidad_stock += item.cantidad_stock || 0; // Si es null o undefined, suma 0

        return acc;
    }, {});
}


// Convertimos el objeto resultante en un arreglo
function convertirAColeccion(obj) {
    return Object.values(obj);
}

function filtrarPorCaducidad(stockList) {

    let bien = [];
    let cercaCaducar = [];
    let caducado = [];
    let fechaActual = new Date();

    // Creamos una nueva fecha para calcular la fecha dentro de 7 días
    let fechaDentroDe7Dias = new Date();
    fechaDentroDe7Dias.setDate(fechaActual.getDate() + 7);

    stockList.forEach(stock => {
        let fechaCaducidad = new Date(stock['caducidad']); // Asegurarse que caducidad sea una fecha válida

        if (fechaCaducidad < fechaActual) {
            caducado.push(stock);
        } else if (fechaCaducidad <= fechaDentroDe7Dias) {
            cercaCaducar.push(stock);
        }
        else {
            bien.push(stock);
        }
    });

    let listaFiltrada = {
        bien: bien,
        cerca_caducar: cercaCaducar,
        caducado: caducado
    }

    return listaFiltrada;
}

function agruparPorEstado(list) {
    const estados = ['bien', 'cerca_caducar', 'caducado'];
    const campos = ['ingrediente_id', 'elaborado_id'];

    let resultados = {};

    estados.forEach(estado => {
        campos.forEach(campo => {
            resultados[`${estado}_${campo}`] = convertirAColeccion(
                sumarCantidadesEstado(list[estado], campo)
            );
        });
    });

    return resultados;
}


async function chartCaducidad() {
    try {
        let stockList = await getStock();
        let listaFiltrada = filtrarPorCaducidad(stockList);
        let resultadosAgrupados = agruparPorEstado(listaFiltrada);

        let bienCount = resultadosAgrupados.bien_ingrediente_id.length + resultadosAgrupados.bien_elaborado_id.length;
        let cercaCaducarCount = resultadosAgrupados.cerca_caducar_ingrediente_id.length + resultadosAgrupados.cerca_caducar_elaborado_id.length;
        let caducadoCount = resultadosAgrupados.caducado_ingrediente_id.length + resultadosAgrupados.caducado_elaborado_id.length;

        if (!document.getElementById("chartCaducidad")) {
            return false;
        }

        let canvas = document.getElementById("chartCaducidad").getContext("2d");
        let canvasDOM = document.getElementById("chartCaducidad");

        let chart = new Chart(canvas, {
            type: 'pie',
            data: {
                labels: ["More than 7 days to expire", "7 days to expire", "Expired"],
                datasets: [{
                    label: "Estado",
                    data: [bienCount, cercaCaducarCount, caducadoCount],
                    backgroundColor: ["#007934", "#e68a2e", "rgb(255, 100, 100)"],
                    borderWidth: 0,
                }]
            }
        });

        canvasDOM.addEventListener("click", (ev) => {
            window.location.href = "/stock-caducity.html";
        });

    } catch (error) {
        console.error('Error en chartCaducidad:', error);
    }
}


function chartMasVendidos() {
    if (!document.getElementById("chartMasVendidos")) {
        return false
    }

    let canvas = document.getElementById("chartMasVendidos").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: ["Esp. Boloñesa", "Lasaña", "Pizza 4 quesos", "Espaguetis Carbonara", "Pan", "Macarrones Arrabiata"],
            datasets: [{
                label: "Ud Vendidas",
                data: [20, 15, 10, 6, 4, 2],
                backgroundColor: "#007934",
                borderWidth: 0,
            }]
        }
    })
}

function chartVendidos() {
    if (!document.getElementById("chartVendidos")) {
        return false
    }

    let canvas = document.getElementById("chartVendidos").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [{
                label: "Ud Vendidas",
                data: [20, 15, 10, 6, 45, 60, 0],
                backgroundColor: "#00793472",
                borderColor: "#007934",
                borderWidth: 1,
                fill: true,
            }]
        }
    })
}

function chartVentas() {
    if (!document.getElementById("chartVentas")) {
        return false
    }

    let canvas = document.getElementById("chartVentas").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [{
                label: "Ventas €",
                data: [2000, 1000, 1200, 500, 4500, 2200, 0],
                backgroundColor: "#00793472",
                borderColor: "#007934",
                borderWidth: 1,
                fill: true,
            }]
        }
    })
}





function chartComprados() {
    if (!document.getElementById("chartComprados")) {
        return false
    }

    let canvas = document.getElementById("chartComprados").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [{
                label: "Ud Vendidas",
                data: [20, 15, 10, 6, 45, 60, 0],
                backgroundColor: "#00793472",
                borderColor: "#007934",
                borderWidth: 1,
                fill: true,
            }]
        }
    })
}

function chartCompras() {
    if (!document.getElementById("chartCompras")) {
        return false
    }

    let canvas = document.getElementById("chartCompras").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [{
                label: "Ventas €",
                data: [2000, 1000, 1200, 500, 4500, 2200, 0],
                backgroundColor: "#00793472",
                borderColor: "#007934",
                borderWidth: 1,
                fill: true,
            }]
        }
    })
}

function chartDeshechados() {
    if (!document.getElementById("chartDeshechados")) {
        return false
    }

    let canvas = document.getElementById("chartDeshechados").getContext("2d")
    let chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [{
                label: "Ud Perdidas",
                data: [3, 1, 0, 3, 0, 0, 0],
                backgroundColor: "#ff000072",
                borderColor: "#FF0000",
                borderWidth: 1,
                fill: true,
            }]
        }
    })
}
async function chartMenosStock() {
    try {
        // Llama a la función getStock y espera la respuesta
        let stockList = await getStock();

        // Filtra los ingredientes y elaborados
        let stockFilterList = filtrarIngredientesElaborados(stockList);

        // Obtén las listas de ingredientes y elaborados
        let ingredientsList = stockFilterList['ingredientes'];
        let elaborateList = stockFilterList['elaborados'];

        // Suma las cantidades
        const resultadoPorIngrediente = sumarCantidadesStockTotales(ingredientsList, 'ingrediente_id');
        const resultadoPorElaborado = sumarCantidadesStockTotales(elaborateList, 'elaborado_id');

        // Convierte a colección
        const resultadoFinalPorIngrediente = convertirAColeccion(resultadoPorIngrediente);
        const resultadoFinalPorElaborado = convertirAColeccion(resultadoPorElaborado);

        // Verifica si el canvas existe
        if (!document.getElementById("chartMenosStock")) {
            return false;
        }

        let canvas = document.getElementById("chartMenosStock").getContext("2d");

        // Configura los datos del gráfico
        let chart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: resultadoFinalPorElaborado.map(item => item.elaborado_nombre), // Usamos el nombre de cada elaborado
                datasets: [{
                    label: "Stock",
                    data: resultadoFinalPorElaborado.map(item => item.cantidad_stock), // Usamos la cantidad de cada elaborado
                    backgroundColor: "#ff000072",
                    borderColor: "#FF0000",
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
            }
        });

    } catch (error) {
        console.error('Error en chartMenosStock:', error);
    }
}


async function tablaStockBajo() {
    let tBody = document.getElementById('body_stock');
    try {
        // Llama a la función getStock y espera la respuesta
        let stockList = await getStock();


        // Filtra los ingredientes y elaborados
        let stockFilterList = filtrarIngredientesElaborados(stockList);

        // Obtén las listas de ingredientes y elaborados
        //  let ingredientsList = stockFilterList['ingredientes'];
        let elaborateList = stockFilterList['elaborados'];

        // Suma las cantidades
        //  const resultadoPorIngrediente = sumarCantidadesStockTotales(ingredientsList, 'ingrediente_id');
        const resultadoPorElaborado = sumarCantidadesStockTotales(elaborateList, 'elaborado_id');

        // Convierte a colección
        //  const resultadoFinalPorIngrediente = convertirAColeccion(resultadoPorIngrediente);
        const resultadoFinalPorElaborado = convertirAColeccion(resultadoPorElaborado);

        resultadoFinalPorElaborado.forEach(elaborado => {

            let tr = document.createElement('tr');
            let tdNombre = document.createElement('td');
            let tdCantidad = document.createElement('td');
            tdNombre.textContent = elaborado['elaborado_nombre']
            tdCantidad.textContent = elaborado['cantidad_stock']

            tr.appendChild(tdNombre);
            tr.appendChild(tdCantidad);

            tBody.appendChild(tr);

        });



    } catch (error) {
        console.error('Error :', error);
    }

}

(async function init() {
    await getStock(); // Llama a getStock para inicializar, si es necesario
    chartVendidos();
    chartVentas();
    chartComprados();
    chartCompras()
    await chartMenosStock(); // Asegúrate de esperar a que se complete
    chartDeshechados();
    chartMasVendidos();
    chartCaducidad();
    await tablaStockBajo()

})();
