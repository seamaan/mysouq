<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
    {{trans('lang.flag')}}
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{trans('lang.flag')}}</h4>
            </div>
            <div class="modal-body">
                @for($i=2; $i < count(scandir(FLAGS_PATH));$i++)
                    <label  for="lang-{{$i}}" id="flag" class="btn btn-default flag">
                        <img src="{{FLAGS_URL.scandir(FLAGS_PATH)[$i]}}" alt="{{scandir(FLAGS_PATH)[$i]}}" title="{{scandir(FLAGS_PATH)[$i]}}">
                    </label>
                    <input  value="{{scandir(FLAGS_PATH)[$i]}}" class="hidden flag-input" name="flag" type="radio" id="lang-{{$i}}" >
                @endfor

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{trans('lang.continue')}}</button>
            </div>
        </div>
    </div>
</div>

@push('jas')
<script>
    $(document).on('click','label.flag',function (e) {
        $('label.flag').addClass('btn-default').removeClass('btn-primary');
        $(this).removeClass('btn-default').addClass('btn-primary');
    })
</script>
@endpush