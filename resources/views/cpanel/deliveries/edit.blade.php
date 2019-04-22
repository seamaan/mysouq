@extends('cpanel.index')
@section('title')
    {{trans('lang.update',['var'=>$delivery->name])}}
@stop
@section('menu') {!! getBreadcrumbs('delivery',$delivery->id)->edit !!}  @endsection

@section('content')

    {!! bsForm::open(['title'=>trans('lang.update',['var'=>$delivery->name]),'route'=>['deliveries.update',$delivery->id],'method'=>'put','files'=>true]) !!}
    {!! bsForm::translate(function($form,$lang) use($delivery){
       $form->text('name',$delivery->trans('name',$lang));
       })
     !!}
    {!! bsForm::text('mobile',$delivery->mobile) !!}
    {!! bsForm::text('email',$delivery->email) !!}
    @push('jas')
    <?php
    $lat = !empty($delivery->lat)?$delivery->lat:'31.503969298027815';
    $lng = !empty($delivery->lng)?$delivery->lng:'34.43491291999817';
    ?>
    <script>
        $('#us1').locationpicker({
            location: {
                latitude: {{ $lat }},
                longitude:{{ $lng }}
            },
            radius: 300,
            markerIcon: '{{ url('public/cpanel/img/map-marker-2-xl.png') }}',
            inputBinding: {
                latitudeInput: $('#lat'),
                longitudeInput: $('#lng'),
                // radiusInput: $('#us2-radius'),
                locationNameInput: $('#address')
            }

        });
    </script>
    @endpush

    <div class="form-group">
        <div id="us1" style="width: 100%; height: 400px;"></div>
    </div>

    <input type="hidden" value="{{ $lat }}" id="lat" name="lat">
    <input type="hidden" value="{{ $lng }}" id="lng" name="lng">

    {!! bsForm::text('address',$delivery->address,['id'=>'address']) !!}
    {!! bsForm::image('deliveries',$delivery->id) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{trans('lang.prices')}}
            <button style="margin-left: 50px" class="btn btn-info btn-sm" type="button" id="addoption" name="append">
                <i class="fa fa-plus"></i> {{trans('lang.newoption')}}
            </button>

        </div>
        <div class="panel-body">

            <div class="control-group">
                <div class="inc">
                    <?php
                    $cities = \App\Address::pluck('name', 'id');
                    ?>
                    @foreach(DB::table('delivery_price')->where('delivery_id',$delivery->id)->get() as $row )
                        <div class="form-control delivery_price{{$row->id}}">
                            {!! Form::label("price", trans('lang.price'),['class'=>'']) !!}
                            {!! Form::text("price[]",$row->price) !!} {{site()->money_code}}
                            {!! Form::text("id[]",$row->id,['class'=>'hidden']) !!}
                            {!! Form::label("city", trans('lang.city'),['class'=>'']) !!}
                            {!! Form::select("city[]",$cities,\App\Address::find($row->city_id)->id) !!}
                            {!! Form::button('<i class="fa fa-remove"></i>',["class"=>"btn btn-danger btn-xs","type"=>"button","onclick"=>"deleteitem($row->id);"]) !!}
                            <i class="fa fa-spinner hidden fa-spin spin_del{{$row->id}}"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
@section('js')
    <script>
        jQuery(document).ready( function () {
            $("#addoption").click( function(e) {
                e.preventDefault();
                $(".inc").append('<div class="form-control">\
                               {!! Form::label("price", trans('lang.price'),['class'=>'']) !!}\
                               {!! Form::number("newprice[]") !!} {{site()->money_code}} \
                               {!! Form::label("cities", trans('lang.cities')) !!}\
                               {!! Form::select("newcity[]",$cities,'') !!}\
                               {!! Form::button('<i class="fa fa-remove"></i>',["class"=>"remove_this btn btn-danger btn-xs","type"=>"button"]) !!}\
                               </div>');

                return false;
            });

            jQuery(document).on('click', '.remove_this', function() {
                //jQuery(this).parent().remove();
                jQuery(this).parent().remove();
                return false;
            });
            $("input[type=submit]").click(function(e) {
                e.preventDefault();
                $(this).next("[name=textbox]")
                    .val(
                        $.map($(".inc :text"), function(el) {
                            return el.value
                        }).join(",\n")
                    )
            })
        });
        function deleteitem(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delivery.deleteprice') }}',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                data: {'id': id},
                beforeSend: function () {
                    $('.spin_del'+id).removeClass('hidden');

                },
                success: function (data) {
                    if (data != 'false') {
                        $('.delivery_price'+id).remove();
                    }
                    $('.spin_del'+id).addClass('hidden');
                }
            });
        }
    </script>
@endsection
