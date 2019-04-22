<html>

<head>
    <title>pop up</title>

</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<select name="ddlNames" id="ddlNames">
    <option value="Mudassar Khan">Mudassar Khan</option>
    <option value="John Hammond">John Hammond</option>
    <option value="Mike Stanley">Mike Stanley</option>
</select>
<br>
@for($i=0;$i<5;$i++)
<input type="checkbox" class="form-control chk" value="{{$i}}" name="image[]" id="chk{{$i}}">{{$i}} image<br>
@endfor
<br />
<br />
<input type="button" value="Select" onclick="SetName();" />
<script type="text/javascript">
    function SetName() {
        if (window.opener != null && !window.opener.closed) {
            var txtName = window.opener.document.getElementById("txtName");
            var checkedValue = '';
            var cboxes = document.getElementsByName('image[]');
            var len = cboxes.length;
            for (var i=0; i<len; i++) {
                if(cboxes[i].checked){
                    checkedValue += cboxes[i].value+",";
                }
            }

            txtName.value = checkedValue;
            //txtName.value = document.getElementById("chk").value+',';
        }
        window.close();
    }
</script>
</body>

</html>