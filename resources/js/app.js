import './bootstrap';
import '@hotwired/turbo';
import gsap from 'gsap';
import Swal from 'sweetalert2';

// Alpine JS ya viene con Breeze, pero acá escribimos nuestra lógica de UI
document.addEventListener('DOMContentLoaded', () => {
    // La inicialización 3D ha sido removida en favor del video background
});

// Checkout Flow
window.openCheckout = function(id, title, price) {
    Swal.fire({
        title: `Reservar: ${title}`,
        html: `
            <div class="text-left">
                <p class="mb-4 text-gray-300">Precio: S/ ${price}</p>
                <label class="block text-sm font-medium mb-1">Fecha del Tour</label>
                <input type="date" id="tour-date" class="w-full rounded-md bg-gray-800 border-gray-700 text-white mb-4 px-3 py-2">
                <label class="block text-sm font-medium mb-1">Nombre Completo</label>
                <input type="text" id="tour-name" class="w-full rounded-md bg-gray-800 border-gray-700 text-white mb-4 px-3 py-2" placeholder="Ej. Juan Pérez">
            </div>
        `,
        background: '#111',
        color: '#fff',
        showCancelButton: true,
        confirmButtonText: 'Confirmar Reserva',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#6366f1', // indigo-500
        preConfirm: () => {
            const date = document.getElementById('tour-date').value;
            const name = document.getElementById('tour-name').value;
            if (!date || !name) {
                Swal.showValidationMessage('Por favor completa todos los campos');
            }
            return { date, name };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Simulamos el guardado y pago
            Swal.fire({
                title: '¡Reserva Confirmada!',
                text: `Gracias ${result.value.name}, te esperamos el ${result.value.date}.`,
                icon: 'success',
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
        }
    });
};

// Asegurar que el video de fondo se reproduzca al regresar a la página principal con Turbo
document.addEventListener('turbo:load', () => {
    const video = document.getElementById('hero-video');
    if (video) {
        video.play().catch(e => console.error("Error reproduciendo video:", e));
    }
});
