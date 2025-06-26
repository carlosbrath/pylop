@extends('layouts.layout')

@section('title', 'Premesis')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Premises Listing</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Premises</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th>Province</th>
                                    <th>District</th>
                                    <th>Tehsil</th>
                                    <th>UC</th>
                                    <th>Village</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Quarantine Facility</th>
                                    <th>Nearby Hospital</th>
                                    <th>Vet Name</th>
                                    <th>Vet Contact</th>
                                    <th>Assistant Name</th>
                                    <th>Assistant Contact</th>
                                    <th>Address</th>
                                    <th>Is Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($premises as $premise)
                                <tr>
                                    <td>{{ $premise->id }}</td>
                                    <td>{{ $premise->name }}</td>
                                    <td>{{ $premise->user_id }}</td>
                                    <td>{{ $premise->province }}</td>
                                    <td>{{ $premise->district->district_name  }}</td>
                                    <td>{{ $premise->tehsil }}</td>
                                    <td>{{ $premise->uc }}</td>
                                    <td>{{ $premise->village }}</td>
                                    <td>{{ $premise->type }}</td>
                                    <td>{{ $premise->status }}</td>
                                    <td>{{ $premise->latitude }}</td>
                                    <td>{{ $premise->longitude }}</td>
                                    <td>{{ $premise->quarantine_facility }}</td>
                                    <td>{{ $premise->nearby_hospital }}</td>
                                    <td>{{ $premise->vet_name }}</td>
                                    <td>{{ $premise->vet_contact }}</td>
                                    <td>{{ $premise->assistant_name }}</td>
                                    <td>{{ $premise->assistant_contact }}</td>
                                    <td>{{ $premise->address }}</td>
                                    <td>{{ $premise->is_approved ? 'Yes' : 'No' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
