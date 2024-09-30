
@if ($entry->is_activated !== 1)
    <a href="{{ url('admin/voter/activate/' . $entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="update">
        <span><i class="la la-edit"></i> Approve </span>
    </a>
@else
    <a href="javascript:void(0)" class="btn btn-sm btn-link" data-button-type="update">
        <span><i class="la la-edit"></i> Approved </span>
    </a>
@endif
    