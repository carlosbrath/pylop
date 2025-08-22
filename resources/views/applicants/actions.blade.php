
<a href="{{ route('applicant.show', $row->id) }}" 
   class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
    <i class="fa fa-eye"></i>
</a>

{{-- <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-solid fa-ellipsis-vertical"></i>
</button>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
    <li><a class="dropdown-item" href="{{ route('applicant.show', $row->id) }}">View</a></li>
</ul> --}}
