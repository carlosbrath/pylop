@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <main>
        @include('include.page_header')
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <hr class="mt-0 mb-4" />
            <!-- Display success message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-8">
                    <!-- Change password card-->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <!-- Left side: User icon and Profile title -->
                            <div class="d-flex align-items-center">
                                <i data-feather="user" class="me-2"></i>
                                <span>Profile</span>
                            </div>

                            <!-- Right side: Edit and Delete buttons -->
                            <div class="" role="group">
                                <a type="button" href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip"
                                    data-placement="top" title="Edit Profile">
                                    <i data-feather="edit-2"></i>
                                </a>
                                <button type="button" data-href="{{ route('user.destroy', $user->id) }}" class="btn btn-sm btn-outline-danger delete-btn" data-toggle="tooltip"
                                    data-placement="top" title="Delete Profile">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
                                onsubmit="validateForm(event, this, 1)" autocomplete="off">
                                <!-- Form Group (current password)-->
                                @csrf
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="name">Name</label>
                                        <input class="form-control" id="name" type="text" name="name"
                                            value="{{ $user->name }}" readonly />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="email">Email</label>
                                        <input class="form-control" id="email" type="email" name="email"
                                            value="{{ $user->email }}" readonly />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="role">Role</label>
                                        <input class="form-control" id="role" type="text" name="role"
                                            value="{{ $user->role->title }}" readonly />
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>

@endsection

@section('scripts')
    <script></script>
@endsection
