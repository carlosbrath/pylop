<div class="btn-group">


    <a href="{{ route('activitylogs.show', $row->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
    @if ($permissions === 'all')
        
    @endif
</div>
