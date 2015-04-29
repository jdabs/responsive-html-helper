<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once('simple_html_dom.php'); // Get this from http://simplehtmldom.sourceforge.net/

$html = new simple_html_dom();
$sourceurl = "test-html.html"; // html file to parse goes here. Use a path relative to this script or any public page e.g. http://example.com

$html->load_file($sourceurl);

/* Taking care of the head section */

$needed_tags = array("html", "head", "body");

foreach($needed_tags as $value) {
	$check = $html->getElementByTagName($value);
	if(!$check) {
		echo "The document is missing the {$value} tag. Script has stopped.";
		die();
	}
}

$html->getElementByTagName('head')->innertext = '
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">'; // Taken from https://github.com/h5bp/html5-boilerplate/blob/master/src/index.html

// tags to look for

$loose_doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$html_tag = "<html>";
$table_tag = "<table";
$table_end = "</table>";
$tr_tag = "<tr";
$tr_end = "</tr>";
$td_tag = "<td";
$td_end = "</td>";

// tags that are swapped in

$doctype_only = "<!doctype html>\n";
$doctype = "<!doctype html>\n<html>\n";
$div = "<div";
$div_end = "</div>";

// search and replace

if(stristr($html, $loose_doctype) !== FALSE) {
	$doctyped_html = str_replace($loose_doctype,$doctype_only ,$html);
}else{
	$doctyped_html = str_replace($html_tag,$doctype,$html);
}

$doctyped_html = str_replace($table_tag,$div,$doctyped_html);
$doctyped_html = str_replace($table_end,$div_end,$doctyped_html);
$doctyped_html = str_replace($tr_tag,$div,$doctyped_html);
$doctyped_html = str_replace($tr_end,$div_end,$doctyped_html);
$doctyped_html = str_replace($td_tag,$div,$doctyped_html);
$doctyped_html = str_replace($td_end,$div_end,$doctyped_html);

// run tidy - http://php.net/manual/en/book.tidy.php

function html_tidy( $input_html, $indent = true, $no_body_tags = "true", $fix = "true" ) {
	ob_start(  );
	$tidy = new tidy;
	$config = array( 'indent' => $indent,  'output-xhtml' => false, 'wrap' => 200, 'clean' => $fix, 'show-body-only' => $no_body_tags );
	$tidy->parseString( $input_html, $config, 'utf8' );
	$tidy->cleanRepair(  );
	$input = $tidy;
	return $input;
}

// Visit html-helper.php in the browser. It will spit out the formated html. Right-click, view source, and copy and paste the html into your working document.

echo html_tidy($doctyped_html);

//clean up any leaking memory that parsing the dom creates

$html->clear();
unset($html);
unset($doctyped_html);

?>
