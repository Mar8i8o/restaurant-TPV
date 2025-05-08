<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>TPV Restaurante</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <div>
      <a href="mesas.html" id="backButton">&#8592; Mesas</a>
    </div>
    <div><strong>Mesa: <span id="nombreMesa">Sin nombre</span></strong></div>
    <div class="estado" id="errorHeader">Ocupada</div>
    <div><?= date('d/m/Y') ?></div>
  </header>

  <div class="container">
    <div class="panel-izquierdo">
      <div class="productos" id="panelProductos"></div>
      <div id="totalContainer">
        <strong>Total: <span id="totalPedido">0.00€</span></strong>
      </div>
      <div class="teclado">
        <button>7</button><button>8</button><button>9</button><button style="background-color: red; color: white;" id="delButton">DEL</button>
        <button>4</button><button>5</button><button>6</button><button>DTO</button>
        <button>1</button><button>2</button><button>3</button><button>CAN</button>
        <button>0</button><button>.</button><button>CLR</button><button>PREC</button>
      </div>
    </div>

    <div class="panel-categorias">
      <div class="categorias">
        <button class="categoria-estatica" data-categoria-id="todo">Todo</button>
        <button class="categoria-estatica" data-categoria-id="1">Menus</button>
        <button class="categoria-estatica" data-categoria-id="2">Platos combinados</button>
      </div>
      <div class="categorias-dinamicas"></div>
    </div>

    <div class="panel-derecho">
      <div class="productos-grid" id="productosGrid"></div>
    </div>
  </div>

  <footer>
    <button id="cobrarButton">Cobrar</button>
    <button>Imprimir</button>
  </footer>

  <!-- Modal -->
  <div id="modalConfirmacion" class="modal">
    <div id="modalFondo" class="modal-content">
      <h2>¿Quiere finalizar la comanda?</h2>
      <button id="confirmarCobro">Aceptar</button>
      <button id="cancelarCobro">Cancelar</button>
    </div>
  </div>

  <script>
  const grid = document.getElementById('productosGrid');
  const errorHeader = document.getElementById('errorHeader');
  const contenedorCategorias = document.querySelector('.categorias-dinamicas');
  const panelProductos = document.getElementById('panelProductos');
  const delButton = document.getElementById('delButton');
  const cobrarButton = document.getElementById('cobrarButton');
  const modalConfirmacion = document.getElementById('modalConfirmacion');
  const confirmarCobro = document.getElementById('confirmarCobro');
  const cancelarCobro = document.getElementById('cancelarCobro');
  let productos = [];
  let productoSeleccionado = null;

  function obtenerParametro(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
  }

  const nombreMesa = obtenerParametro('mesa');
  document.getElementById('nombreMesa').textContent = nombreMesa ? nombreMesa : 'Sin nombre';

  // Cargar productos desde la base de datos
  fetch('database/platos.php')
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        errorHeader.textContent = "ERROR DATABASE CONNECTION";
      } else {
        productos = data;
        mostrarProductos(productos);
        cargarComandasDesdeBD(); // Cargar las comandas al cargar la página
      }
    })
    .catch(error => {
      console.error('Error al obtener los productos:', error);
      errorHeader.textContent = "ERROR DATABASE CONNECTION";
    });

    fetch('database/categorias.php')
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          errorHeader.textContent = "ERROR CATEGORIAS";
        } else {
          contenedorCategorias.innerHTML = '';
          data.forEach(categoria => {
            const btn = document.createElement('button');
            btn.textContent = categoria.Nombre;
            btn.style.backgroundColor = categoria.Color;
            btn.dataset.categoriaId = categoria.Categoria_id;
            btn.addEventListener('click', () => {
              const categoriaId = btn.dataset.categoriaId;
              const filtrados = productos.filter(p => p.Categoria_id == categoriaId);
              mostrarProductos(categoriaId === 'todo' ? productos : filtrados);
            });
            contenedorCategorias.appendChild(btn);
          });
        }
      })
      .catch(error => {
        console.error('Error al obtener las categorías:', error);
        errorHeader.textContent = "ERROR CATEGORIAS";
      });

    document.querySelectorAll('.categoria-estatica').forEach(button => {
      button.addEventListener('click', (e) => {
        const categoriaId = e.target.dataset.categoriaId;
        const filtrados = productos.filter(p => p.Categoria_id == categoriaId);
        mostrarProductos(categoriaId === 'todo' ? productos : filtrados);
      });
    });

  // Mostrar productos en el grid
  function mostrarProductos(lista) {
    grid.innerHTML = '';
    if (lista.length === 0) {
      grid.innerHTML = '<p>No hay productos disponibles</p>';
    } else {
      lista.forEach(producto => {
        const btn = document.createElement('button');
        btn.className = 'producto-btn';
        btn.textContent = `${producto.nombre} - ${producto.Precio}€`;
        btn.addEventListener('click', () => agregarProductoAlPanel(producto));
        grid.appendChild(btn);
      });
    }
  }

  // SELECCIONAR PRODUCTO PARA AGREGAR AL PANEL
  function agregarProductoAlPanel(producto) {
    console.log('Producto seleccionado');
    const existente = panelProductos.querySelector(`[data-producto-id="${producto.id}"]`);

    // Si el producto ya está en el panel, simplemente actualizamos su cantidad
    if (existente) {
      const cantidadEl = existente.querySelector('.cantidad');
      const totalEl = existente.querySelector('.total');
      const cantidad = parseInt(cantidadEl.textContent) + 1;
      const total = (cantidad * parseFloat(producto.Precio)).toFixed(2);
      cantidadEl.textContent = cantidad;
      totalEl.textContent = `${total}€`;

      // Solo se actualiza la base de datos cuando se agrega un producto o se cambia la cantidad
      actualizarComandaEnBD(producto.id, cantidad);

      if (productoSeleccionado !== existente) {
        if (productoSeleccionado) productoSeleccionado.classList.remove('seleccionado');
        existente.classList.add('seleccionado');
        productoSeleccionado = existente;
      }
    } else {
      // Si el producto no está en el panel, lo agregamos
      const btn = document.createElement('button');
      btn.className = 'linea-producto';
      btn.dataset.productoId = producto.id;
      btn.innerHTML = `
        <span class="cantidad">1</span>x 
        <span class="nombre">${producto.nombre}</span> - 
        <span class="precio">${parseFloat(producto.Precio).toFixed(2)}€</span> = 
        <span class="total">${parseFloat(producto.Precio).toFixed(2)}€</span>
      `;
      btn.addEventListener('click', () => {
        if (productoSeleccionado && productoSeleccionado !== btn) {
          productoSeleccionado.classList.remove('seleccionado');
        }
        if (productoSeleccionado === btn) {
          btn.classList.remove('seleccionado');
          productoSeleccionado = null;
        } else {
          btn.classList.add('seleccionado');
          productoSeleccionado = btn;
        }
      });
      panelProductos.appendChild(btn);
      if (productoSeleccionado) productoSeleccionado.classList.remove('seleccionado');
      btn.classList.add('seleccionado');
      productoSeleccionado = btn;

      // Insertamos el producto en la base de datos (agregar la comanda)
      actualizarComandaEnBD(producto.id, 1);  // En este caso, iniciamos la cantidad en 1
    }

    // Actualizamos el total
    actualizarTotal();
  }

  // Actualizar el total del pedido
  function actualizarTotal() {
    const lineas = panelProductos.querySelectorAll('.linea-producto');
    let total = 0;
    lineas.forEach(linea => {
      const totalTexto = linea.querySelector('.total').textContent.replace('€', '');
      total += parseFloat(totalTexto);
    });
    document.getElementById('totalPedido').textContent = total.toFixed(2) + '€';
  }

  // Actualizar la base de datos con los cambios
  function actualizarComandaEnBD(productoId, cantidad) {
    fetch('database/comandas.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        mesa: nombreMesa,   // Esto lo pasamos desde el parámetro de la URL
        producto_id: productoId,
        cantidad: cantidad
      })
    })
    .then(response => response.json())
    .then(data => {
      console.log('Comanda actualizada:', data);
    })
    .catch(error => {
      console.error('Error al actualizar la comanda:', error);
    });
  }

  // Cargar comandas de la base de datos
  function cargarComandasDesdeBD() {
    fetch(`database/comandas.php?mesa=${nombreMesa}`)
      .then(response => response.json())
      .then(data => {
        console.log(data); // Verifica qué datos se están recibiendo
        if (Array.isArray(data)) {  // Asegúrate de que sea un array
          data.forEach(comanda => {
            const producto = productos.find(p => p.id == comanda.producto_id);
            if (producto) {
              // Verifica si el producto ya está en el panel antes de agregarlo
              const existente = panelProductos.querySelector(`[data-producto-id="${producto.id}"]`);
              if (existente) {
                // Si existe, solo actualizamos la cantidad
                const cantidadEl = existente.querySelector('.cantidad');
                const cantidad = parseInt(cantidadEl.textContent) + comanda.cantidad; // Sumar las cantidades
                const totalEl = existente.querySelector('.total');
                const total = (cantidad * parseFloat(producto.Precio)).toFixed(2);
                cantidadEl.textContent = cantidad;
                totalEl.textContent = `${total}€`;

                // Solo actualizamos la base de datos si la cantidad es diferente
                actualizarComandaEnBD(producto.id, cantidad);
              } else {
                // Si no existe, agregamos el producto al panel
                for (let i = 0; i < comanda.cantidad; i++) {
                  agregarProductoAlPanel(producto); // Esto ya manejará la cantidad
                }
              }
            }
          });
        } else {
          console.error("La respuesta no es un array válido", data);
        }
      })
      .catch(error => {
        console.error('Error al cargar las comandas:', error);
        errorHeader.textContent = "ERROR AL CARGAR COMANDAS";
      });
  }

  // Eliminar producto del panel
  delButton.addEventListener('click', () => {
    if (productoSeleccionado) {
      productoSeleccionado.remove();
      productoSeleccionado = null;
      actualizarTotal();
    }
  });

  // Cobrar el pedido
  cobrarButton.addEventListener('click', () => {
    modalConfirmacion.style.display = 'block';
  });

  // Confirmar cobro
  confirmarCobro.addEventListener('click', () => {
    panelProductos.innerHTML = '';
    actualizarTotal();
    modalConfirmacion.style.display = 'none';
  });

  // Cancelar cobro
  cancelarCobro.addEventListener('click', () => {
    modalConfirmacion.style.display = 'none';
  });
</script>


  <style>
    /* Estilos para la ventana modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
    }
    .modal button {
      margin: 10px;
      padding: 10px;
      cursor: pointer;
    }
  </style>

</body>
</html>
