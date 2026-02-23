console.log("✅ JavaScript cargado correctamente.");

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

// Preview de la imagen subida
document.getElementById('fileUpload').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const removeBtn = document.getElementById('removeImageBtn');
    const dicomIcon = document.querySelector('.dicom-icon');

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            dicomIcon.style.display = 'none';
            fileName.textContent = file.name;
            removeBtn.style.display = 'inline-flex';
        }

        reader.readAsDataURL(file);
    }
});

// Eliminar imagen
document.getElementById('removeImageBtn').addEventListener('click', function () {
    const preview = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const fileInput = document.getElementById('fileUpload');
    const dicomIcon = document.querySelector('.dicom-icon');
    const removeBtn = document.getElementById('removeImageBtn');

    preview.style.display = 'none';
    dicomIcon.style.display = 'block';
    fileName.textContent = '';
    fileInput.value = '';
    removeBtn.style.display = 'none';
});

// Efecto de carga para la tarjeta de vista previa
document.addEventListener('DOMContentLoaded', function () {
    const patientForm = document.querySelector('.patient-form');

    // Simular animación de carga
    setTimeout(() => {
        patientForm.style.transform = 'translateY(0)';
        patientForm.style.opacity = '1';
    }, 300);
});
function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}

const inputId = document.getElementById('id');
const inputNombres = document.getElementById('nombres');
const inputApellidos = document.getElementById('apellidos');
const inputDireccion = document.getElementById('direccion');
const inputFechaNacimiento = document.getElementById('fecha_nacimiento');
const inputEmail = document.getElementById('email');
const inputCelular = document.getElementById('celular');
const inputSexo = document.getElementById('sexo');
const inputEdad = document.getElementById('edad');
inputFechaNacimiento.addEventListener('change', function () {
    if(inputFechaNacimiento.value){
        inputEdad.value = calcularEdad(inputFechaNacimiento.value);
    }
});

inputId.addEventListener('input', function () {
    const id = this.value;

    if (pacientes[id]) {
        inputNombres.value = pacientes[id].nombres;
        inputApellidos.value = pacientes[id].apellidos;
        inputDireccion.value = pacientes[id].direccion;
        inputFechaNacimiento.value = pacientes[id].fecha_nacimiento;
        inputEmail.value = pacientes[id].email;
        inputCelular.value = pacientes[id].celular;
        inputEdad.value = calcularEdad(pacientes[id].fecha_nacimiento);

        let sexoBD = pacientes[id].sexo;
        let sexoForm = '';
        if (sexoBD === 'F') sexoForm = 'Femenino';
        else if (sexoBD === 'M') sexoForm = 'Masculino';
        else if (sexoBD === 'O') sexoForm = 'Otro';
        inputSexo.value = sexoForm;

        // Deshabilitar edición
        inputNombres.readOnly = true;
        inputApellidos.readOnly = true;
        inputDireccion.readOnly = true;
        inputFechaNacimiento.readOnly = true;
        inputEmail.readOnly = true;
        inputCelular.readOnly = true;
        inputEdad.readOnly = true;
        inputSexo.disabled = true;

    } else {
        // Limpiar campos
        inputNombres.value = '';
        inputApellidos.value = '';
        inputDireccion.value = '';
        inputFechaNacimiento.value = '';
        inputEmail.value = '';
        inputCelular.value = '';
        inputEdad.value = '';
        inputSexo.value = '';

        // Habilitar edición
        inputNombres.readOnly = false;
        inputApellidos.readOnly = false;
        inputDireccion.readOnly = false;
        inputFechaNacimiento.readOnly = false;
        inputEmail.readOnly = false;
        inputCelular.readOnly = false;
        inputEdad.readOnly = false;
        inputSexo.disabled = false;
    }
});


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


function confirmDelete(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este paciente?")) {
        fetch('eliminar_paciente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'ok') {
                 window.location.href = `consultar.php?ms=✅El paciente se eliminó correctamente&type=ok`;
            } else {
                window.location.href = `consultar.php?ms=❌Error al eliminar el paciente&type=error`;
            }
        })
        .catch(error => {
            console.error("Error de red:", error);
            window.location.href = `consultar.php?ms=❌No se pudo encontrar el servidor&type=error`;
        });;
    }
}
