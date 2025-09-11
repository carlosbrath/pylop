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

                </div>
            </div>
        </div>
        <div class="container-xl px-4">
            <!-- Example Colored Cards for Dashboard Demo-->
            <div class="row">
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
                            {{-- <a class="text-white stretched-link" href="">View</a> --}}
                            {{-- <div class="text-white"><i class="fas fa-angle-right"></i></div> --}}
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Forworded </div>
                                    <div class="text-lg fw-bold">{{ $forwarded }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="activity"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            {{-- <a class="text-white stretched-link" href="">View</a> --}}
                            {{-- <div class="text-white"><i class="fas fa-angle-right"></i></div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Approved</div>
                                    <div class="text-lg fw-bold">{{ $approved }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="home"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            {{-- <a class="text-white stretched-link" href="">View</a> --}}
                            {{-- <div class="text-white"><i class="fas fa-angle-right"></i></div> --}}
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
                            {{-- <a class="text-white stretched-link" href="">View</a> --}}
                            {{-- <div class="text-white"><i class="fas fa-angle-right"></i></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-6 mb-4">
                    <div class="card bg-gradient-fresh text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="me-3">
                                    <div class="text-white-75 small">Gender Quota</div>
                                    <div class="text-lg fw-bold">Applicants by Status</div>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <!-- Reload Icon -->
                                    <i id="reload-gender-btn" class="text-white-50 reload-icon"
                                        data-feather="refresh-cw"></i>

                                    <!-- Users Icon -->
                                    <i class="feather-xl text-white-50 mt-2" data-feather="users"></i>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="gender-quota-table" class="table table-sm   text-white mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th></th>
                                            <th>Pending</th>
                                            <th>Forwarded</th>
                                            <th>Approved</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td class="text-start">Male</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-start">Female</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-start">Special Persons</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-start">Transgender</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer small text-white-50 text-center">
                            Gender-wise status distribution
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-6 mb-4">
                    <div class="card bg-gradient-fresh text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="me-3">
                                    <div class="text-white-75 small">Tier Quota</div>
                                    <div class="text-lg fw-bold">Applicants by Status</div>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <!-- Reload Icon -->
                                    <i id="tier-gender-btn" class="text-white-50 reload-icon"
                                        data-feather="refresh-cw"></i>

                                    <!-- Users Icon -->
                                    <i class="feather-xl text-white-50 mt-2" data-feather="users"></i>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tier-quota-table" class="table table-sm   text-white mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th></th>
                                            <th>Pending</th>
                                            <th>Approved</th>
                                            <th>Forwarded</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td class="text-start">Tier 1</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-start">Tier 2</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-start">Tier 3</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer small text-white-50 text-center">
                            Tier-wise status distribution
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
                                        aria-selected="true">Daily</a></li>
                                <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities"
                                        data-bs-toggle="tab" role="tab" aria-controls="activities"
                                        aria-selected="false">Monthly</a></li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="dashboardNavContent">
                                <!-- Dashboard Tab Pane 1-->
                                <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                    aria-labelledby="overview-pill">
                                    <div class="chart-area mb-4 mb-lg-0" style="height: 20rem">
                                        <canvas id="dailyChart" width="100%" height="30"></canvas>
                                    </div>
                                </div>
                                <!-- Dashboard Tab Pane 2-->
                                <div class="tab-pane fade" id="activities" role="tabpanel"
                                    aria-labelledby="activities-pill">
                                    <div class="chart-area mb-4 mb-lg-0" style="height: 20rem">
                                        <canvas id="monthlyChart" width="100%" height="30"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    @push('scripts')
        <script>
            $(document).ready(function() {
                loadCardData("{{ route('ajax.gender-quota') }}", "gender", "gender-quota-table");
                $("#reload-gender-btn").on("click", function() {
                    loadCardData("{{ route('ajax.gender-quota') }}", "gender", "gender-quota-table");
                })
                loadCardData("{{ route('ajax.tier-quota') }}", "tier", "tier-quota-table");
                $("#tier-gender-btn").on("click", function() {
                    loadCardData("{{ route('ajax.tier-quota') }}", "tier", "tier-quota-table");
                })

            })


            function loadCardData(url,  render, targetId, callback = null) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.data) {
                            if (render === "gender") {
                                renderGenderQuota(response.data, targetId)
                            }
                            if (render === "tier") {
                                renderTierQuota(response.data, targetId)
                            }
                        }
                        if (callback && typeof callback === "function") {
                            callback(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading card data:", error);
                    }
                });
            }

            function renderGenderQuota(data, targetId) {
                let tbodyHtml = "";
                const rowMap = {
                    male: "Male",
                    female: "Female",
                    special: "Special",
                    transgender: "Transgender"
                };

                data.forEach(function(item) {
                    let genderKey = item.gender.toLowerCase();
                    let rowLabel = rowMap[genderKey] || item.gender;
                    tbodyHtml += `<tr class="text-center">
                            <td class="text-start">${rowLabel}</td>
                            <td>${item.pending ?? '-'}</td>
                            <td>${item.forwarded ?? '-'}</td>
                            <td>${item.approved ?? '-'}</td>
                            <td>${item.rejected ?? '-'}</td>
                        </tr>`;
                });
                $("#" + targetId + " tbody").html(tbodyHtml);
            }

            function renderTierQuota(data, targetId) {
                let tbodyHtml = "";
                const rowMap = {
                    1: "Tier 1",
                    2: "Tier 2",
                    3: "Tier 3",
                };

                data.forEach(function(item) {
                    let tierKey = item.tier;
                    let rowLabel = rowMap[tierKey];
                    tbodyHtml += `
                        <tr class="text-center">
                            <td class="text-start">${rowLabel}</td>
                            <td>${item.pending ?? '-'}</td>
                            <td>${item.approved ?? '-'}</td>
                            <td>${item.forwarded ?? '-'}</td>
                            <td>${item.rejected ?? '-'}</td>
                        </tr>
                    `;
                });
                // Replace the table body
                $("#" + targetId + " tbody").html(tbodyHtml);
            }
        </script>
        @include('include.charts')
    @endpush
@endsection
