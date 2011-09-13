<?php
$SEARCHBY = $_GET["s"];
$KEYWORD = $_GET["k"];
$LANGUAGE = $_GET["l"];
$FROM_YEAR = $_GET["f"];
$TO_YEAR = $_GET["t"];
$URL = $_GET["u"];
$JS = $_GET["js"];

$html = file_get_contents($URL);
$extra = <<<EOD
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8">
        $(function() {
            var f = $JS;
            f("$SEARCHBY", "$KEYWORD", "$LANGUAGE", "$FROM_YEAR", "$TO_YEAR");
        });
	</script>
EOD;

// get domain (http://asdas.com/)
$idx = stripos($URL, '/', 7);
$domain = substr($URL, 0, $idx);

// ensure form url is absolute
$html = str_replace('action="/', 'action="'.$domain.'/', $html);
$html = str_replace('./wxis.php', $domain.'/wxis.php', $html);
$html = str_replace('/search-all.html', $domain.'/search-all.html', $html);
$html = str_replace('?mo=', 'http://www.librosar.com.ar/librosar/?mo=', $html);

// hack to remove google maps js
$html = str_replace('http://maps.google.com', '', $html);

// inject javascript
$html = str_replace('</body>', $extra.'</body>', $html);

// return HTML
echo $html;
?>