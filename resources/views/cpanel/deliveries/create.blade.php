@extends('cpanel.index')
        @section('title'){{trans('lang.add',['var'=>trans('lang.delivery')])}}@endsection
        @section('menu') {!! getBreadcrumbs('delivery')->create !!} @endsection
        
@section('content')
        
            {!! bsForm::open(['title'=>trans('lang.add',['var'=>trans('lang.delivery')]),'route'=>'deliveries.store','files'=>true]) !!}
              {!! bsForm::translate(function($form){
                 $form->text('name');
                 })
             !!}
            {!! bsForm::text('mobile') !!}
            {!! bsForm::text('email') !!}
            @push('jas')
            <?php
            $lat = !empty(old('lat'))?old('lat'):'31.503969298027815';
            $lng = !empty(old('lng'))?old('lng'):'34.43491291999817';

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
            <input type="text" value="{{ $lat }}" id="lat" name="lat">
            <input type="text" value="{{ $lng }}" id="lng" name="lng">

            {!! bsForm::text('address',null,['id'=>'address']) !!}

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{trans('lang.price')}}
                    <button style="margin-left: 50px" class="btn btn-info btn-sm" type="button" id="addoption" name="append">
                        <i class="fa fa-plus"></i> {{trans('lang.price')}}
                    </button>

                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <div class="inc">

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
                               {!! Form::number("price[]") !!}{{site()->money_code}}\
                               {!! Form::label("cities", trans('lang.cities')) !!}\
                               {!! Form::select("city[]",$cities,'') !!}\
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
    </script>
@endsection

        