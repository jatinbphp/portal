<a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit" class="btn btn-sm btn-info tip">
    <i class="fa fa-edit"></i>
</a>

<button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table" title="Delete">
    <i class="fa fa-trash"></i>
</button>

<a href="javascript:void(0)" title="View" data-id="{{$id}}" class="btn btn-sm btn-warning tip  view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
    <i class="fa fa-eye"></i>
</a>