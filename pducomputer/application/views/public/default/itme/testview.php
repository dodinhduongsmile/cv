<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <meta name='robots' content='noindex,nofollow'/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php if (!empty($SEO)): ?>
    <title><?php echo !empty($SEO['title']) ? $SEO['title'] : $SEO['meta_title']; ?></title>

    <?php else: ?>
        <title><?php echo isset($this->_settings->meta_title) ? $this->_settings->meta_title : ''; ?></title>

    <?php endif; ?>
    <script>
        var urlCurrentMenu = window.location.href,
        urlCurrent = window.location.href,
        segment = '<?php echo base_url($this->uri->segment(1)) ?>',
        base_url = '<?php echo base_url(); ?>',
        media_url = '<?php echo MEDIA_URL . '/'; ?>',
        csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name') ?>',
        csrf_token_name = '<?php echo $this->security->get_csrf_token_name() ?>',
        csrf_token_hash = '<?php echo $this->security->get_csrf_hash() ?>';
    </script>
    <link rel='stylesheet' href="<?php echo base_url().'/public/css/style.css'; ?>"  />
    <script src="<?php echo base_url().'/public/js/jquery.min.js'; ?>" type='text/javascript'></script>
</head>
<body>
    <div class="edudetail">
        <div class="container">
<div class="list-video section-video">
      <div class="table-responsive">

       <div class="iframe_video">
          <!-- <iframe class="embed-responsive-item video-iframe" src="https://drive.google.com/file/d/1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k/preview" allowfullscreen=""></iframe> -->
      </div> 
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
            <tr>
                <td>1</td>
                <td><h3>1 bán hàng shopee</h3></td>
                
                <td class="load_video_pdusoft" data-video="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><h4><a href="/1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee" rel="nofollow">Xem ngay</a></h4></td>
                
                <td class="downloadpdu" data-downloadpdu="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><a href="#downloadpdu_1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee">Download</a></td>
            </tr>
            <!-- nếu là folder -->
            <tr>
                <td>2</td>
                <td colspan="3" class="collapsible">
                    <h3 class="collapsible-item--title">Công việc cần làm</h3>
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
                                <tr>
                                    <td>1</td>
                                    <td><h3>1 bán hàng shopee</h3></td>
                                    
                                    <td class="load_video_pdusoft" data-video="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><h4><a href="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee" rel="nofollow">Xem ngay</a></h4></td>
                                    
                                    <td class="downloadpdu" data-downloadpdu="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><a href="#downloadpdu_1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee">Download</a></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><h3>1 bán hàng shopee</h3></td>
                                    
                                    <td class="load_video_pdusoft" data-video="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><h4><a href="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee" rel="nofollow">Xem ngay</a></h4></td>
                                    
                                    <td class="downloadpdu" data-downloadpdu="1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k"><a href="#downloadpdu_1jew997iogQz02x5SoKqA-m1ASEp3XQATXgEiru9jt4k" title="1 bán hàng shopee">Download</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                
                
            </tr>
            <!-- nếu là folder -->
            <tr>
                <td>3</td>
                <td><h3>chương 8</h3></td>
                
                <td class="load_video_pdusoft" data-video="1Edub9oXK4UXlfYzhBekpBIG2SD416KFN"><h4><a href="1Edub9oXK4UXlfYzhBekpBIG2SD416KFN" title="chương 8">Xem ngay</a></h4></td>
                
                <td class="downloadpdu" data-downloadpdu="1Edub9oXK4UXlfYzhBekpBIG2SD416KFN"><a href="#downloadpdu_1Edub9oXK4UXlfYzhBekpBIG2SD416KFN" title="chương 8">Download</a></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
        </div>
    </div>

<script>
    $('.load_video_pdusoft').on('click', function (event) {
        event.preventDefault();
        $('table tr').removeClass('current');
        $(this).closest('tr').addClass('current');
        let videoId = $(this).data('video');
        $('.video-iframe').attr('src', 'https://drive.google.com/file/d/' + videoId + '/preview');
        $("html, body").animate({
            scrollTop: $(".section-video").offset().top - 150
        }, 600);
        //localStorage.setItem(videoId, true);
        return false;
    });

    $(".collapsible-item--title").click(function(a){
        $(this).toggleClass('active');
        $(this).parent().siblings()
        .children(".collapsible-item--title").removeClass("active")
        .end()
        .children(".collapsible-item--content").slideUp(500);
        $(this).siblings(".collapsible-item--content").slideToggle(500);
    });

</script>
<style>
    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }
    .table-bordered {
        border: 1px solid #ddd;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #ddd;
    }
    .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border-bottom-width: 2px;
    }

    table.video_pdusoft tbody>tr:hover {
        background: #dcd5d5;
    }
    
    table.video_pdusoft tbody tr td h3 a {
        text-decoration: none;
    }
    /*css new*/
    table tbody tr td h3 {
        padding: 0;
        margin: 0;
    }


    table.video_pdusoft .collapsible-item--content tbody>tr:hover {
        background: #4288bea1;
    }
    .collapsible-item--title:after {
    content: '\f077';
    font-family: 'FontAwesome';
    font-weight: 700;
    float: right;
    margin: 0;
    font-size: 14px;
}
h3.collapsible-item--title {
    padding: 5px 30px 5px 15px;
    cursor: pointer;
}
.collapsible-item--title:after {
    content: '\f077';
    font-family: 'FontAwesome';
    font-weight: 700;
    float: right;
    margin-top: 7px;
    font-size: 16px;
}
.collapsible-item--title.active:after {
    content: "\f078";
}
tr.current {
    background: #98ebd0;
    color: #f21010;
}
</style>
</body>
</html>
