@extends('layouts.master')

@section('title', $page_title ?? 'Activity Log Details')

@section('content')
<main>
    @include('include.page_header')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4" />

        <div class="row">
            <!-- Left Column - Activity Details -->
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>User:</strong></td>
                                    <td>{{ $log->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Action:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst($log->action) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Model:</strong></td>
                                    <td>{{ $log->model }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Model ID:</strong></td>
                                    <td>{{ $log->model_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $log->created_at->format('d-m-Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <a href="{{ route('activitylogs.index') }}" class="btn btn-sm btn-secondary">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Changes and Meta Info -->
            <div class="col-lg-7">
                <!-- Changes Section -->
                @php
                    $changes = is_string($log->changes) ? json_decode($log->changes, true) : $log->changes;
                @endphp

                @if($changes)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Changes</strong>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; padding: 15px; border-radius: 4px;">{{ json_encode($changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                </div>
                @endif

                <!-- Meta Info Section -->
                @php
                    $metaInfo = is_string($log->meta_info) ? json_decode($log->meta_info, true) : $log->meta_info;
                @endphp

                @if($metaInfo)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Meta Info</strong>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; padding: 15px; border-radius: 4px;">{{ json_encode($metaInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

</main>

@endsection
