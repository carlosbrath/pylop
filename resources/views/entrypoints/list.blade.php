@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <!-- Example DataTable for Dashboard Demo-->
    <div class="container-xl px-4 mt-4">
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Entry Points
            <a href="{{route('entrypoints.create')}}" class="btn btn-outline-teal">Add New</a>
            </div>
           
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($entryPointOffice as $entryPoint)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$entryPoint->name}}</td>
                            <td><img  src="{{ asset('images/logo/' . ($entryPoint->logo??'default.jpeg')) }}" style="width: 50px; border-radius: 24px;" alt="profile Picture"></td>
                            <td>
                                <div class="badge bg-primary text-white rounded-pill">Active</div>
                            </td>
                            <td>
                                <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                                    <li><a class="dropdown-item" href="#">View</a></li>
                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                </ul> -->
                                <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="confirmDelete('{{ route('entrypoints.destroy', $entryPoint->id) }}', '{{ $entryPoint->id }}')" ><i class="fa-regular fa-trash-can"></i></button>
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