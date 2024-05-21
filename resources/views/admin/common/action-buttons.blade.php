@if(isset($edit) && $edit === true)
    <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit" class="btn btn-sm btn-info tip">
        <i class="fa fa-edit"></i>
    </a>
@endif

@if(isset($delete) && $delete === true)
    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table" title="Delete">
        <i class="fa fa-trash"></i>
    </button>
@endif

@if(isset($view) && $view === true)
    <a href="javascript:void(0)" title="View" data-id="{{$id}}" class="btn btn-sm btn-warning tip  view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
        <i class="fa fa-eye"></i>
    </a>
@endif

@if(isset($popup_edit) && $popup_edit === true)
    <a href="javascript:void(0)" title="View" data-id="{{$id}}" class="btn btn-sm btn-info tip  view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
        <i class="fa fa-edit"></i>
    </a>
@endif

@if(isset($add) && $add === true)
    <a href="{{ route($section_name.'.create', ['id' => $id]) }}" title="Add" data-id="{{$id}}" class="btn btn-sm btn-primary tip add {{ $section_name ?? '' }}" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
        <i class="fa fa-plus"></i>
    </a>
@endif

@if(isset($listing) && $listing === true)
    <a href="{{ url('admin/'.$section_name.'/'.$id.'/tasks') }}" title="Listing" class="btn btn-sm btn-info tip">
        <i class="fa fa-list"></i>
    </a>
@endif