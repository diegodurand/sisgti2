<div class="mt-3">
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            })
        </script>
    @endif
    <!-- formulario -->
    <div class="card card-indigo">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Registrar Laboratorios
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <!-- Nombre -->
                    <div class="col-md-6 offset-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control form-control-sm" name="nombre" 
                                placeholder="Nombre del laboratorio" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save mr-1"></i>
                      Registrar
                    </button>
                  </div>
            </form>
        </div>
    </div>    
    {{-- tabla de cursos --}}
    <div class="card card-indigo card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de laboratorio
            </h3>
        </div>
        <div class="card-body">
            <table id="laboratorio" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laboratorios as $laboratorio)
                        <tr>
                            <td>{{ $laboratorio->nombre }}</td>    
                            <td width="10px">
                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $laboratorio->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.laboratorio.destroy', $laboratorio->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal{{ $laboratorio->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $laboratorio->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ $laboratorio->id }}Label">Editar laboratorio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.laboratorio.update', $laboratorio->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Campos del formulario de edición -->
                                            <div class="form-group">
                                                <label for="nombre{{ $laboratorio->id }}">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre{{ $laboratorio->id }}" value="{{ $laboratorio->nombre }}">
                                            </div>
                                            <!-- Otros campos del formulario -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    

    <script>
        // Manejar la confirmación de eliminación
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el envío automático del formulario

                const form = this; // Referencia al formulario actual

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¡No podrás revertir esto!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, elimínalo!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario si se confirma
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Cancelado',
                            'Tu archivo imaginario está a salvo :)',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
</div>
