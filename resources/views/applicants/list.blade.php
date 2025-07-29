@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <!-- Example DataTable for Dashboard Demo-->
    <div class="container-xl px-4 mt-4">
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Users
            </div>
           
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>cnic</th>
                            <th>Tier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>cnic</th>
                            <th>Tier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($applicants as $applicant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$applicant->name}}</td>
                            <td>{{$applicant->fatherName}}</td>
                            <td>{{$applicant->cnic }}</td>
                            <td>
                                 @if($applicant->tier==1)
                                    Tier 1 (Up to 5  Lakh)
                                @elseif($applicant->tier==2)
                                    Tier 1 (5 to 10  Lakh)
                                @else
                                    Tier 1 (10 to 20  Lakh)
                                @endif
                            </td>
                            <td>
                                <div class="badge bg-primary text-white rounded-pill">Active</div>
                            </td>
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                                    <li><a class="dropdown-item" href="{{route('user.show', $applicant->id)}}">View</a></li>
                                    {{-- <li><a class="dropdown-item" href="#">Edit</a></li> --}}
                                </ul>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="confirmDelete('{{ route('user.destroy', $applicant->id) }}', '{{ $applicant->id }}')"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection