document.addEventListener('DOMContentLoaded', () => {
    const modalEditar = document.getElementById('modalEditar');
    const editForm = document.getElementById('editForm');

    modalEditar.addEventListener('show.bs.modal', (event) => {
        // Botón que activó el modal
        const button = event.relatedTarget;

        // Obtener datos del producto del botón
        const productId = button.getAttribute('data-id');
        const productName = button.getAttribute('data-name');
        const productDescripcion = button.getAttribute('data-descripcion');
        const productValor = button.getAttribute('data-valor');

        // Rellenar los campos del formulario
        document.getElementById('editProductId').value = productId;
        document.getElementById('editName').value = productName;
        document.getElementById('editDescripcion').value = productDescripcion;
        document.getElementById('editValor').value = productValor;
    });
});



document.getElementById('editForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    // Obtener los datos del formulario
    const productId = document.getElementById('editProductId').value; // ID del producto
    console.log(productId);
    const formData = {
        name: document.getElementById('editName').value,
        descripcion: document.getElementById('editDescripcion').value,
        valor: document.getElementById('editValor').value
    };

    // Enviar la solicitud AJAX con Fetch
    try {
        const response = await fetch(`http://localhost:8000/api/products/${productId}`, {
            method: 'PUT', // Asegúrate de usar el método PUT
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (response.ok) {
            // Mostrar mensaje de éxito con SweetAlert2
            Swal.fire({
                icon: 'success',
                title: '¡Producto actualizado!',
                text: 'Los cambios se han guardado correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                modal.hide();

                // Actualizar la lista de productos (opcionalmente recargar la página)
                location.reload();
            });
        } else {
            // Mostrar errores de validación
            const errors = result.errors || {};
            let errorMessages = '<div class="alert alert-danger">Error al actualizar el producto:<ul>';
            for (let field in errors) {
                errorMessages += `<li>${errors[field].join(', ')}</li>`;
            }
            errorMessages += '</ul></div>';
            document.getElementById('messages').innerHTML = errorMessages;
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud.'
        });
    }
});
