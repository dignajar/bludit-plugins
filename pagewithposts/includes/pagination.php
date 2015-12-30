<script type="text/javascript">

<?php
$key = $Page->key();
echo "var key = '{$key}';";
?>

if ( typeof $(".right").html() != "undefined" ) {

var next = $(".right").html();
var n = next.indexOf("?page");
var nextnew = '<li class="right">' + next.slice(0, n) + key + next.slice(n) + '</li>';

$( ".right" ).replaceWith( nextnew );

}

if ( typeof $(".left").html() != "undefined" ) {

var prev = $(".left").html();
var m = prev.indexOf("?page");
var prevnew = prev.slice(0, m) + key + prev.slice(m);

$( ".left" ).replaceWith( "<li class=\"left\">" + prevnew + "</li>" );

}

</script>
