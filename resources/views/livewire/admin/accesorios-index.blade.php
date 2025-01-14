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
                Registrar accesorios
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <!-- Nombre -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" placeholder="Nombre" required oninput="updateCodigo()">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control form-control-sm" name="descripcion" placeholder="Descripción" required>
                        </div>
                    </div>
                    <!-- Marca -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control form-control-sm" name="marca" placeholder="Marca" required>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <!-- Modelo -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control form-control-sm" name="modelo" placeholder="Modelo" required>
                        </div>
                    </div>
                    <!-- Número de Serie -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="numero_serie">Número de Serie</label>
                            <input type="text" class="form-control form-control-sm" name="numero_serie" id="numero_serie" placeholder="Número de serie" required oninput="updateCodigo()">
                        </div>
                    </div>
                    <!-- Laboratorio -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="laboratorio_id">Laboratorio</label>
                            <select name="laboratorio_id" id="laboratorio_id" class="form-control form-control-sm" required onchange="updateCodigo()">
                                <option value="">Selecciona un laboratorio</option>
                                @foreach($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="codigo">Código de Barras</label>
                            <input type="text" class="form-control form-control-sm" name="codigo" id="codigo" placeholder="Código de barras" autocomplete="off" required readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>    
    
    <script>
        function updateCodigo() {
            // Obtener el valor del número de serie
            const nombre = document.getElementById('nombre').value;
            // Obtener el valor del laboratorio seleccionado
            const laboratorioSelect = document.getElementById('laboratorio_id');
            const laboratorioNombre = laboratorioSelect.options[laboratorioSelect.selectedIndex].text;
    
     // Crear el código de barras combinando el número de serie y el nombre del laboratorio
            const codigo = `${nombre}-${laboratorioNombre}`;
        
            // Asignar el código generado al campo de código de barras
            document.getElementById('codigo').value = codigo;
        }
    </script>
    
    <!-- tabla de accesorios -->
    <div class="card card-indigo card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i> Tabla de accesorio
            </h3>
            <div class="d-flex justify-content-end">
            {{-- <a href="{{ route('admin.accesorio.pdf') }}" class="btn btn-success mx-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Generar Reporte
            </a> --}}
              <!-- Botón que abre el modal para accesorios (cambiado a btn-info) -->
            <button type="button" class="btn btn-info mx-3" data-toggle="modal" data-target="#modal-accesorios">
                Reporte Accesorios
            </button>

            <!-- Modal para seleccionar laboratorios (Accesorios) -->
            <div class="modal fade" id="modal-accesorios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Seleccionar Laboratorios</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.reporte.accesorios') }}" method="POST" target="_blank">
                            @csrf
                            <div class="modal-body">
                                <!-- Selección de Laboratorios -->
                                <label for="laboratorios">Laboratorios:</label>
                                <div class="form-group">
                                    @foreach ($laboratorios as $laboratorio)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lab{{ $laboratorio->id }}" name="laboratorios[]" value="{{ $laboratorio->id }}">
                                            <label class="form-check-label" for="lab{{ $laboratorio->id }}">
                                                {{ $laboratorio->nombre }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Generar Reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            

           </div>
        </div>
        <div class="card-body">
            <table id="accesorio" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de Serie</th>
                        <th>Laboratorio</th>
                        <th>Codigo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accesorios as $accesorio)
                        <tr>
                            <td>{{ $accesorio->nombre }}</td>  
                            <td>{{ $accesorio->descripcion }}</td>
                            <td>{{ $accesorio->marca }}</td>
                            <td>{{ $accesorio->modelo }}</td>
                            <td>{{ $accesorio->numero_serie }}</td>
                            <td>{{ $accesorio->laboratorio->nombre ?? 'No asignado' }}</td>
                            <td>{{ $accesorio->codigo  }}
                                <img src="{{ asset('barcodes/' . $accesorio->codigo . '.png') }}" alt="Código de Barras" style="width: 100px; height: auto;">
                                <br>
                                <a href="{{ asset('barcodes/' . $accesorio->codigo . '.png') }}" download class="btn btn-outline-success btn-sm mt-1">
                                    Descargar
                                </a>
                            </td>
                            <td width="10px">
                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $accesorio->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.accesorio.destroy', $accesorio->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal{{ $accesorio->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $accesorio->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ $accesorio->id }}Label">Editar accesorio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.accesorio.update', $accesorio->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Campos del formulario de edición -->
                                            <div class="form-group">
                                                <label for="nombre{{ $accesorio->id }}">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre{{ $accesorio->id }}" value="{{ $accesorio->nombre }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion{{ $accesorio->id }}">Descripción</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion{{ $accesorio->id }}" value="{{ $accesorio->descripcion }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="marca{{ $accesorio->id }}">Marca</label>
                                                <input type="text" class="form-control" name="marca" id="marca{{ $accesorio->id }}" value="{{ $accesorio->marca }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="modelo{{ $accesorio->id }}">Modelo</label>
                                                <input type="text" class="form-control" name="modelo" id="modelo{{ $accesorio->id }}" value="{{ $accesorio->modelo }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="numero_serie{{ $accesorio->id }}">Número de Serie</label>
                                                <input type="text" class="form-control" name="numero_serie" id="numero_serie{{ $accesorio->id }}" value="{{ $accesorio->numero_serie }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="laboratorio_id{{ $accesorio->id }}">Laboratorio</label>
                                                <select name="laboratorio_id" id="laboratorio_id{{ $accesorio->id }}" class="form-control">
                                                    <option value="">Selecciona un laboratorio</option>
                                                    @foreach($laboratorios as $laboratorio)
                                                        <option value="{{ $laboratorio->id }}" {{ $laboratorio->id == $accesorio->laboratorio_id ? 'selected' : '' }}>{{ $laboratorio->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Enviar el formulario si el usuario confirma
                    }
                });
            });
        });
    </script>
</div>
