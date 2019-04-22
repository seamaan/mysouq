<html>
<head>
    <title>Main</title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            Name:&nbsp;
        </td>
        <td>
            <input type="text" id="txtName" readonly="readonly" />
        </td>
        <td>
            <input type="button" value="Select Name" onclick="SelectName()" />
        </td>
    </tr>
</table>
<script type="text/javascript">
    var popup;
    function SelectName() {
        popup = window.open("{{url('cpanel/popup')}}", "Popup", "width=300,height=100");
        popup.focus();
    }
</script>

</body>
</html