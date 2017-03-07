
<?php
$this->registerCss('
img{
        max-width: 300px;
        max-height: 200px;
    }
');
?>

<div class="gallerys" style="margin-top: 20px;">
    <img class="gallery-pic" src="/images/zdx/51_14828300304372.jpg" onclick="$.openPhotoGallery(this)" />
    <img class="gallery-pic" src="/images/zdx/51_14828300484625.jpg" onclick="$.openPhotoGallery(this)" />
    <img class="gallery-pic" src="/images/zdx/51_14828300532488.jpg" onclick="$.openPhotoGallery(this)" />
</div>

<script src="/js/jquery-photo-gallery/jquery.js"></script>
<script src="/js/jquery-photo-gallery/jquery.photo.gallery.js"></script>