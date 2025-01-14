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

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    <div class="card card-indigo">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Registrar PC
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.equipoinformatico.store') }}">
                @csrf
                <div class="row">
                    <!-- Marca -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="marca">N° PC</label>
                            <input type="text" class="form-control form-control-sm" name="marca" id="marca" placeholder="N° PC" autocomplete="off" required oninput="updateCodigo()">
                        </div>
                    </div>
                    <!-- Modelo -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control form-control-sm" name="modelo" placeholder="Modelo" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- Primer Bloque de Código -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control form-control-sm" onchange="toggleValor()">
                                <option value="Disponible">Disponible</option>
                                <option value="En uso">En uso</option>
                                <option value="En mantenimiento">En mantenimiento</option>
                            </select>
                        </div>
                    </div>
    
                    <!-- Urgencia (valor) -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="valor">Urgencia</label>
                            <select name="valor" id="valor" class="form-control form-control-sm" disabled onchange="syncHiddenValor()">
                                <option value="NO ASIGNADO">NO ASIGNADO</option>
                                <option value="Critico">Crítico</option>
                                <option value="Normal">Normal</option>
                                <option value="Baja">Baja</option>
                            </select>
                            <input type="hidden" name="valor" id="valor-hidden" value="NO ASIGNADO">
                        </div>
                    </div>
    
                    <!-- Laboratorio -->
                    <div class="col-md-3">
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
                    <!-- Botón de registro -->
                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Registrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function updateCodigo() {
            // Obtener el valor del número de PC
            const numeroPC = document.getElementById('marca').value;
            // Obtener el valor del laboratorio seleccionado
            const laboratorioSelect = document.getElementById('laboratorio_id');
            const laboratorioNombre = laboratorioSelect.options[laboratorioSelect.selectedIndex].text;
    
            // Crear el código de barras combinando el número de PC y el nombre del laboratorio
            const codigo = `${numeroPC}-${laboratorioNombre}`;
    
            // Asignar el código generado al campo de código de barras
            document.getElementById('codigo').value = codigo;
        }
    </script>
    {{-- Tabla de Equipos Informáticos --}}
    <div class="card card-indigo card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de E.informaticos
            </h3>

            <div class="d-flex justify-content-end">
                {{-- <!-- Botón para generar reporte general de PCs -->
                <a href="{{ route('admin.equipoinformatico.pdfequipos') }}" class="btn btn-success mx-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Reporte G. PCs
                </a>
            
                <!-- Botón para generar reporte general de componentes -->
                <a href="{{ route('admin.equipoinformatico.pdf') }}" class="btn btn-danger mx-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Reporte C.
                </a>
             --}}
<!-- Botón que abre el modal para equipos informáticos -->
<button type="button" class="btn btn-info mx-3" data-toggle="modal" data-target="#modal-laboratorios">
    Reporte Equipos Informáticos
</button>

