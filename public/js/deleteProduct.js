document.addEventListener('DOMContentLoaded', () => {
    const modalEliminar = document.getElementById('modalEliminar');
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');

    let productIdToDelete = null;

    // Captura el evento para mostrar el modal
    modalEliminar.addEventListener('show.bs.modal', (event) => {
        // Botón que activó el modal
        const button = event.relatedTarget;

        // Obtener el ID del producto del botón
        productIdToDelete = button.getAttribute('data-id');

        // Asignar el ID al campo oculto (por si es necesario usarlo después)
        document.getElementById('deleteProductId').value = productIdToDelete;
    });


confirmDeleteButton.addEventListener('click', async () => {
    if (!productIdToDelete) {
        alert('Error: No se encontró el ID del producto.');
        return;
    }

    try {
        const response = await fetch(`http://localhost:8000/api/products/${productIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: '¡Producto eliminado!',
                text: 'Los cambios se realizaron correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminar'));
                modal.hide();

                // Actualizar la lista de productos (opcionalmente recargar la página)
                location.reload();
            });
        } else {
            const result = await response.json();
            alert(`Error: ${result.message || 'No se pudo eliminar el producto.'}`);
        }
    } catch (error) {
        console.error('Error al eliminar el producto:', error);
        alert('Ocurrió un error al intentar eliminar el producto.');
    }
});

});
