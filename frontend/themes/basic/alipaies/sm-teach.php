<?php
$this->registerCss("

.pdfobject-container { height: 500px;}
.pdfobject { border: 1px solid #666; }

");

?>

<script src="/js/pdfobject.min.js"></script>

<div id="example1"></div>
<script>PDFObject.embed("/video/sm_teach.pdf", "#example1");</script>