<!-- Modal para equipos informáticos -->
<div class="modal fade" id="modal-laboratorios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccionar Laboratorios y Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-laboratorios-equipos" action="{{ route('admin.reporte.equipos') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <!-- Selección de Laboratorios -->
                    <label for="laboratorios">Laboratorios:</label>
                    <div class="form-group">
                        <!-- Opción para seleccionar TODOS -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="labTodosEquipos">
                            <label class="form-check-label" for="labTodosEquipos">
                                TODOS
                            </label>
                        </div>
                        <!-- Lista de Laboratorios -->
                        @foreach ($laboratorios as $laboratorio)
                            <div class="form-check">
                                <input class="form-check-input lab-checkbox-equipos" type="checkbox" id="labEquipos{{ $laboratorio->id }}" name="laboratorios[]" value="{{ $laboratorio->id }}">
                                <label class="form-check-label" for="labEquipos{{ $laboratorio->id }}">
                                    {{ $laboratorio->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <!-- Selección de Estado -->
                    <label for="estado">Estado:</label>
                    <div class="form-group">
                        <select class="form-control" id="estado" name="estado">
                            <option value="">Seleccione un estado</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En uso">En uso</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                        </select>
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

<!-- Botón que abre el modal para accesorios -->
<button type="button" class="btn btn-warning mx-3" data-toggle="modal" data-target="#modal-accesorios">
    Reporte Equipos Informáticos (Accesorios)
</button>

<!-- Modal para accesorios -->
<div class="modal fade" id="modal-accesorios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccionar Laboratorios y Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-laboratorios-accesorios" action="{{ route('admin.reporte.equiposcomponentes') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <!-- Selección de Laboratorios -->
                    <label for="laboratorios">Laboratorios:</label>
                    <div class="form-group">
                        <!-- Opción para seleccionar TODOS -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="labTodosAccesorios">
                            <label class="form-check-label" for="labTodosAccesorios">
                                TODOS
                            </label>
                        </div>
                        <!-- Lista de Laboratorios -->
                        @foreach ($laboratorios as $laboratorio)
                            <div class="form-check">
                                <input class="form-check-input lab-checkbox-accesorios" type="checkbox" id="labAccesorios{{ $laboratorio->id }}" name="laboratorios[]" value="{{ $laboratorio->id }}">
                                <label class="form-check-label" for="labAccesorios{{ $laboratorio->id }}">
                                    {{ $laboratorio->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <!-- Selección de Estado -->
                    <label for="estado">Estado:</label>
                    <div class="form-group">
                        <select class="form-control" id="estado" name="estado">
                            <option value="">Seleccione un estado</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En uso">En uso</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                        </select>
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

<script>
    // Script para el modal de equipos informáticos
    document.getElementById('labTodosEquipos').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.lab-checkbox-equipos');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    document.getElementById('form-laboratorios-equipos').addEventListener('submit', function(event) {
        var checkboxes = document.querySelectorAll('.lab-checkbox-equipos');
        var isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        if (!isChecked) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un laboratorio antes de generar el reporte.');
        }
    });

    // Script para el modal de accesorios
    document.getElementById('labTodosAccesorios').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.lab-checkbox-accesorios');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    document.getElementById('form-laboratorios-accesorios').addEventListener('submit', function(event) {
        var checkboxes = document.querySelectorAll('.lab-checkbox-accesorios');
        var isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        if (!isChecked) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un laboratorio antes de generar el reporte.');
        }
    });
