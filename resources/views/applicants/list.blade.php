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
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>CNIC</th>
                            <th>Tier</th>
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
$(document).ready(function() {
    $('#applicants-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('applicant.index') }}', // your route
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'fatherName', name: 'fatherName' },
            { data: 'cnic', name: 'cnic' },
            { data: 'tier_label', name: 'tier' },
            { data: 'status_label', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['pageLength','copy','csv','excel','pdf','print'],
        responsive: true,
        pageLength: 10,
        lengthMenu: [
            [10, 50, 100, 500, -1],
            ['10 rows', '50 rows', '100 rows', '500 rows', 'Show all']
        ],
    });
});
</script>
@endpush
