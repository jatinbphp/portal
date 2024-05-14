<div class="">
    <div class="fileError">
        {!! Form::file($fieldName, ['class' => '', 'id'=> $fieldName, 'accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
    </div>
    
    @if(!empty($image) && file_exists($image))
        <img src="{{ asset($image) }}" alt="Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
    @else
        <img src="{{ url('assets/admin/dist/img/no-image.png') }}" alt="Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
    @endif
    
    @include('admin.common.errors', ['field' => $fieldName])
</div>
