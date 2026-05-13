@extends('layouts.master')

@section('title', $title ?? 'Import Applications')

@section('content')
    <main>
        @include('include.page_header')

        <div class="container-xl px-4 mt-4">

            {{-- Success / Error alerts --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('import_success') !== null)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>
                    <strong>{{ session('import_success') }}</strong> application(s) imported and marked as <strong>Forwarded</strong>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $e)
                        <div><i class="fas fa-times-circle me-1"></i> {{ $e }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Validation failed — nothing imported --}}
            @php $skipped = session('import_skipped', []); @endphp
            @if (!empty($skipped))
                <div class="card border-danger mb-4">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-times-circle me-1"></i>
                        Import Aborted — {{ count($skipped) }} Row(s) Have Validation Errors. No data was imported.
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px">Row #</th>
                                    <th>Name</th>
                                    <th>CNIC</th>
                                    <th>Error(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($skipped as $s)
                                    <tr>
                                        <td>{{ $s['row'] }}</td>
                                        <td>{{ $s['name'] }}</td>
                                        <td>{{ $s['cnic'] }}</td>
                                        <td class="text-danger">{{ $s['reason'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted small">
                        Fix all errors in the CSV file and re-upload. All rows must pass validation before any data is saved.
                    </div>
                </div>
            @endif

            <div class="row">
                {{-- Upload form --}}
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-file-import me-1"></i> Upload CSV File
                        </div>
                        <div class="card-body">
                            <form action="{{ route('applicants.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Select CSV File</label>
                                    <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                                    <div class="form-text">Only <code>.csv</code> files are accepted. Max size: 5 MB.</div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-1"></i> Import
                                    </button>
                                    <a href="{{ route('applicants.importSample') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-download me-1"></i> Download Template
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i> CSV Format Instructions
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">The CSV must have <strong>exactly</strong> these 14 columns in this order:</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Column</th>
                                            <th>Format / Allowed Values</th>
                                            <th>Required</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td><code>form_no</code></td><td>Application number — must be unique in system</td><td>Yes</td></tr>
                                        <tr><td><code>name</code></td><td>Full name</td><td>Yes</td></tr>
                                        <tr><td><code>father_name</code></td><td>Father's full name</td><td>Yes</td></tr>
                                        <tr><td><code>gender</code></td><td><code>Male</code> or <code>Female</code></td><td>Yes</td></tr>
                                        <tr><td><code>disabled</code></td><td><code>Yes</code> or <code>No</code></td><td>Yes</td></tr>
                                        <tr><td><code>cnic</code></td><td><code>NNNNN-NNNNNNN-N</code> (e.g. 81202-1234567-1)</td><td>Yes</td></tr>
                                        <tr><td><code>branch_id</code></td><td>Numeric Branch ID from system</td><td>Yes</td></tr>
                                        <tr><td><code>permanent_address</code></td><td>Full address</td><td>Yes</td></tr>
                                        <tr><td><code>district</code></td><td>District name (e.g. Kotli, Mirpur)</td><td>Yes</td></tr>
                                        <tr><td><code>business_category</code></td><td>Category name (matched or assigned to Others)</td><td>Yes</td></tr>
                                        <tr><td><code>business_status</code></td><td><code>New</code> or <code>Existing</code></td><td>Yes</td></tr>
                                        <tr><td><code>business_address</code></td><td>Full address</td><td>Yes</td></tr>
                                        <tr><td><code>loan_amount</code></td><td>Number only, no commas (e.g. 500000)</td><td>Yes</td></tr>
                                        <tr><td><code>tier</code></td><td><code>1</code>, <code>2</code>, or <code>3</code></td><td>Yes</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="small text-muted mb-0 mt-2">
                                <li>All imported records are set to <strong>Forwarded</strong> status, type <strong>Manual</strong>, fee <strong>Paid</strong>.</li>
                                <li>A status log entry is recorded with the uploading admin's name.</li>
                                <li>Rows with duplicate CNIC or duplicate Form No are automatically skipped.</li>
                                <li>Business category is matched by name; if no match found it is assigned to the existing <em>Others</em> category (no new categories are created).</li>
                                <li>District must match an existing district name exactly (or close match).</li>
                                <li>To find branch IDs: go to the Branches list in the system.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
