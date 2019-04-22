@php
$master=\App\Category::find($parent);
@endphp
@if($master->parent_id > 0 )
    @include('cpanel.categories.manageChild',['parent'=>$master->parent_id])
@endif
{{$master->trans('name')}}>


