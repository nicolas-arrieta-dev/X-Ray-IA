// Función para cerrar el menú
function closeMenu() {
    document.querySelector('.sidebar-nav').classList.remove('active');
    document.querySelector('.hamburger-btn').classList.remove('active');
}

// Menú hamburguesa
document.querySelector('.hamburger-btn').addEventListener('click', function() {
    document.querySelector('.sidebar-nav').classList.toggle('active');
    this.classList.toggle('active');
});

// Cerrar menú al hacer clic en enlaces (móviles)
document.querySelectorAll('.sidebar-nav a').forEach(item => {
    item.addEventListener('click', closeMenu);
});

// Cerrar menú automáticamente al redimensionar
window.addEventListener('resize', function() {
    // Cierra el menú solo si está abierto y el ancho supera 900px
    const isMenuOpen = document.querySelector('.hamburger-btn').classList.contains('active');
    if (window.innerWidth > 900 && isMenuOpen) {
        closeMenu();
    }
});

// Verificar estado inicial al cargar
if (window.innerWidth > 900) {
    closeMenu();
}
    
// Filtrar registros por columna
    document.getElementById("query").addEventListener("input", function () {
        const filterText = this.value.trim().toLowerCase();
        const columnIndex = parseInt(document.getElementById("filterColumn").value);
        const tableRows = document.querySelectorAll(".responsive-table tbody tr");

        tableRows.forEach(function (row) {
            const cell = row.cells[columnIndex];
            if (cell) {
                const cellText = cell.textContent.toLowerCase();
                row.style.display = (cellText.includes(filterText)) ? "" : "none";
            }
        });
    });
    console.log("Filtro de registros activado.");


    // Efecto de carga para la tarjeta de vista previa
    document.addEventListener('DOMContentLoaded', function () {
        const previewCard = document.querySelector('.preview-card');
        const tableSection = document.querySelector('.table-section');

        // Simular animación de carga
        setTimeout(() => {
            previewCard.style.transform = 'translateY(0)';
            previewCard.style.opacity = '1';
            tableSection.style.transform = 'translateY(0)';
            tableSection.style.opacity = '1';
        }, 300);
    });

document.addEventListener("DOMContentLoaded", () => {
  const checkboxes = document.querySelectorAll(".fila-check");
  const previewImage = document.getElementById("previewImage");
  const previewPlaceholder = document.querySelector(".preview-placeholder");

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener("change", () => {
      const fila = checkbox.closest("tr");
      const archivoCell = fila.querySelector(".archivo-radiografia");
      const archivo = archivoCell ? archivoCell.textContent : null;

      // Solo mostrar la imagen si el checkbox está marcado
      if (checkbox.checked && archivo) {
        // Desmarcar todas las filas
        checkboxes.forEach(cb => {
          cb.checked = false;
          cb.closest("tr").classList.remove("fila-seleccionada");
        });

        // Marcar la fila seleccionada y mostrar la imagen
        checkbox.checked = true;  // Asegurarse de que este checkbox esté marcado
        fila.classList.add("fila-seleccionada");
        previewImage.src = `../assets/upload/${archivo}`;
        previewImage.style.display = "block";
        previewPlaceholder.style.display = "none";
      } else {
        // Si el checkbox no está marcado, ocultar la imagen
        fila.classList.remove("fila-seleccionada");
        previewImage.style.display = "none";
        previewPlaceholder.style.display = "flex";
      }
    });
  });
});

function confirmDelete(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta Radiografia?")) {
        fetch('eliminar_radiografia.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'ok') {
                 window.location.href = `consultar.php?ms=✅La radiografía se eliminó correctamente&type=ok`;
            } else {
                window.location.href = `consultar.php?ms=❌Error al eliminar la radiografía&type=error`;
            }
        })
        .catch(error => {
            console.error("Error de red:", error);
            window.location.href = `consultar.php?ms=❌No se pudo encontrar el servidor&type=error`;
        });;
    }
}


const params = new URLSearchParams(window.location.search);
const message = params.get('ms');
const type = params.get('type');

if (message && type) {
    const notification = document.getElementById('notification');
    const messageSpan = document.getElementById('notification-message');

    // Set message
    messageSpan.textContent = message;

    // Set background color
    if (type === 'ok') {
        notification.style.backgroundColor = '#23c483'; // verde
    } else if (type === 'error') {
        notification.style.backgroundColor = '#e74c3c'; // rojo
    }

    // Mostrar
    notification.style.display = 'block';

    // Ocultar automáticamente luego de 4 segundos
    setTimeout(() => {
        notification.style.display = 'none';
    }, 4000);
}

function closeNotification() {
    document.getElementById('notification').style.display = 'none';
}
