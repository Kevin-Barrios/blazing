<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carrito - Blazing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fafafa;
      color: #333;
      background-image: url('{{ asset("imagenes/Fondo body pagina blazing.svg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      margin: 0;
      display: flex;
      overflow-x: hidden;
      flex-direction: column;
    }

    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #e67e22;
      color: white;
      padding-top: 60px;
      transition: transform 0.3s ease;
      overflow-y: auto;
      z-index: 1000;
    }
    #sidebar.collapsed { transform: translateX(-100%); }
    #sidebar h3 { padding-left:20px; margin-bottom:1rem; font-weight:700; border-bottom:1px solid rgba(255,255,255,0.3); padding-bottom:0.5rem; }
    #sidebar ul { list-style:none; padding-left:0; }
    #sidebar ul li { padding:12px 20px; cursor:pointer; transition:background-color 0.2s ease; }
    #sidebar ul li:hover { background-color:rgba(255,255,255,0.2); }
    #sidebar ul li a { color:white; text-decoration:none; display:block; font-weight:600; }

    #sidebarToggle {
      position: fixed;
      top: 15px;
      left: 15px;
      background-color: #e67e22;
      border: none;
      color: white;
      padding: 10px 12px;
      border-radius: 4px;
      cursor: pointer;
      z-index: 1100;
      font-weight: 700;
      box-shadow: 0 2px 5px rgba(0,0,0,0.3);
      transition: background-color 0.3s ease;
    }
    #sidebarToggle:hover { background-color:#cf711b; }

    nav.navbar {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      height: 50px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      padding: 0 1rem;
      transition: left 0.3s ease;
      z-index: 900;
    }
    nav.navbar.expanded { left: 0; }
    nav.navbar .navbar-brand img { height: 40px; object-fit: contain; }

    #content {
      margin-left: 250px;
      margin-top: 60px;
      margin-bottom: 80px;
      padding: 2rem 1.5rem;
      flex-grow: 1;
      transition: margin-left 0.3s ease;
      width: 100%;
    }
    #content.expanded { margin-left: 0; }

    footer {
      background-color: #222;
      color: #eee;
      padding: 1rem;
      text-align: center;
      font-size: 0.8rem;
      position: fixed;
      bottom: 0;
      left: 250px;
      right: 0;
      z-index: 800;
      transition: left 0.3s ease;
    }
    footer .footer-logo img { height:30px; object-fit:contain; }
  </style>
</head>
<body>
  <button id="sidebarToggle" aria-label="Toggle sidebar">☰</button>

  <aside id="sidebar">
    <h3>Categorías</h3>
    <ul>
      <li><a href="{{ url('/catalogo?categoria=camisas&talla=' . request('talla')) }}">Camisas</a></li>
      <li><a href="{{ url('/catalogo?categoria=chaquetas&talla=' . request('talla')) }}">Chaquetas</a></li>
      <li><a href="{{ url('/catalogo?categoria=buzos&talla=' . request('talla')) }}">Buzos</a></li>
      <li><a href="{{ url('/catalogo?categoria=camisetas&talla=' . request('talla')) }}">Camisetas</a></li>
    </ul>
    <h3>Otros</h3>
    <ul>
      <li><a href="{{ url('/carrito') }}">Carrito</a></li>
      <li><a href="{{ url('/metodos-pago') }}">Métodos de pago</a></li>
      <li><a href="{{ url('/inicio') }}">Inicio</a></li>
    </ul>
  </aside>

  <nav class="navbar">
    <a href="{{ url('/inicio') }}" class="navbar-brand">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Blazing Store Logo">
    </a>
  </nav>

  <main id="content" class="container">
    <h2 class="mb-4 fw-bold">Carrito de Compras</h2>

    <div id="cart-container" class="bg-white p-4 rounded shadow-sm mb-4">
      <!-- Aquí se mostrarán los productos del carrito -->
    </div>

    <div class="bg-warning bg-opacity-25 p-4 rounded text-center">
      <h3>Total: $<span id="total-price">0</span></h3>

      <!-- Formulario para finalizar compra -->
  <form id="cart-form" action="{{ route('seleccionar-metodo.post') }}" method="POST">
    @csrf
    <input type="hidden" name="cart" id="cart-input">
    <button type="submit" class="btn btn-success">Finalizar compra</button>
