<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
<div class="container mt-5">
        <h4 class="mb-4 text-center">Lista de Productos</h4>
        <a href="" data-bs-toggle="modal" data-bs-target="#modalAgregar" class="mb-4 btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><small>Alta de producto</small></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="messages" class="mb-3"></div>
                        <form id="productForm">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label"><small>Nombre</small></label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label"><small>Descripcion</small></label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label"><small>Valor</small></label>
                                <input type="text" class="form-control" id="valor" name="valor">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Agregar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-sm text-center table-light">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><small>Id</small></th>
                    <th scope="col"><small>Nombre</small></th>
                    <th scope="col"><small>Descripción</small></th>
                    <th scope="col"><small>Valor</small></th>
                    <th scope="col"><small>Acciones</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><small>{{ $product->name }}</small></td>
                        <td><small>{{ $product->descripcion }}</small></td>
                        <td><small>${{ $product->valor }}</small></td>
                        <td>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar" class="btn btn-secondary btn-sm" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-descripcion="{{ $product->descripcion }}" data-valor="{{ $product->valor }}"><i class="fas fa-edit"></i></a>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEliminar" class="btn btn-secondary btn-sm" data-id="{{ $product->id }}"><i class="fas fa-trash"></i></a>
                        </td>
                       
                        <!-- Modal -->
                        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><small>Modificacion de producto</small></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label"><small>Id</small></label>
                                            <input type="text" class="form-control" id="editProductId" name="id" value="{{ $product->id }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label"><small>Nombre</small></label>
                                            <input type="text" class="form-control" id="editName" name="name" value="{{ $product->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label"><small>Descripcion</small></label>
                                            <input type="text" class="form-control" id="editDescripcion" name="descripcion" value="{{ $product->descripcion }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label"><small>Valor</small></label>
                                            <input type="text" class="form-control" id="editValor" name="valor" value="{{ $product->valor }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Editar Producto</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal para Eliminar -->

                        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar este producto?</p>
                                        <input type="hidden" id="deleteProductId">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/js/registProduct.js"></script>
<script src="/js/editProduct.js"></script>
<script src="/js/deleteProduct.js" defer></script>



</html>