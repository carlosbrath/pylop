@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-12">
                <!-- Security preferences card-->
                <div class="card card-header-actions mb-4">
                    <div class="card-header">
                        News
                        <a href="{{route('news.create')}}" class="btn btn-outline-teal">Add News</a>
                    </div>
                    <div class="card-body">
                        <!-- Styled timeline component example -->


                        <div class="timeline">
                            @foreach($news as $n)
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-text">{{ $n->created_at->format('d/m/Y') }}</div>
                                    <div class="timeline-item-marker-indicator bg-primary-soft text-primary"><i data-feather="send"></i></div>
                                </div>
                                <div class="timeline-item-content pt-0">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h5 class="text-warning">{{$n->title}}</h5>
                                            {{$n->body}}
                                            <br>
                                            @if($n->link)
                                            <a href="{{$n->link}}">Read more</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

@endsection