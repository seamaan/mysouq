@if (count($rows) > 0)
<ol class="dd-list ">
    @foreach($rows as $row)
    <li class="dd-item dd3-item" data-id="{{ $row->id }}">
    <div class="dd-handle dd3-handle" title="{{ trans('lang.order') }}"> </div>
        <div class="dd3-content" id="tr">
            <input form="delete_form" class="checkbox iCheck" type="checkbox" name="delete[]" value="{{$row->id}}">
            <div class="title_style" > <a href="{{url(cp.$name.'/'.$row->id)}}"> {{ $row->trans('name') }}</a></div>

            <div class="pull-right">

             {!! Btn::edit($row->id) !!}
            {!! Btn::delete($row->id,$row->name) !!}
            </div>
        </div>
        {!! \Process::orderHtml($name,$parentName,$row->id) !!}
    </li>
    @endforeach 
</ol>
@endif
