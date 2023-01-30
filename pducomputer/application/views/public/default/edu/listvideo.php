
<?php if(!empty($listdrive)): ?>
<div class="list-video section-video">
  <div class="table-responsive">
<?php if($auth_useredu){ ?>
    <div class="iframe_video">
        <?php if($typevd == "yt"){ 
            parse_str($oneItem->link_youtube, $arr1);
            $key = array_keys($arr1);
        ?>
              <iframe class="embed-responsive-item video-iframe lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="//www.youtube.com/embed/?list=<?php echo $arr1[$key[0]]; ?>" allowfullscreen=""></iframe>
        <?php }else{ ?>
            <iframe class="embed-responsive-item video-iframe" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" allowfullscreen=""></iframe>
            <span id="boxchevd">
                <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->templates_assets.'images/logovideo.jpg'; ?>" alt="Hello baby" />
            </span>
        <?php }; ?>
        <div id="tenbaihoc">
            <h2 class="text_gra1"></h2>
            <div class="dasboard_head_action">
                <div class="box_action">
                    <button class="show_child"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <ul class="show_content clearfix boxmenu_item">
                        <li id="download_btn"><a href="#" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download</a></li>
                        <li class="share-facebook"><a href="https://www.facebook.com/sharer.php?u=<?php echo get_url_edu($oneItem); ?>" onclick="window.open(this.href, 'windowName', 'width=550, height=650, left=24, top=24, scrollbars, resizable'); return false;" rel='nofollow' title="Click to share on Facebook"><i class="fa fa-share" aria-hidden="true"></i>Share FB</a></li>
                        <li id="report_btn"><a href="#"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Báo Lỗi</a></li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <form id="note_edu" >
            <h3 class="collapsible-item--title text_gra1">Ghi chú khóa học</h3>
            <div class="collapsible-item--content" style="display: none;">
                <input type="hidden" name="edu_id" value="<?php echo $oneItem->id; ?>">
                <input type="hidden" name="title" value="<?php echo $oneItem->title; ?>">
                <input type="hidden" name="slug" value="<?php echo $oneItem->slug; ?>">
                <textarea name="content" class="form-control summernote">
                    <?php echo !empty($note->content)?$note->content:""; ?>
                </textarea>
                <button class="btn btnSaveNote" >Lưu lại</button>
            </div>
            
        </form>
  </div>
<?php }; ?>
  <h3 class="text_gra1">Danh Sách Bài Giảng</h3>
  <table class="table table-bordered video_pdusoft">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên bài</th>
            <th>Link học</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listdrive as $k => $v): ?>
        <!-- nếu là folder -->
        <?php if(!empty($v->child)): ?>
        <tr>
            <td><?php echo $k; ?></td>
            <td colspan="3" class="collapsible">
                <h3 class="collapsible-item--title"><?php echo $v->name; ?></h3>
                <div class="collapsible-item--content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên bài</th>
                                <th>Link học</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($v->child as $k2 => $v2): ?>
                            <tr>
                                <td><?php echo $k2; ?></td>
                                <td><h3><?php echo $v2->name; ?></h3></td>
                            <?php if(@$v2->mimeType != "application/vnd.google-apps.folder"){if($auth_useredu && $oneItem->type>0){
                            ?>
                                <td class="load_video_pdusoft" data-type="<?php echo $typevd; ?>" data-video="<?php echo $v2->id; ?>"><h4><a href="<?php echo $v2->id; ?>" title="<?php echo $v2->name; ?>" rel="nofollow">Xem ngay</a></h4></td>

                                <td class="downloadpdu" data-downloadpdu="<?php echo $v2->id; ?>"><a href="#downloadpdu_<?php echo $v2->id; ?>" title="<?php echo $v2->name; ?>">Download</a></td>
                            <?php }else{ ?>

                                    <td class=""><h4><a href="#No_Permission" title="No Permission" rel="nofollow">Xem ngay</a></h4></td>

                                    <td class=""><a href="#No_Permission" title="No Permission">Download</a></td>
                            <?php }}; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <?php else: ?>
        <tr>
            <td><?php echo $k; ?></td>
            <td><h3><?php echo $v->name; ?></h3></td>
            <?php if($auth_useredu && $oneItem->type > 0){ ?>
            <td class="load_video_pdusoft" data-type="<?php echo $typevd; ?>" data-video="<?php echo $v->id; ?>"><h4><a href="/<?php echo $v->id; ?>" title="<?php echo $v->name; ?>" rel="nofollow">Xem ngay</a></h4></td>

            <td class="downloadpdu" data-downloadpdu="<?php echo $v->id; ?>"><a href="#downloadpdu_<?php echo $v->id; ?>" title="<?php echo $v->name; ?>">Download</a></td>
            <?php }else{ ?>

                <td class=""><h4><a href="#No_Permission" title="No Permission" rel="nofollow">Xem ngay</a></h4></td>

                <td class=""><a href="#No_Permission" title="No Permission">Download</a></td>
            <?php }; ?>
        </tr>
    <?php endif; ?>
        <!-- nếu là folder -->
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
<div class="catesame serverpdu" data-id="<?php echo $oneItem->id; ?>">
  <strong>Server:</strong>
  <a class="tag-item" href="<?php echo get_url_edu($oneItem); ?>" data-server="1" onclick="transfer_server(this);">#Server1</a>
  <a class="tag-item" href="<?php echo get_url_edu($oneItem)."/?server=2"; ?>" data-server="2" onclick="transfer_server(this);">#Server2</a>
</div>
<?php if($auth_useredu){ ?>
<link rel='stylesheet' href="<?php echo $this->templates_assets.'summernote/summernote-lite.min.css'; ?>"  />
<script src="<?php echo $this->templates_assets.'summernote/summernote-lite.min.js'; ?>" type='text/javascript'></script>
<script>
jQuery(document).ready(function($) {
    $('.summernote').summernote({
            height: 100,
        /*toolbar: false,*/
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]/*codeview*/
        ],
        callbacks: {
            onImageUpload: function(image) {
              uploadImage(image);
        }
      }
  });

});
</script>
<?php }; ?>

<?php else: ?>
<p>Data updating...</p>
<div class="catesame serverpdu" data-id="<?php echo $oneItem->id; ?>">
  <strong>Server:</strong>
  <a class="tag-item" href="<?php echo get_url_edu($oneItem); ?>" data-server="1" onclick="transfer_server(this);">#Server1</a>
  <a class="tag-item" href="<?php echo get_url_edu($oneItem)."/?server=2"; ?>" data-server="2" onclick="transfer_server(this);">#Server2</a>
</div>
<?php endif; ?>