</form>

      <button class="btn btn-warning mt-2" onclick="generarPDF()">Descargar factura</button>
    </div>
  </main>

  <footer>
    <div class="footer-logo">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Blazing Store Logo">
    </div>
    <p>© 2025 Blazing Store. Todos los derechos reservados.</p>
  </footer>

  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const content = document.getElementById('content');
    const navbar = document.querySelector('nav.navbar');
    const footer = document.querySelector('footer');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      content.classList.toggle('expanded');
      navbar.classList.toggle('expanded');
      footer.classList.toggle('expanded');
    });

    function loadCart() {
      const cartContainer = document.getElementById('cart-container');
      const totalPriceEl = document.getElementById('total-price');
      let cart = JSON.parse(localStorage.getItem('cart')) || [];

      if (cart.length === 0) {
        cartContainer.innerHTML = '<p>El carrito está vacío.</p>';
        totalPriceEl.textContent = '0';
        return;
      }

      let total = 0;
      let html = '<table class="table">';
      html += `<thead>
        <tr>
          <th>Producto</th>
          <th>Talla</th>
          <th>Color</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>`;

      cart.forEach((item, index) => {
        const subtotal = item.precio * item.quantity;
        total += subtotal;
        html += `<tr>
          <td>${item.nombre}</td>
          <td>${item.talla || '-'}</td>
          <td>${item.color || '-'}</td>
          <td>$${item.precio.toLocaleString('es-CL')}</td>
          <td>
            <input type="number" min="1" value="${item.quantity}" style="width: 60px;" onchange="updateQuantity(${index}, this.value)">
          </td>
          <td>$${subtotal.toLocaleString('es-CL')}</td>
          <td><button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Eliminar</button></td>
        </tr>`;
      });

      html += '</tbody></table>';
      cartContainer.innerHTML = html;
      totalPriceEl.textContent = total.toLocaleString('es-CL');
    }

    function updateQuantity(index, quantity) {
      quantity = parseInt(quantity);
      if (quantity < 1) quantity = 1;
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart[index].quantity = quantity;
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }

    function removeItem(index) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }

    function clearCart() {
      if (confirm('¿Estás seguro que quieres vaciar el carrito?')) {
        localStorage.removeItem('cart');
        loadCart();
      }
    }


    function generarPDF() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      if (cart.length === 0) {
        alert('El carrito está vacío.');
        return;
      }

      if (typeof jsPDF === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
        script.onload = () => crearPDF(cart);
        document.body.appendChild(script);
      } else {
        crearPDF(cart);
      }
    }

    document.getElementById('cart-form').addEventListener('submit', function(e){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if(cart.length === 0){
        e.preventDefault();
        alert('El carrito está vacío.');
        return;
    }
    document.getElementById('cart-input').value = JSON.stringify(cart);
});

    function crearPDF(cart) {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.setFontSize(18);
      doc.text('Factura - Blazing Store', 14, 22);
      doc.setFontSize(12);

      let y = 30;
      let total = 0;
      cart.forEach(item => {
        const subtotal = item.precio * item.quantity;
        total += subtotal;
        doc.text(`${item.nombre} - Talla: ${item.talla || '-'} - Color: ${item.color || '-'} - Cantidad: ${item.quantity} - Subtotal: $${subtotal.toLocaleString('es-CL')}`, 14, y);
        y += 10;
      });

      doc.text(`Total: $${total.toLocaleString('es-CL')}`, 14, y + 10);
      doc.save('factura_blazing_store.pdf');
    }

    document.addEventListener('DOMContentLoaded', loadCart);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
