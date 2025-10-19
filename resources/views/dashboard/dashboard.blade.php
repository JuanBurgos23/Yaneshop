<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <!-- End Navbar -->

        <style>
            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 320px;
                max-width: 800px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid rgb(48, 45, 45);
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
                background-color: #333 !important;
                /* Fondo oscuro para la tabla */
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #fff !important;
                /* Color de texto blanco para contraste */
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
                background-color: #444 !important;
                /* Fondo oscuro para las cabeceras */
                color: #fff !important;
                /* Texto blanco para las cabeceras */
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: rgb(55, 55, 55) !important;
                /* Fondo oscuro para las filas pares */
            }

            .highcharts-data-table tr:nth-child(odd) {
                background: rgb(44, 44, 44) !important;
                /* Fondo oscuro para las filas impares */
            }

            .highcharts-data-table tr:hover {
                background: rgb(51, 51, 51) !important;
                /* Fondo oscuro cuando pasas el mouse sobre una fila */
            }

            .highcharts-description {
                margin: 0.3rem 10px;
                color: #fff !important;
                /* Cambiar el color del texto de la descripción a blanco */
            }

            .grafica-ingresos-figure,
            .highcharts-data-table table {
                min-width: 310px;
                max-width: 800px;
                margin: 1em auto;
            }

            #grafica-ingresos-container {
                height: 400px;
            }

            .grafica-ingresos-descripcion {
                margin: 0.3rem 10px;
                font-size: 1rem;
                color: #fff;
            }
        </style>

        <!-- Contenido Principal -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <!-- Total Clientes -->
                    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0">{{ $totalClientes }}</h3>
                                    <div class="icon icon-box-primary">
                                        <span class="mdi mdi-account-multiple icon-item"></span>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Total de Clientes</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Clientes Nuevos Hoy -->
                    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0">{{ $clientesHoy }}</h3>
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-account-plus icon-item"></span>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Clientes Registrados Hoy</h6>
                            </div>
                        </div>
                    </div>

                    

                </div>
                <div class="row">

                    <!-- Gráfico de Productos por Categoría (Pie) -->
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-center">Productos por Categoría</h5>
                                <div id="grafico-pie" style="width:100%; height:350px;"></div>
                                <p class="text-center mt-2">Porcentaje de productos por categoría.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Clientes Registrados por Mes (Column) -->
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-center">Clientes Registrados por Mes</h5>
                                <div id="grafico-column" style="width:100%; height:350px;"></div>
                                <p class="text-center mt-2">Cantidad de clientes registrados por mes.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Highcharts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Pie chart - Productos por Categoría
                Highcharts.chart('grafico-pie', {
                    chart: {
                        type: 'pie',
                        backgroundColor: 'transparent'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Porcentaje',
                        colorByPoint: true,
                        data: @json($productosPorCategoria)
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 768
                            },
                            chartOptions: {
                                plotOptions: {
                                    pie: {
                                        dataLabels: {
                                            style: {
                                                fontSize: '10px'
                                            }
                                        }
                                    }
                                }
                            }
                        }]
                    }
                });

                // Column chart - Clientes por Mes
                Highcharts.chart('grafico-column', {
                    chart: {
                        type: 'column',
                        backgroundColor: 'transparent'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: @json($meses),
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Clientes Registrados'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} clientes</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            borderRadius: 5,
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Clientes',
                        data: @json($clientesPorMes),
                        color: '#7cb5ec'
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 768
                            },
                            chartOptions: {
                                chart: {
                                    type: 'bar'
                                },
                                plotOptions: {
                                    bar: {
                                        dataLabels: {
                                            enabled: true,
                                            style: {
                                                fontSize: '10px'
                                            }
                                        }
                                    }
                                },
                                xAxis: {
                                    labels: {
                                        style: {
                                            fontSize: '10px'
                                        }
                                    }
                                },
                                yAxis: {
                                    labels: {
                                        style: {
                                            fontSize: '10px'
                                        }
                                    }
                                }
                            }
                        }]
                    }
                });

            });
        </script>

        <style>
            .card-body {
                padding: 20px;
            }

            .highcharts-figure {
                margin: 0 auto;
                max-width: 100%;
            }

            .grafica-descripcion {
                font-size: 0.9rem;
                color: #555;
            }

            @media (max-width: 767px) {
                .card-title {
                    font-size: 1rem;
                    text-align: center;
                }

                #grafico-pie,
                #grafico-column {
                    height: 300px !important;
                }
            }
        </style>
    </main>
</x-layout>