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
                Registrar Mobiliarios
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <!-- Nombre -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input 
                                type="text" 
                                class="form-control form-control-sm" 
                                id="nombre" 
                                name="nombre" 
                                placeholder="Nombre" 
                                required 
                                oninput="updateCodigo()"
                            >
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input 
                                type="text" 
                                class="form-control form-control-sm" 
                                id="descripcion" 
                                name="descripcion" 
                                placeholder="Descripción" 
                                required
                            >
                        </div>
                    </div>
                    <!-- Cantidad -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input 
                                type="number" 
                                class="form-control form-control-sm" 
                                id="cantidad" 
                                name="cantidad" 
                                placeholder="Cantidad" 
                                required
                            >
                        </div>
                    </div>
                    <!-- Laboratorio -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="laboratorio_id">Laboratorio</label>
                            <select 
                                name="laboratorio_id" 
                                id="laboratorio_id" 
                                class="form-control form-control-sm" 
                                required 
                                onchange="updateCodigo()"
                            >
                                <option value="">Selecciona un laboratorio</option>
                                @foreach($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Código de Barras -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="codigo">Código de Barras</label>
                            <input 
                                type="text" 
                                class="form-control form-control-sm" 
                                id="codigo" 
                                name="codigo" 
                                placeholder="Código de barras" 
                                autocomplete="off" 
                                required 
                                readonly
                            >
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
            // Obtener el valor del nombre
            const nombre = document.getElementById('nombre').value.trim();
            // Obtener el nombre del laboratorio seleccionado
            const laboratorioSelect = document.getElementById('laboratorio_id');
            const laboratorioNombre = laboratorioSelect.options[laboratorioSelect.selectedIndex]?.text.trim() || "";

            // Verificar que ambos valores estén disponibles
            if (nombre && laboratorioNombre) {
                // Generar el código de barras combinando el nombre y el laboratorio
                const codigo = `${nombre}-${laboratorioNombre}`;
                // Asignar el código generado al campo de código de barras
                document.getElementById('codigo').value = codigo;
            } else {
                // Limpiar el campo de código si falta algún dato
                document.getElementById('codigo').value = "";
            }
        }
    </script>

    
    <!-- tabla de mobiliarios -->
    <div class="card card-indigo card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i> Tabla de mobiliario
            </h3>
            <div class="d-flex justify-content-end">
            {{-- <a href="{{ route('admin.mobiliario.pdf') }}" class="btn btn-success mx-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Generar Reporte
            </a> --}}
           <!-- Botón que abre el modal para mobiliarios (cambiado a btn-info) -->
            <button type="button" class="btn btn-info mx-3" data-toggle="modal" data-target="#modal-mobiliarios">
                Reporte Mobiliarios
            </button>

            <!-- Modal para seleccionar laboratorios (Mobiliarios) -->
            <div class="modal fade" id="modal-mobiliarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Seleccionar Laboratorios</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.reporte.mobiliarios') }}" method="POST" target="_blank">
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
            <table id="mobiliario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Laboratorio</th>
                        <th>Codigo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mobiliarios as $mobiliario)
                        <tr>
                            <td>{{ $mobiliario->nombre }}</td>  
                            <td>{{ $mobiliario->descripcion }}</td>
                            <td>{{ $mobiliario->cantidad }}</td>
                            <td>{{ $mobiliario->laboratorio->nombre ?? 'No asignado' }}</td>
                            <td>{{ $mobiliario->codigo  }}
                                <img src="{{ asset('barcodes/' . $mobiliario->codigo . '.png') }}" alt="Código de Barras" style="width: 100px; height: auto;">
                                <br>
                                <a href="{{ asset('barcodes/' . $mobiliario->codigo . '.png') }}" download class="btn btn-outline-success btn-sm mt-1">
                                    Descargar
                                </a>
                            </td>
                            <td width="10px">
                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $mobiliario->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.mobiliario.destroy', $mobiliario->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal{{ $mobiliario->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $mobiliario->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ $mobiliario->id }}Label">Editar mobiliario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.mobiliario.update', $mobiliario->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Campos del formulario de edición -->
                                            <div class="form-group">
                                                <label for="nombre{{ $mobiliario->id }}">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre{{ $mobiliario->id }}" value="{{ $mobiliario->nombre }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion{{ $mobiliario->id }}">Descripción</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion{{ $mobiliario->id }}" value="{{ $mobiliario->descripcion }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="cantidad{{ $mobiliario->id }}">Cantidad</label>
                                                <input type="text" class="form-control" name="cantidad" id="cantidad{{ $mobiliario->id }}" value="{{ $mobiliario->cantidad }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="laboratorio_id{{ $mobiliario->id }}">Laboratorio</label>
                                                <select name="laboratorio_id" id="laboratorio_id{{ $mobiliario->id }}" class="form-control">
                                                    <option value="">Selecciona un laboratorio</option>
                                                    @foreach($laboratorios as $laboratorio)
                                                        <option value="{{ $laboratorio->id }}" {{ $laboratorio->id == $mobiliario->laboratorio_id ? 'selected' : '' }}>{{ $laboratorio->nombre }}</option>
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
