<script type="text/javascript">

<?php
  $key = $Page->key();
  echo "var key = '{$key}';";
?>

if ( typeof $(".right").html() != "undefined" ) {

	var next = $(".right").html();
	var nextnew = '<li class="right">' + next.slice(0, 10) + key + next.slice(10) + '</li>';

	$( ".right" ).replaceWith( nextnew );

}

if ( typeof $(".left").html() != "undefined" ) {

	var prev = $(".left").html();
	var prevnew = prev.slice(0, 10) + key + prev.slice(10);


	$( ".left" ).replaceWith( "<li class=\"left\">" + prevnew + "</li>" );

}

</script>
