@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        @include('include.activitymap')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Change password card-->
                <div class="card mb-4">
                    <div class="card-header">Tourist Details</div>
                    <div class="card-body">
                        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event, this, 1)" autocomplete="off">
                            <!-- Form Group (current password)-->
                            @csrf
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="Name">Tourist Name</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" Value="{{$tour->organizer_name}}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Tourist Cnic</label>
                                    <input class="form-control" id="email" type="text" name="email" placeholder="Enter Name" Value="{{$tour->organizer_cnic}}" readonly />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1">Tourist From</label>
                                    <input class="form-control" placeholder="Enter Name" Value="{{$tour->city}}" readonly readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="district">Tourist Destination</label>
                                    <input class="form-control" placeholder="Enter Name" Value="{{$tour->destination}}" readonly />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="district">Vehical Type</label>
                                    <input class="form-control" placeholder="Enter Name" Value="{{$tour->vehicl_type}}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Vehical Number</label>
                                    <input class="form-control" placeholder="Enter Name" Value="{{$tour->vehicle_number}}" readonly />
                                </div>

                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <h3>Other Tourists</h3>
                                </div>
                            </div>
                            <hr class="mt-0 mb-4" readonly />
                            @foreach($tour->tourists as $t)
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="Name">Name</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" Value="{{$t->name}}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Tourist Cnic</label>
                                    <input class="form-control" id="email" type="text" name="email" placeholder="Enter Name" Value="{{$t->cnic}}" readonly />
                                </div>
                            </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

</main>

@endsection