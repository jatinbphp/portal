@if($section_name!='service-providers-fees' && $section_name!='service-provider-assign')

    @if (!in_array(Auth::user()->role, ['controllers']) && !isset($login_user))
        <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit" class="btn btn-sm btn-info tip ">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    @if (in_array(Auth::user()->role, ['controllers']))
        @if($status!='open')
            <a href="{{ url('admin/'.$section_name.'/'.$id.'/claimed') }}" title="Edit" class="btn btn-sm btn-info tip w-100">
                <i class="fa fa-edit"></i> Edit
            </a>
        @else  
            <button class="btn btn-sm btn-success claim-by-me w-100" data-section="{{$section_name}}_table" data-id="{{$id}}" data-url="{{route('controller.call-outs.claim')}}" type="button" title="Claim">
                <i class="fa fa-exchange-alt"></i> Claim
            </button>
        @endif
    @endif

    @if($section_name!='roles')
        @if(Auth::user()->role=='super_admin')
            <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table" title="Delete">
                <i class="fa fa-trash"></i>
            </button>
        @endif
    @endif

    @if(!in_array(Auth::user()->role, ['controllers']) && $show === True)
        <a href="javascript:void(0)" title="View" data-id="{{$id}}" class="btn btn-sm btn-warning tip  view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
            <i class="fa fa-eye"></i>
        </a>
    @endif
@elseif($section_name=='service-provider-assign')
    
    @if($callout->assigned_branch_id==$id)
        <button class="btn btn-sm btn-success w-100" type="button" title="Assigned">
            Assigned
        </button>
    @else 
        <button class="btn btn-sm btn-primary assign-by-controller w-100" data-section="{{$section_name}}_table" data-account_id="{{$account_id}}" data-id="{{$id}}" data-calloutsid="{{$callout->id}}" data-url="{{route('controller.call-outs.assign')}}" type="button" title="Assign">
            Assign
        </button>
    @endif
@else 

    <button class="btn btn-sm btn-info tip update-price" data-toggle="tooltip" data-sp_id="{{$id}}" title="Update Price" data-trigger="hover" type="button">
        <i class="fa fa-edit"></i>
    </button>

@endif