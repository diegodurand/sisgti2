<div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $equiposinformaticos}}</h3>
                            <p>equiposinformaticos</p>
                        </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-desktop" ></i>
                    </div>
                    <a href="{{ route('admin.equipoinformatico.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $accesorios}}</h3>
                            <p>Accesorios</p>
                        </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-plug" ></i>
                    </div>
                    <a href="{{ route('admin.accesorio.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $mobiliarios}}</h3>
                            <p>Mobiliarios</p>
                        </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-cubes" ></i>
                    </div>
                    <a href="{{ route('admin.mobiliario.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $laboratorios}}</h3>
                            <p>Laboratorios</p>
                        </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-hdd" ></i>
                    </div>
                    <a href="{{ route('admin.laboratorio.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>