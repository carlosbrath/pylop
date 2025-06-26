@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

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
                    <div class="card-header">Add Notifications</div>
                    <div class="card-body">
                        <form action="{{route('news.store')}}" method="POST">
                            <!-- Form Group (current password)-->
                             @csrf
                             @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="small mb-1" for="title">Title</label>
                                <input class="form-control" id="title" type="name" name="title" placeholder="Enter Title Of News" />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                           
                            <!-- Form Group (new password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="newPassword">Short Descrption</label>
                                <textarea class="form-control" name="body" id="body"></textarea>
                                @error('body')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="link">Link</label>
                                <input class="form-control" id="link" type="text" name="link" placeholder="Paste The Link of News" />
                                @error('link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (confirm password)-->
                            <button type="submit" class="btn btn-primary" type="button">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection