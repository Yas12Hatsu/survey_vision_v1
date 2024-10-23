@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard Administrador Survey Vision')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="row">
  <div class="col-xxl-8 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary mb-3">Felicidades! 🎉</h5>
            <p class="mb-6">
              Se han realizado el {{ number_format($porcentajeEncuestasHoy) }}% de encuestas el día de hoy.<br>
              Revisa que es lo que han comentado tus clientes hoy 🙋‍♂️
            </p>
            <a href="javascript:;" class="btn btn-sm btn-outline-primary">Revisar respuestas</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{asset('assets/img/illustrations/man-with-laptop.png')}}" height="175" class="scaleX-n1-rtl" alt="View Badge User">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 order-1">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="chart success" class="rounded">
              </div>
            </div>
            <p class="mb-1">Respuestas Recibidas</p>
            <h1 class="card-title mb-3">{{ $totalRespuestasRecibidas }}</h1>
            <!--<small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +72.80%</small>-->
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="wallet info" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded text-muted"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="javascript:void(0);">Actualizar</a>
                  <!--<a class="dropdown-item" href="javascript:void(0);">Delete</a>-->
                </div>
              </div>
            </div>
            <p class="mb-1">Promedio calificaciones</p>
            <h4 class="card-title mb-3">{{ number_format($promedioCalificacionesCalidadPrecio ?? 0, 2) }}%</h4>
            <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i>Calidad-Precio</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">Tendencias de Participación</h5>
        </div>
        <div class="card-body">
            <!-- Selector de categorías -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Selecciona una Categoría:</label>
                <select id="categoria" class="form-select" onchange="updateChart()">
                    @foreach ($respuestasPorCategoria as $categoria => $respuestas)
                        <option value="{{ $categoria }}">{{ $categoria }}</option>
                    @endforeach
                </select>
            </div>

            <canvas id="totalRevenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos de las respuestas por categoría
    const respuestasPorCategoria = @json($respuestasPorCategoria);

    // Inicializar la gráfica
    const ctx = document.getElementById('totalRevenueChart').getContext('2d');
    let totalRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Muy Insatisfecho 😟', 'Insatisfecho 😐', 'Neutral 🙂', 'Satisfecho 😃', 'Muy Satisfecho 😃'],
            datasets: [{
                label: 'Cantidad de Respuestas',
                data: [0, 0, 0, 0, 0], // Inicializa con 0
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 10, // Valor máximo en el eje Y, asumiendo un total de 50 encuestas
                    title: {
                        display: true,
                        text: 'Cantidad de Respuestas'
                    }
                }
            }
        }
    });

    // Función para actualizar la gráfica según la categoría seleccionada
    function updateChart() {
        const categoriaSeleccionada = document.getElementById('categoria').value;
        const data = respuestasPorCategoria[categoriaSeleccionada];

        // Actualizar los datos en la gráfica
        totalRevenueChart.data.datasets[0].data = [
            data[1] || 0, // Muy Insatisfecho
            data[2] || 0, // Insatisfecho
            data[3] || 0, // Neutral
            data[4] || 0, // Satisfecho
            data[5] || 0  // Muy Satisfecho
        ];
        totalRevenueChart.update();
    }

    // Inicializar la gráfica con la primera categoría
    updateChart();
</script>


  <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
    <div class="row">
      <div class="col-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/paypal.png')}}" alt="paypal" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded text-muted"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <p class="mb-1">Promedio Calificaciones</p>
            <h4 class="card-title mb-3">{{ number_format($promedioCalificacionesAmbiente ?? 0, 2) }}%</h4>
            <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i>Ambiente</small>
          </div>
        </div>
      </div>
      <div class="col-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded text-muted"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <p class="mb-1">Promedio calificaciones</p>
            <h4 class="card-title mb-3">{{ number_format($promedioCalificacionesAtencion ?? 0, 2) }}%</h4>
            <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i>Atención personal</small>
          </div>
        </div>
      </div>
      <div class="col-12 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title mb-6">
                  <h5 class="text-nowrap mb-1">Comentarios Recientes </h5>
                  <span class="badge bg-label-warning">Respuestas abiertas</span>
                </div>
                <!-- Agregar la sección para mostrar los últimos comentarios -->
                <div class="mt-4">
                    <ul class="list-group">
                        @foreach ($ultimosComentariosCualitativos as $comentario)
                            <li class="list-group-item">{{ $comentario->respuesta_cuali }}</li>
                        @endforeach
                    </ul>
                </div>
              </div>
              <div id="profileReportChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
