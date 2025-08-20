@extends('layouts.master')

@section('title', $title ?? 'Applicants')

@section('content')
    <main>
        @include('include.page_header')
        <div class="container-xl px-4 mt-4">
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    Applicants
                </div>

                <div class="card-body">
                    <table id="activitylogs-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User</th>
                                <th>Model</th>
                                <th>Model ID</th>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    {{-- @include('sweetalert::alert') --}}
                </div>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#activitylogs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('activitylogs.index') }}', // backend route
                    data: function(d) {
                        d.search.value = $('input[type="search"]').val();
                        // If you add filters (date_from, date_to) you can pass them here as well
                        // d.date_from = $('#date_from').val();
                        // d.date_to   = $('#date_to').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'model_id',
                        name: 'model_id'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'operation',
                        name: 'operation'
                    },
                ],
                dom: 'Bfrtip',
                buttons: ['pageLength', 'copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [
                    [10, 50, 100, 500, -1],
                    ['10 rows', '50 rows', '100 rows', '500 rows', 'Show all']
                ],
                responsive: true,
                pageLength: 10,
                paging: true,
                info: true,
            });

            $('input[type="search"]').on('keyup', function() {
                table.draw();
            });
        });
    </script>
@endpush
