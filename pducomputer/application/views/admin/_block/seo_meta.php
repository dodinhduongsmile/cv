<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $class = $this->router->fetch_class();
?>
<div class="form-group">
    <label>Tiêu đề SEO (Meta Title)</label>
    <label for="title"><span class="count-title">0</span> / <?php echo $this->config->item('SEO_title_maxlength') ?></label>
    <input name="meta_title" placeholder="Meta Title" class="form-control" type="text" />
</div>
<div class="form-group">
    <label>Đường dẫn (Url)</label>
    <input name="slug" placeholder="Link" class="form-control" type="text" />
</div>
<div class="form-group">
    <label>Mô tả SEO (Meta Description)</label>
    <label for="desc"><span class="count-desc">0</span> / <?php echo $this->config->item('SEO_description_maxlength') ?></label>
    <textarea name="meta_description" placeholder="Meta Description" class="form-control" rows="5" ></textarea>
</div>
<div class="form-group">
    <label>Meta Keyword</label>
    <input value="" name="meta_keyword" placeholder="Meta Keyword" class="form-control" data-role="tagsinput" type="text" />
</div>

<div class="google">
    <h2 class="cgg"><span class="gg_1">Google!</span></h2>
    <input type="text" class="gg-result" readOnly/>
    <div class="box">
        <h3 class="gg-title"></h3>
        <cite class="gg-url"></cite>
        <span class="gg-desc"></span>
    </div>
</div>
