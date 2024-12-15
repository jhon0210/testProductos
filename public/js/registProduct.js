const formulario = document.getElementById('productForm');
formulario.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Obtener los datos del formulario
    const formData = {
        name: document.getElementById('name').value,
        descripcion: document.getElementById('descripcion').value,
        valor: document.getElementById('valor').value
    };

    try {
        const response = await fetch('http://localhost:8000/api/products/crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para proteger la solicitud
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        // Manejo de respuestas
        const messageDiv = document.getElementById('messages');
        if (response.ok) {
            // Mostrar mensaje de éxito con SweetAlert2
            Swal.fire({
                icon: 'success',
                title: '¡Producto creado!',
                text: 'El producto se ha registrado exitosamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Cerrar el modal de agregar producto
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
                modal.hide();

                // Limpiar el formulario
                document.getElementById('productForm').reset();
                location.reload();
            });
        } else {
            // Mostrar errores de validación
            const errors = result.errors || {};
            let errorMessages = '<div class="alert alert-danger">Error al crear el producto:<ul>';
            for (let field in errors) {
                errorMessages += `<li>${errors[field].join(', ')}</li>`;
            }
            errorMessages += '</ul></div>';
            messageDiv.innerHTML = errorMessages;
        }


    } catch (error) {
        // Manejar errores generales
        console.error('Error:', error);
        document.getElementById('messages').innerHTML = `<div class="alert alert-danger">Ocurrió un error al procesar la solicitud.</div>`;
    }
});