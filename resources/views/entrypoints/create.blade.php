@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-8">
                <!-- Change password card-->
                <div class="card mb-4">
                    <div class="card-header">Add Entry Points</div>
                    <div class="card-body">
                        <form action="{{route('entrypoints.store')}}" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event, this, 1)" autocomplete="off">
                            <!-- Form Group (current password)-->
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Name <span style="color: red;">*</span></label>
                                <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name of Entry point" />
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="district">District <span style="color: red;">*</span></label>
                                <select class="form-control" id="district" name="district">
                                    <option>Chose District</option>
                                    <option value="Muzaffarabad">Muzaffarabad</option>
                                    <option value="Mirpur">Mirpur</option>
                                    <option value="Rawalakot">Rawalakot</option>
                                    <option value="Bhimber">Bhimber</option>
                                    <option value="Kotli">Kotli</option>
                                    <option value="Poonch">Poonch</option>
                                    <option value="Bagh">Bagh</option>
                                    <option value="Hattian Bala">Hattian Bala</option>
                                    <option value="Neelum">Neelum</option>
                                    <option value="Haveli">Haveli</option>
                                    <option value="Sudhnoti">Sudhnoti</option>
                                </select>
                            </div>
                            <!-- Upload input field -->
                            <div class="mb-3">
                                <label for="profile_picture">logo </label>
                                <input class="form-control" type="file" name="logo" id="logo" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="latlong">Lat Long</label>
                                <input class="form-control" id="latlong" type="text" name="latlong" placeholder="Enter lat long e.g: 73.755577, 33.512989" />
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="descrption">Remarks</label>
                                <input class="form-control" id="descrption" type="text" name="descrption" placeholder="" />
                            </div>        
                            <!-- Form Group (confirm password)-->
                            <button type="submit" class="btn btn-primary" type="button">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Upload Logo</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" id="profile-image" src="{{asset('images/logo/default.jpeg')}}" alt="" />
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                        <button class="btn btn-primary" onclick="document.getElementById('logo').click()" type="button">Upload new image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')

@endsection