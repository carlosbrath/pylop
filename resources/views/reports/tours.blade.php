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
                <a href="" class="btn btn-outline-teal">Add New</a>
            </div>

            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Organizer Name</th>
                            <th>Organizer CNIC</th>
                            <th>Licence No</th>
                            <th>No Of Other</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Organizer Name</th>
                            <th>Organizer CNIC</th>
                            <th>Licence No</th>
                            <th>No Of Tourist</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($tours as $tour)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <th>{{$tour->organizer_name}}</th>
                            <th>{{$tour->organizer_cnic}}</th>
                            <th>{{$tour->licience_no}}</th>
                            <th>{{$tour->number_of_other_tourists}}</th>
                            <td>
                                @if( $tour->started==1 && $tour->finished==0)
                                    <div class="badge bg-info rounded-pill">Started</div>
                                @elseif($tour->finished==1)
                                    <div class="badge bg-primary text-white rounded-pill">Completed</div>
                                @elseif($tour->approved==0)
                                    <div class="badge bg-secondary text-white rounded-pill">Pending</div>
                                @endif
                            </td>
                            <td>
                                <!-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                                    <li><a class="dropdown-item" href="{{route('tour.show',  Crypt::encrypt($tour->id))}}">View</a></li>
                                </ul> -->
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{route('tour.show',  Crypt::encrypt($tour->id))}}"><i class="fa-regular fa-eye"></i></a>
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