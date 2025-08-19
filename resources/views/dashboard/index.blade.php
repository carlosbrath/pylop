@extends('layouts.master')
@section('title', $title ?? 'Dashboard')
@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </h1>
                            <div class="page-header-subtitle"></div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <div class="row">
                                <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                    <span class="input-group-text"><i class="text-primary"
                                            data-feather="calendar"></i></span>
                                    <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                        placeholder="Select date range..." />

                                </div>
                                <div style="width: 5.5rem;">
                                    <a class="btn btn-warning" href="{{ route('dashboard') }}">Clear</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 mb-4">
                    <!-- <div class="card h-100">
                        <div class="card-body h-100 p-5">
                            <div class="row align-items-center">
                                <div class="col-xl-8 col-xxl-8">
                                    <div class="text-center text-xl-start text-xxl-start mb-4 mb-xl-0 mb-xxl-4">
                                        <h1 class="text-primary">Welcome to PMYPL</h1>
                                        <p class="text-gray-700 mb-0">Azad Government of the State of Jammu & Kashmir.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-4 text-center"><img class="img-fluid" src="{{ asset('images/full_map.png') }}" style="max-width: 10rem" /></div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="container-xl px-4">
            <!-- Example Colored Cards for Dashboard Demo-->
            <div class="row">
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Total </div>
                                    <div class="text-lg fw-bold">{{ $total }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="activity"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="">View</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Pending</div>
                                    <div class="text-lg fw-bold">{{ $pending }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="users"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="">View</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Forworded</div>
                                    <div class="text-lg fw-bold">{{ $forwarded }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="home"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="">View</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Rejected</div>
                                    <div class="text-lg fw-bold">{{ $rejected }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="truck"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="">View</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <!-- Tabbed dashboard card example-->
                    <div class="card mb-4">
                        <div class="card-header border-bottom">
                            <!-- Dashboard card navigation-->
                            <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                                <li class="nav-item me-1"><a class="nav-link active" id="overview-pill" href="#overview"
                                        data-bs-toggle="tab" role="tab" aria-controls="overview"
                                        aria-selected="true">Overview</a></li>
                                <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities"
                                        data-bs-toggle="tab" role="tab" aria-controls="activities"
                                        aria-selected="false">Activities</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="dashboardNavContent">
                                <!-- Dashboard Tab Pane 1-->
                                <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                    aria-labelledby="overview-pill">
                                    <div class="chart-area mb-4 mb-lg-0" style="height: 20rem">
                                        <canvas id="myAreaChart"
                                            width="100%" height="30"></canvas>
                                        </div>
                                </div>
                                <!-- Dashboard Tab Pane 2-->
                                <div class="tab-pane fade" id="activities" role="tabpanel"
                                    aria-labelledby="activities-pill">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Event</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Event</th>
                                                <th>Time</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td>01/13/20</td>
                                                <td>
                                                    <i class="me-2 text-green" data-feather="zap"></i>
                                                    Server online
                                                </td>
                                                <td>1:21 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/13/20</td>
                                                <td>
                                                    <i class="me-2 text-red" data-feather="zap-off"></i>
                                                    Server restarted
                                                </td>
                                                <td>1:00 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/12/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126550</a>
                                                </td>
                                                <td>5:45 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/12/20</td>
                                                <td>
                                                    <i class="me-2 text-blue" data-feather="user"></i>
                                                    Valerie Luna submitted
                                                    <a href="#!">quarter four report</a>
                                                </td>
                                                <td>4:23 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/12/20</td>
                                                <td>
                                                    <i class="me-2 text-yellow" data-feather="database"></i>
                                                    Database backup created
                                                </td>
                                                <td>3:51 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/12/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126549</a>
                                                </td>
                                                <td>1:22 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/20</td>
                                                <td>
                                                    <i class="me-2 text-blue" data-feather="user-plus"></i>
                                                    New user created:
                                                    <a href="#!">Sam Malone</a>
                                                </td>
                                                <td>4:18 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126548</a>
                                                </td>
                                                <td>4:02 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126547</a>
                                                </td>
                                                <td>3:47 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/20</td>
                                                <td>
                                                    <i class="me-2 text-green" data-feather="zap"></i>
                                                    Server online
                                                </td>
                                                <td>1:19 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/20</td>
                                                <td>
                                                    <i class="me-2 text-red" data-feather="zap-off"></i>
                                                    Server restarted
                                                </td>
                                                <td>1:00 AM</td>
                                            </tr>
                                            <tr>
                                                <td>01/10/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126547</a>
                                                </td>
                                                <td>5:31 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/10/20</td>
                                                <td>
                                                    <i class="me-2 text-purple" data-feather="shopping-cart"></i>
                                                    New order placed! Order #
                                                    <a href="#!">1126546</a>
                                                </td>
                                                <td>12:13 PM</td>
                                            </tr>
                                            <tr>
                                                <td>01/10/20</td>
                                                <td>
                                                    <i class="me-2 text-blue" data-feather="user"></i>
                                                    Diane Chambers submitted
                                                    <a href="#!">quarter four report</a>
                                                </td>
                                                <td>10:56 AM</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </main>
@section('scripts')
    <script></script>
@endsection
@endsection
