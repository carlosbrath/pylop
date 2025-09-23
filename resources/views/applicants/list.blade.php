@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
    <main>
        @include('include.page_header')
        <div class="container-xl px-4 mt-4">
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    Applicants
                </div>
                <div class="card-body">
                    <table id="applicants-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Appli No</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>CNIC</th>
                                <th>Tier</th>
                                <th>District</th>
                                <th>Education</th>
                                <th>Challan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('#applicants-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('applicant.index') }}',
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
                    data: 'tier_label',
                    name: 'tier'
                },
                {
                    data: 'district',
                    name: 'district.name'
                }, // ✅ search by district name
                {
                    data: 'education',
                    name: 'education.education_level'
                }, // ✅ search by education
                {
                    data: 'fee_status',
                    name: 'fee_status'
                },
                {
                    data: 'status_label',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            dom: 'Bfrtip',
            buttons: ['pageLength', 'copy', 'csv', 'excel', 'pdf', 'print'],
            responsive: true,
            pageLength: 10
        });
    </script>
@endpush
