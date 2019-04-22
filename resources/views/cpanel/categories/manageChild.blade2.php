@if(count ($department)>0 )
    <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
        <label for="{{ 'parent' }}" class="control-label">{{ trans('lang.'.trim('othermain_category','[]')) }}</label>
        <div class="input-icon right">
            @if($errors->has('parent'))
                <i class="fa fa-warning tooltips" data-original-title="{{ $errors->first('parent') }}"></i>
            @endif
            <select name="parent" class="form-control checkparent">
                <option master="master" value="{{$parent}}" @if($parent==old('parent')) selected @endif>{{trans('lang.none')}}</option>
                @foreach($department as $dep)
                    <option master="parentmaster" value="{{$dep->id}}" @if(old('parant')==$dep->id) selected @endif>{{$dep->name}}</option>
                @endforeach

            </select>

        </div>
    </div>
@endif
