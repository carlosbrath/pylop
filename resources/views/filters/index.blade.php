@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Premises Filters</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('premises.list') }}">
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="district" class="form-label">District</label>
                <select class="form-control" id="district" name="district">
                    <option value="">Select District</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tehsil" class="form-label">Tehsil</label>
                <select class="form-control" id="tehsil" name="tehsil" disabled>
                    <option value="">Select Tehsil</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="council" class="form-label">Council</label>
                <select class="form-control" id="council" name="council" disabled>
                    <option value="">Select Council</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="village" class="form-label">Village</label>
                <select class="form-control" id="village" name="village" disabled>
                    <option value="">Select Village</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('filters.index') }}" class="btn btn-secondary">Clear</a>
    </form>
</div>

<script>
document.getElementById('district').addEventListener('change', function() {
    var districtId = this.value;
    var tehsilSelect = document.getElementById('tehsil');
    var councilSelect = document.getElementById('council');
    var villageSelect = document.getElementById('village');
    tehsilSelect.disabled = true;
    councilSelect.disabled = true;
    villageSelect.disabled = true;
    tehsilSelect.innerHTML = '<option value="">Select Tehsil</option>';
    councilSelect.innerHTML = '<option value="">Select Council</option>';
    villageSelect.innerHTML = '<option value="">Select Village</option>';

    if (districtId) {
        fetch(`/filters/tehsils/${districtId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(tehsil => {
                    var option = document.createElement('option');
                    option.value = tehsil.id;
                    option.text = tehsil.tehsil_name;
                    tehsilSelect.add(option);
                });
                tehsilSelect.disabled = false;
            });
    }
});

document.getElementById('tehsil').addEventListener('change', function() {
    var tehsilId = this.value;
    var councilSelect = document.getElementById('council');
    var villageSelect = document.getElementById('village');
    councilSelect.disabled = true;
    villageSelect.disabled = true;
    councilSelect.innerHTML = '<option value="">Select Council</option>';
    villageSelect.innerHTML = '<option value="">Select Village</option>';

    if (tehsilId) {
        fetch(`/filters/councils/${tehsilId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(council => {
                    var option = document.createElement('option');
                    option.value = council.id;
                    option.text = council.council_name;
                    councilSelect.add(option);
                });
                councilSelect.disabled = false;
            });
    }
});

document.getElementById('council').addEventListener('change', function() {
    var councilId = this.value;
    var villageSelect = document.getElementById('village');
    villageSelect.disabled = true;
    villageSelect.innerHTML = '<option value="">Select Village</option>';

    if (councilId) {
        fetch(`/filters/villages/${councilId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(village => {
                    var option = document.createElement('option');
                    option.value = village.id;
                    option.text = village.village_name;
                    villageSelect.add(option);
                });
                villageSelect.disabled = false;
            });
    }
});
</script>
@endsection
