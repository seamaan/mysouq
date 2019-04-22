<?php
if(!empty($albumid)){
    $album=\App\Album::find($albumid);
    $path=base_path("public/uploads").'/'.$album->name.'/thumb';
    $tblname=!empty($name)? str_singular($name):'';
    $name=$album->name;
    $albumid=$album->id;
}
if(is_dir($path)){
$files = File::allFiles($path);
?>
<form action= "" id ="overlay_form" method= "post">

@foreach ($files as $file)
        <?php
        $filename = $file->getRelativePathName();
        $path=$name.'/thumb/'.$filename;
        ?>
            <input type="hidden" name="albumname" value="{{$name}}">
            <label  for="image-{{$filename}}" id="flag" class="btn btn-default flag" style="height: 90px;width: 120px;margin-bottom: 3px">
            <img src="{{url('/public/uploads/'.$path)}}" class="thumbnail">
            </label>
            <input  value="{{$path}}" name="image[]" class="hidden flag-input" type="checkbox" id="image-{{$filename}}" >
    @endforeach
</form>
<?php
}else{
    echo 'err';
    }
?>
<script type="text/javascript">
    function SetName() {
        if (window.opener != null && !window.opener.closed) {
            var txtName = window.opener.document.getElementById("txtName");
            var imgdiv=window.opener.document.getElementById("images");
            var checkedValue = '';
            var url='{{url('/public/uploads')}}/';
            var datahtml = '';
            var cboxes = document.getElementsByName('image[]');
            var len = cboxes.length;
            for (var i=0; i<len; i++) {
                if(cboxes[i].checked){
                    checkedValue += '/public/uploads/'+cboxes[i].value+",";
                    datahtml +="<div class='thumbnail' id='thumb"+i+"' style='position: relative' ><img src="+url+cboxes[i].value+" style='width: 150px;'>";
                    datahtml +="<button class='btn btn-danger btn-xs delete' onclick=removeimgurl('thumb"+i+"','/public/uploads/"+cboxes[i].value+",') type='button'><i class='fa fa-close'></i></button>";
                    datahtml +="<input type='radio' checked name='default' class='default'  value='/public/uploads/"+cboxes[i].value+"'>";
                    datahtml +="</div>";
                }
            }
            txtName.value='';
            txtName.value = checkedValue;
            imgdiv.innerHTML = datahtml;
            //txtName.value = document.getElementById("chk").value+',';
        }
        window.close();
    }
    function deletsetlect() {
        var cboxes = document.getElementsByName('image[]');
        var albumid = "{{$albumid}}";
        var token=$('#token').val();
        var checkedValue = '';
        var len = cboxes.length;
        for (var i=0; i<len; i++) {
            if(cboxes[i].checked){
                checkedValue += cboxes[i].value+",";

            }
        }
        $.ajax({
            type: 'POST',
            url: '{{ url('cpanel/photo/deleteImg') }}',
            dataType:'json',
            data: {'filename': checkedValue,_token:token,'albumid':albumid},
            beforeSend:function () {
                $('.spin_del').removeClass('hidden');
            },
            success: function (data) {
                if(data !='false')
                {
                    $('.result').empty();
                    $('.result').prepend(data);
                    $('.choos').addClass('hidden');
                }else{
                    console.log('no data')
                }
                $('.spin_del').addClass('hidden');
            }
        });

    }

</script>