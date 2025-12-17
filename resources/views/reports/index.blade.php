@extends('layouts.master')

@section('title', $title ?? 'Reports')

@section('content')
    <main>
        @include('include.page_header')

        <!-- Page Loader Component -->
        @include('components.loader', ['message' => 'Processing filters...'])

        <div class="container-xl px-4 mt-4">
            <!-- Filters Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-filter me-1"></i>
                    Filter Applications
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row gx-3 mb-3">
                            <!-- Date Range Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label class="small mb-1" for="litepickerReportRange">Date Range</label>
                                <input type="text" class="form-control form-control-sm" id="litepickerReportRange"
                                    name="daterange" placeholder="Select date range" readonly>
                                <input type="hidden" id="date_from" name="date_from">
                                <input type="hidden" id="date_to" name="date_to">
                            </div>
                            <!-- District Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label class="small mb-1" for="district_id">District</label>
                                <select class="form-select form-select-sm select2" id="district_id" name="district_id">
                                    <option value="">All Districts</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Gender Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label class="small mb-1" for="gender">Gender/Quota</label>
                                <select class="form-select form-select-sm select2" id="gender" name="gender">
                                    <option value="">All</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tier Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label class="small mb-1" for="tier">Tier</label>
                                <select class="form-select form-select-sm select2" id="tier" name="tier">
                                    <option value="">All Tiers</option>
                                    @foreach ($tiers as $tierValue => $tierLabel)
                                        <option value="{{ $tierValue }}">{{ $tierLabel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fee Status Filter -->
                            <div class="col-md-4 col-lg-3">
                                <label class="small mb-1" for="fee_status">Fee Status</label>
                                <select class="form-select form-select-sm select2" id="fee_status" name="fee_status">
                                    <option value="">All</option>
                                    @foreach ($feeStatuses as $feeStatus)
                                        <option value="{{ $feeStatus }}">{{ ucfirst($feeStatus) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Application Status Filter -->
                            <div class="col-md-4 col-lg-2">
                                <label class="small mb-1" for="status">Application Status</label>
                                <select class="form-select form-select-sm select2" id="status" name="status">
                                    <option value="">Default (Exclude NotCompleted)</option>
                                    @foreach ($applicationStatuses as $appStatus)
                                        <option value="{{ $appStatus }}">{{ $appStatus }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Buttons -->
                            <div class="col-md-4 col-lg-2">
                                <label class="small mb-1 d-block">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-primary btn-sm me-2">
                                    <i class="fas fa-search"></i> Apply
                                </button>
                                <button type="button" id="reset-filters" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table Card -->
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Applications Report
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reports-table" class="table table-bordered table-striped table-hover"
                            style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr.No</th>
                                    <th>App No</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>CNIC</th>
                                    <th>Phone</th>
                                    <th>District</th>
                                    <th>Tehsil</th>
                                    <th>Gender</th>
                                    <th>Business</th>
                                    <th>Category</th>
                                    <th>Tier</th>
                                    <th>Fee Status</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Read URL parameters and pre-populate filters
            function getUrlParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Pre-populate filters from URL parameters
            const urlStatus = getUrlParameter('status');
            const urlFeeStatus = getUrlParameter('fee_status');
            const urlDistrict = getUrlParameter('district_id');
            const urlGender = getUrlParameter('gender');
            const urlTier = getUrlParameter('tier');

            if (urlStatus) {
                $('#status').val(urlStatus).trigger('change');
            }
            if (urlFeeStatus) {
                $('#fee_status').val(urlFeeStatus).trigger('change');
            }
            if (urlDistrict) {
                $('#district_id').val(urlDistrict).trigger('change');
            }
            if (urlGender) {
                $('#gender').val(urlGender).trigger('change');
            }
            if (urlTier) {
                $('#tier').val(urlTier).trigger('change');
            }

            // Initialize Litepicker Date Range with preset ranges
            let pickerReport;
            const litepickerReportRangeEle = document.getElementById('litepickerReportRange');
            if (litepickerReportRangeEle) {
                pickerReport = new Litepicker({
                    element: litepickerReportRangeEle,
                    singleMode: false,
                    numberOfMonths: 2,
                    numberOfColumns: 2,
                    format: 'MMM DD, YYYY',
                    plugins: ['ranges'],
                    ranges: {
                        position: 'left',
                        customRanges: {
                            'Today': [new Date(), new Date()],
                            'Yesterday': [
                                new Date(new Date().setDate(new Date().getDate() - 1)),
                                new Date(new Date().setDate(new Date().getDate() - 1))
                            ],
                            'Last 7 Days': [
                                new Date(new Date().setDate(new Date().getDate() - 6)),
                                new Date()
                            ],
                            'Last 30 Days': [
                                new Date(new Date().setDate(new Date().getDate() - 29)),
                                new Date()
                            ],
                            'This Month': [
                                new Date(new Date().getFullYear(), new Date().getMonth(), 1),
                                new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0)
                            ],
                            'Last Month': [
                                new Date(new Date().getFullYear(), new Date().getMonth() - 1, 1),
                                new Date(new Date().getFullYear(), new Date().getMonth(), 0)
                            ],
                            'This Year': [
                                new Date(new Date().getFullYear(), 0, 1),
                                new Date(new Date().getFullYear(), 11, 31)
                            ],
                            'Last Year': [
                                new Date(new Date().getFullYear() - 1, 0, 1),
                                new Date(new Date().getFullYear() - 1, 11, 31)
                            ]
                        }
                    },
                    setup: (picker) => {
                        picker.on('selected', (date1, date2) => {
                            let dateFrom = date1.format('YYYY-MM-DD');
                            let dateTo = date2.format('YYYY-MM-DD');
                            $('#date_from').val(dateFrom);
                            $('#date_to').val(dateTo);
                        });
                        picker.on('clear', () => {
                            $('#date_from').val('');
                            $('#date_to').val('');
                        });
                    },
                    resetButton: true,
                    autoApply: false,
                    buttonText: {
                        apply: 'Apply',
                        cancel: 'Clear',
                        reset: 'Reset'
                    }
                });
            }

            // Initialize DataTable
            let table = $('#reports-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('reports.index') }}',
                    data: function(d) {
                        d.district_id = $('#district_id').val();
                        d.gender = $('#gender').val();
                        d.tier = $('#tier').val();
                        d.fee_status = $('#fee_status').val();
                        d.status = $('#status').val();
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'application_no',
                        name: 'application_no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'fatherName',
                        name: 'fatherName'
                    },
                    {
                        data: 'cnic',
                        name: 'cnic'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'district',
                        name: 'district.name'
                    },
                    {
                        data: 'tehsil',
                        name: 'tehsil.name'
                    },
                    {
                        data: 'gender',
                        name: 'quota'
                    },
                    {
                        data: 'businessName',
                        name: 'businessName'
                    },
                    {
                        data: 'business_category',
                        name: 'businessCategory.name'
                    },
                    {
                        data: 'tier_label',
                        name: 'tier'
                    },
                    {
                        data: 'fee_status_badge',
                        name: 'fee_status',
                        orderable: false
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_date',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude action column
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows', '500 rows', 'Show all']
                ],
                scrollX: true,
                scrollCollapse: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ], // Order by Application No descending
            });

            // Apply Filters
            $('#apply-filters').on('click', function() {
                showLoader('Applying filters...', 2000);
                table.ajax.reload(function() {
                    hideLoader();
                });
            });

            // Reset Filters
            $('#reset-filters').on('click', function() {
                showLoader('Resetting filters...', 2000);
                $('#filter-form')[0].reset();
                $('.select2').val(null).trigger('change'); // Reset Select2
                $('#litepickerReportRange').val(''); // Clear Litepicker display
                $('#date_from').val(''); // Clear hidden date_from
                $('#date_to').val(''); // Clear hidden date_to
                // Clear Litepicker instance
                if (pickerReport) {
                    pickerReport.clearSelection();
                }
                table.ajax.reload(function() {
                    hideLoader();
                });
            });

            // Allow Enter key to trigger filter
            $('#filter-form').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#apply-filters').click();
                }
            });

            // Auto-apply filters if URL parameters exist
            const hasUrlParams = urlStatus || urlFeeStatus || urlDistrict || urlGender || urlTier;
            if (hasUrlParams) {
                // Small delay to ensure select2 is fully initialized
                setTimeout(function() {
                    showLoader('Loading filtered data...', 1500);
                    table.ajax.reload(function() {
                        hideLoader();
                    });
                }, 100);
            }
        });
    </script>
@endpush
