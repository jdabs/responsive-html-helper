# Responsive HTML Helper
Add the path to the old HTML document in the `$sourceurl` variable. Then visit html-helper.php in the browser. Right-click, view source and then copy and paste the newly formatted HTML into your working document.

The script does these things
- Makes sure you have an `<html>`, `<head>`, and `<body>` tag
- Adds the HTML5 doctype. If the document has the HTML 4.01 transitional doctype, it gets replaced. If there's no doctype, it is added before the `<html>` tag.
- Puts important responsive meta tags into the head section
- Converts all table related tags into divs. (For sites that used a table layout). The table tags still keep their inline styles, so you'll need to convert them into the equivalent CSS and remove them from the HTML yourself.

# Dependencies

- Simple DOM Parser http://simplehtmldom.sourceforge.net/
- PHP Tidy  http://php.net/manual/en/book.tidy.php