</script>

                
            
                    {{-- Modal de edición --}}
                    @foreach ($equipoinformatico as $equipoinformaticos)
                    <div class="modal fade" id="editModal{{ $equipoinformaticos->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $equipoinformaticos->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $equipoinformaticos->id }}Label">Editar Equipo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.equipoinformatico.update', $equipoinformaticos->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <!-- Campos del formulario de edición -->
                                        <div class="form-group">
                                            <label for="marca{{ $equipoinformaticos->id }}">Marca</label>
                                            <input type="text" class="form-control" name="marca" id="marca{{ $equipoinformaticos->id }}" value="{{ $equipoinformaticos->marca }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="modelo{{ $equipoinformaticos->id }}">Modelo</label>
                                            <input type="text" class="form-control" name="modelo" id="modelo{{ $equipoinformaticos->id }}" value="{{ $equipoinformaticos->modelo }}" required>
                                        </div>

                                        <!-- Estado -->
                                        <div class="form-group">
                                            <label for="estado{{ $equipoinformaticos->id }}">Estado</label>
                                            <select class="form-control" name="estado" id="estado{{ $equipoinformaticos->id }}" onchange="toggleValor({{ $equipoinformaticos->id }})">
                                                <option value="Disponible" {{ $equipoinformaticos->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="En uso" {{ $equipoinformaticos->estado == 'En uso' ? 'selected' : '' }}>En uso</option>
                                                <option value="En mantenimiento" {{ $equipoinformaticos->estado == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                            </select>
                                        </div>

                                        <!-- Urgencia -->
                                        <div class="form-group">
                                            <label for="valor{{ $equipoinformaticos->id }}">Urgencia</label>
                                            <select class="form-control" id="valor{{ $equipoinformaticos->id }}" name="valor" {{ $equipoinformaticos->estado == 'En mantenimiento' ? '' : 'disabled' }} onchange="syncHiddenValor({{ $equipoinformaticos->id }})">
                                                <option value="NO ASIGNADO" {{ $equipoinformaticos->valor == 'NO ASIGNADO' ? 'selected' : '' }}>NO ASIGNADO</option>
                                                <option value="Critico" {{ $equipoinformaticos->valor == 'Critico' ? 'selected' : '' }}>Crítico</option>
                                                <option value="Normal" {{ $equipoinformaticos->valor == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Baja" {{ $equipoinformaticos->valor == 'Baja' ? 'selected' : '' }}>Baja</option>
                                            </select>
                                            <input type="hidden" name="valor" id="valor-hidden{{ $equipoinformaticos->id }}" value="{{ $equipoinformaticos->valor }}">
                                        </div>

                                        <!-- Laboratorio -->
                                        <div class="form-group">
                                            <label for="laboratorio{{ $equipoinformaticos->id }}">Laboratorio</label>
                                            <select class="form-control" name="laboratorio_id" id="laboratorio{{ $equipoinformaticos->id }}">
                                                @foreach($laboratorios as $laboratorio)
                                                <option value="{{ $laboratorio->id }}" {{ $equipoinformaticos->laboratorio_id == $laboratorio->id ? 'selected' : '' }}>
                                                    {{ $laboratorio->nombre }}
                                                </option>
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


        <!-- Script para manejar la selección de "TODOS" y validar al enviar -->
        <script>
            document.getElementById('labTodosAccesorios').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('.lab-checkbox-accesorios');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = document.getElementById('labTodosAccesorios').checked;
                });
            });

            document.getElementById('form-accesorios').addEventListener('submit', function(event) {
                var checkboxes = document.querySelectorAll('.lab-checkbox-accesorios');
                var isChecked = false;

                // Verificar si al menos un checkbox está marcado
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        isChecked = true;
                    }
                });

                // Si no hay ninguno seleccionado, mostrar alerta y bloquear el envío del formulario
                if (!isChecked) {
                    event.preventDefault();  // Bloquea el envío del formulario
                    alert('Por favor, selecciona al menos un laboratorio antes de generar el reporte.');
                }
            });
        </script>

            </div>
            
        </div>
         {{-- tabla --}}
         <style>
            /* Oculta el texto de la celda */
            .text-hidden {
                color: transparent;  /* Oculta el texto */
                text-shadow: 0 0 0 #000;  /* Para evitar que el texto sea seleccionable */
            }
        </style>
        
        <div class="card-body">
            <table id="equipoinformatico" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>N° PC</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Urgencia</th>
                        <th>Laboratorio</th>
                        <th>Codigo de barras</th>
                        <th>Componentes</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipoinformatico as $equipoinformaticos)
                        <tr>
                            <td>{{ $equipoinformaticos->marca }}</td>
                            <td>{{ $equipoinformaticos->modelo }}</td>
                            <td>{{ $equipoinformaticos->estado }}</td>
                            <!-- Aplicar color y ocultar texto en la columna de urgencia -->
                            <td class="urgencia-cell text-hidden" style="background-color: 
                                @if($equipoinformaticos->valor == 'Critico') #FF0000
                                @elseif($equipoinformaticos->valor == 'Normal') #FFFF00
                                @elseif($equipoinformaticos->valor == 'Baja') #008000
                                @else #cccccc
                                @endif;">
                                {{ $equipoinformaticos->valor }}
                            </td>
                            
                            <td>{{ $equipoinformaticos->laboratorio->nombre }}</td>
                            <td>{{ $equipoinformaticos->codigo  }}
                                <img src="{{ asset('barcodes/' . $equipoinformaticos->codigo . '.png') }}" alt="Código de Barras" style="width: 100px; height: auto;">
                                <br>
                                <a href="{{ asset('barcodes/' . $equipoinformaticos->codigo . '.png') }}" download class="btn btn-outline-success btn-sm mt-1">
                                    Descargar
                                </a>
                            </td>
                            <td width="10px">
                                <a href="#" class="btn btn-success" data-toggle="modal"
                                    data-target="#infoModal{{ $equipoinformaticos->id }}">
                                    <i class="fas fa-save mr-1"></i>
                                </a>
                                <a href="#" class="btn btn-warning" data-toggle="modal"
                                    data-target="#eModal{{ $equipoinformaticos->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td width="10px">
                                <a href="#" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editModal{{ $equipoinformaticos->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            
                            <td width="10px">
                                <form action="{{ route('admin.equipoinformatico.destroy', $equipoinformaticos->id) }}"
                                    method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        

{{-- Modal de edición --}}
@foreach ($equipoinformatico as $equipoinformaticos)
<div class="modal fade" id="editModal{{ $equipoinformaticos->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $equipoinformaticos->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $equipoinformaticos->id }}Label">Editar Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.equipoinformatico.update', $equipoinformaticos->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Campos del formulario de edición -->
                    <div class="form-group">
                        <label for="marca{{ $equipoinformaticos->id }}">Marca</label>
                        <input type="text" class="form-control" name="marca" id="marca{{ $equipoinformaticos->id }}" value="{{ $equipoinformaticos->marca }}" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo{{ $equipoinformaticos->id }}">Modelo</label>
                        <input type="text" class="form-control" name="modelo" id="modelo{{ $equipoinformaticos->id }}" value="{{ $equipoinformaticos->modelo }}" required>
                    </div>

                    <!-- Estado y Urgencia (sin script embebido) -->
                    <div class="form-group">
                        <label for="estado{{ $equipoinformaticos->id }}">Estado</label>
                        <select class="form-control" name="estado" id="estado{{ $equipoinformaticos->id }}">
                            <option value="Disponible" {{ $equipoinformaticos->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="En uso" {{ $equipoinformaticos->estado == 'En uso' ? 'selected' : '' }}>En uso</option>
                            <option value="En mantenimiento" {{ $equipoinformaticos->estado == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="valor{{ $equipoinformaticos->id }}">Urgencia</label>
                        <select class="form-control" id="valor{{ $equipoinformaticos->id }}" name="valor" {{ $equipoinformaticos->estado == 'En mantenimiento' ? '' : 'disabled' }}>
                            <option value="NO ASIGNADO" {{ $equipoinformaticos->valor == 'NO ASIGNADO' ? 'selected' : '' }}>NO ASIGNADO</option>
                            <option value="Critico" {{ $equipoinformaticos->valor == 'Critico' ? 'selected' : '' }}>Crítico</option>
                            <option value="Normal" {{ $equipoinformaticos->valor == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Baja" {{ $equipoinformaticos->valor == 'Baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>

                    <!-- Laboratorio -->
                    <div class="form-group">
                        <label for="laboratorio{{ $equipoinformaticos->id }}">Laboratorio</label>
                        <select class="form-control" name="laboratorio_id" id="laboratorio{{ $equipoinformaticos->id }}">
                            @foreach($laboratorios as $laboratorio)
                            <option value="{{ $laboratorio->id }}" {{ $equipoinformaticos->laboratorio_id == $laboratorio->id ? 'selected' : '' }}>
                                {{ $laboratorio->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Otros campos del formulario -->
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




            {{-- Modal de información de componentes --}}
            @foreach ($equipoinformatico as $equipoinformaticos)
                <div class="modal fade" id="infoModal{{ $equipoinformaticos->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="infoModal{{ $equipoinformaticos->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-indigo text-white">
                                <h5 class="modal-title" id="infoModal{{ $equipoinformaticos->id }}Label">
                                    Agregar Componentes a {{ $equipoinformaticos->marca }}
                                    {{ $equipoinformaticos->modelo }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.componente.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="equipoinformatico_id"
                                    value="{{ $equipoinformaticos->id }}">
                                <div class="modal-body">
                                    <table id="componentes" class="table table-bordered table-hover table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $tiposComponentes = [
                                                    'Disco Duro',
                                                    'Placa madre',
                                                    'Microprocesador',
                                                    'Memoria',
                                                    'Monitor',
                                                    'Teclado',
                                                    'Mouse',
                                                    'T.Video',
                                                    'T.Red',
                                                    'Lectora',
                                                ];
                                            @endphp
                                            @foreach ($tiposComponentes as $i => $tipo)
                                                <tr>
                                                    <td><input type="text"
                                                            name="componentes[{{ $i }}][tipo]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $tipo }}" readonly></td>
                                                    <td><input type="text"
                                                            name="componentes[{{ $i }}][descripcion]"
                                                            class="form-control form-control-sm"
                                                            placeholder="Descripción" required></td>
                                                    <td><input type="text"
                                                            name="componentes[{{ $i }}][marca]"
                                                            class="form-control form-control-sm" placeholder="Marca"
                                                            required></td>
                                                    <td><input type="text"
                                                            name="componentes[{{ $i }}][modelo]"
                                                            class="form-control form-control-sm" placeholder="Modelo"
                                                            required></td>
                                                    <td><input type="text"
                                                            name="componentes[{{ $i }}][numeroserie]"
                                                            class="form-control form-control-sm"
                                                            placeholder="Número de serie" required></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success">Guardar Componentes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Modal de actualización de componentes --}}
            @foreach ($equipoinformatico as $equipoinformaticos)
                <div class="modal fade" id="eModal{{ $equipoinformaticos->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="eModal{{ $equipoinformaticos->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-indigo text-white">
                                <h5 class="modal-title" id="eModal{{ $equipoinformaticos->id }}Label">
                                    Componentes de {{ $equipoinformaticos->marca }} {{ $equipoinformaticos->modelo }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.componente.update', $equipoinformaticos->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="card-body">
                                        <table id="componentes" class="table table-bordered table-hover table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Descripción</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($equipoinformaticos->componentes as $componente)
                                                    <tr>
                                                        <td><input type="text"
                                                                name="componentes[{{ $componente->id }}][tipo]"
                                                                class="form-control form-control-sm border-0 bg-light"
                                                                value="{{ $componente->tipo }}"></td>
                                                        <td><input type="text"
                                                                name="componentes[{{ $componente->id }}][descripcion]"
                                                                class="form-control form-control-sm border-0 bg-light"
                                                                value="{{ $componente->descripcion }}"></td>
                                                        <td><input type="text"
                                                                name="componentes[{{ $componente->id }}][marca]"
                                                                class="form-control form-control-sm border-0 bg-light"
                                                                value="{{ $componente->marca }}"></td>
                                                        <td><input type="text"
                                                                name="componentes[{{ $componente->id }}][modelo]"
                                                                class="form-control form-control-sm border-0 bg-light"
                                                                value="{{ $componente->modelo }}"></td>
                                                        <td><input type="text"
                                                                name="componentes[{{ $componente->id }}][numeroserie]"
                                                                class="form-control form-control-sm border-0 bg-light"
                                                                value="{{ $componente->numeroserie }}"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success btn-save">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Script para confirmación de eliminación -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
<script>
    // Función genérica para manejar la habilitación/deshabilitación del campo "valor"
    function toggleValor(id = '') {
        const estado = document.getElementById('estado' + id).value;
        const valorSelect = document.getElementById('valor' + id);
        const valorHidden = document.getElementById('valor-hidden' + id);

        if (estado === 'En mantenimiento') {
            valorSelect.disabled = false; // Habilita el select "valor"
            valorHidden.value = valorSelect.value; // Sincroniza el valor oculto con el select visible
        } else {
            valorSelect.disabled = true; // Deshabilita el select "valor"
            valorSelect.value = 'NO ASIGNADO'; // Restablece el valor visible
            valorHidden.value = 'NO ASIGNADO'; // Sincroniza el valor oculto
        }
    }

    // Función genérica para sincronizar el campo oculto con el select visible
    function syncHiddenValor(id = '') {
        const valorSelect = document.getElementById('valor' + id);
        const valorHidden = document.getElementById('valor-hidden' + id);
        valorHidden.value = valorSelect.value; // Sincroniza el valor oculto
    }

    // Inicialización al cargar el DOM
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa los selects de todos los formularios
        const estados = document.querySelectorAll('[id^="estado"]');
        estados.forEach((estado) => {
            const id = estado.id.replace('estado', ''); // Obtiene el sufijo del ID
            toggleValor(id);
        });
    });
</script>
