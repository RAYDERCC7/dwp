<?php
session_start(); // Iniciar sesión en todas las páginas

// Verifica si hay sesión iniciada
$user_name = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Invitado";
$user_logged_in = isset($_SESSION["user_id"]); // Esto será verdadero si hay sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Texicana</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<script>
    let carrito = [];

    function agregarAlCarrito(nombre, precio) {
        let producto = carrito.find(p => p.nombre === nombre);
        if (producto) {
            producto.cantidad++;
        } else {
            carrito.push({ nombre, precio, cantidad: 1 });
        }
        actualizarCarrito();
        Swal.fire({
        icon: 'success',
        title: '¡Producto agregado!',
        text: `${nombre} se ha agregado al carrito.`,
        showConfirmButton: false,
        timer: 1500
    });
    }
    

    function actualizarCarrito() {
        let totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
        document.querySelector(".cart span").textContent = totalItems;
        mostrarProductosEnCarrito();
    }


    function mostrarProductosEnCarrito() {
        let listaCarrito = document.getElementById("lista-carrito");
        let totalCarrito = document.getElementById("total-carrito");
        listaCarrito.innerHTML = "";
        let total = 0;

        carrito.forEach((producto, index) => {
            let div = document.createElement("div");
            div.classList.add("carrito-item");
            div.innerHTML = `
                <span>${producto.nombre} - $${producto.precio} x ${producto.cantidad}</span>
                <button onclick="eliminarDelCarrito(${index})">Eliminar</button>
            `;
            listaCarrito.appendChild(div);
            total += producto.precio * producto.cantidad;
        });

        totalCarrito.textContent = total.toFixed(2);
    }

    function eliminarDelCarrito(index) {
        carrito.splice(index, 1);
        actualizarCarrito();
    }

    function vaciarCarrito() {
        carrito = [];
        actualizarCarrito();
    }

    function mostrarCarrito() {
        document.getElementById("carritoModal").style.display = "block";
    }

    function cerrarCarrito() {
        document.getElementById("carritoModal").style.display = "none";
    }
</script>

<!-- Modal del Carrito -->
<div id="carritoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarCarrito()">&times;</span>
        <h2>Carrito de Compras</h2>
        <div id="lista-carrito"></div>
        <p><strong>Total: $<span id="total-carrito">0.00</span></strong></p>
        <button onclick="vaciarCarrito()">Vaciar Carrito</button>
    </div>
</div>


<body>
    <header>
        <h1>La Texicana</h1>
        <nav>
            <ul>
         <li><a href="#inicio">Inicio</a></li>
            <li><a href="#acerca-de">Acerca de nosotros</a></li>
            <li><a href="#menu">Menú</a></li>
            <li><a href="#galeria">Galería</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <div id="google_translate_element"></div>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="registro.html" class="btn-register">Registrarse</a>
        </div>
  <div class="header-container">
    <span>Bienvenido, <?php echo $user_name; ?>!</span>
    <?php if ($user_logged_in): ?>
        <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
        <a href="login.html">Iniciar sesión</a>
    <?php endif; ?>
</div>


        <div class="cart" onclick="mostrarCarrito()">
            <i class="fas fa-shopping-cart"></i>
            <span>0</span>
        </div>
    </header>

    <div class="main-content">
        <section id="inicio" class="hero">
            <h2>Bienvenidos a La Texicana</h2>
            <p>Disfruta de los mejores platillos en un ambiente único.</p>
            <div class="mission-vision">
                <h3>Nuestra Misión</h3>
                <p>Ofrecer una experiencia culinaria excepcional con ingredientes frescos y de alta calidad.</p>
                <h3>Nuestra Visión</h3>
                <p>Ser el restaurante preferido de la ciudad, reconocido por nuestro servicio y sabor.</p>
            </div>
            
        </section>

        <section id="acerca-de" class="about-us">
            <h2>Acerca de Nosotros</h2>
            <p>Somos un restaurante en proceso de crecimiento con mucha capacidad y sabores exquisitos en nuestros platillos</p>
            <h3>Nuestros Valores</h3>
            <ul>
                <li>Calidad en cada plato.</li>
                <li>Atención al cliente excepcional.</li>
                <li>Sostenibilidad y responsabilidad ambiental.</li>
            </ul>
        </section>
        <section id="menu" class="menu">
            <h2>Nuestro Menú</h2>
            <div class="menu-container">
            <div class="menu-item">
    <img src="fotos/tacos.jpg" alt="Tacos al Pastor">
    <h3>Tacos al Pastor</h3>
    <p>$50.00</p>
    <?php if ($user_logged_in): ?>
        <button onclick="agregarAlCarrito('Tacos al Pastor', 50)">Agregar al carrito</button>
    <?php else: ?>
        <button onclick="Swal.fire({icon: 'error', title: 'Inicia sesión', text: 'Debes iniciar sesión para agregar productos al carrito.'})">Agregar al carrito</button>
    <?php endif; ?>
</div>

<div class="menu-item">
    <img src="fotos/burritos.jpg" alt="Burritos">
    <h3>Burritos</h3>
    <p>$70.00</p>
    <?php if ($user_logged_in): ?>
        <button onclick="agregarAlCarrito('Burritos', 70)">Agregar al carrito</button>
    <?php else: ?>
        <button onclick="Swal.fire({icon: 'error', title: 'Inicia sesión', text: 'Debes iniciar sesión para agregar productos al carrito.'})">Agregar al carrito</button>
    <?php endif; ?>
</div>
             
            </div>
        </section>
        
        <section id="galeria" class="gallery">
            <h2>Galería</h2>
            <div class="gallery-images">
                <img src="fotos/images (7).jpg" alt="Platillo 1">
                <img src="fotos/images (7).jpg" alt="Platillo 2">
                <img src="fotos/images (7).jpg" alt="Platillo 3">

            </div>
        </section>

        <section id="contacto" class="contact-form">
            <h2>Contáctanos</h2>
            <form id="contactForm" action="guardar_contacto.php" method="POST">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" placeholder="Tu nombre" required pattern="[A-Za-z\s]+" title="El nombre no debe contener números" />
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com" required />
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="number" id="phone" name="phone" placeholder="+52 123 456 7890" required pattern="^\+?\d{1,4}?[\s\-]?\(?\d{1,3}?\)?[\s\-]?\d{3}[\s\-]?\d{4}$" title="Introduce un teléfono válido" />
                </div>
                <div class="form-group">
                    <label for="message">Mensaje:</label>
                    <textarea id="message" name="message" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                <button type="submit">Enviar mensaje</button>
                <p id="mensaje-enviado" style="color: green; display: none;"></p>
                <div id="form-message" style="display: none;"></div>
            </form>
            
        </section>

        <section class="location">
            <h2>Ubicación</h2>
            <p>Visítanos en nuestra dirección: Rio escondido 113 colonia suterm</p>
            <iframe title="mapa"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.470557100981!2d-100.55062412528888!3d28.705480180765655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x865f8beba08405b9%3A0x8e0cdd500ff5b947!2sR%C3%ADo%20Escondido%20113%2C%20Seccion%201%2C%2026069%20Piedras%20Negras%2C%20Coah.!5e0!3m2!1ses-419!2smx!4v1738800642819!5m2!1ses-419!2smx"  
                width="100%"
                height="300"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
            </iframe>
        </section>
    </div>

    <footer>
        <p>&copy; 2025 La Texicana. Todos los derechos reservados.</p>
        <p>Dirección: Rio escondido 113 colonia suterm Piedras Negras Coahuila</p>
        <p>Teléfono: 877 109 5945</p>
    </footer>
    <script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();  // Evita la recarga de la página

    // Validación de Nombre: No debe contener números
    const name = document.getElementById('name').value;
    if (!/^[A-Za-z\s]+$/.test(name)) {
        Swal.fire({
            icon: 'error',
            title: 'Nombre inválido',
            text: 'El nombre no debe contener números.',
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    // Validación de Teléfono: Solo números y longitud correcta (10 dígitos)
    const phone = document.getElementById('phone').value;
    if (!/^\+?\d{1,4}?[\s\-]?\(?\d{1,3}?\)?[\s\-]?\d{3}[\s\-]?\d{4}$/.test(phone)) {
        Swal.fire({
            icon: 'error',
            title: 'Teléfono inválido',
            text: 'Introduce un número de teléfono válido.',
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    // Validación de Correo Electrónico: Debe tener formato correcto
    const email = document.getElementById('email').value;
    if (!/\S+@\S+\.\S+/.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Correo inválido',
            text: 'Introduce un correo electrónico válido.',
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    // Enviar el formulario con fetch() de manera asíncrona
    fetch(this.action, {
        method: this.method,  // Utiliza el método especificado en el formulario (POST, por ejemplo)
        body: new FormData(this)  // Usa FormData para enviar los datos del formulario
    })
    .then(response => response.text())  // Convierte la respuesta en texto
    .then(data => {
        console.log("Respuesta recibida:", data);

        // Muestra el mensaje de éxito con SweetAlert
        Swal.fire({
            icon: 'success',
            title: '¡Mensaje Enviado!',
            text: 'Tu mensaje ha sido enviado correctamente. Te responderemos pronto.',
            showConfirmButton: false,
            timer: 2000
        });

        // Limpia los campos del formulario
        this.reset();  // Resetea el formulario a su estado inicial
    })
    .catch(error => {
        console.error("Error al enviar el mensaje:", error);

        // Muestra el mensaje de error con SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al enviar el mensaje. Intenta nuevamente.',
            showConfirmButton: false,
            timer: 2000
        });
    });
});
    </script>
    
<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'es',
        includedLanguages: 'en,es',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </body>
    </html>
    