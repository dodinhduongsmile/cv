<div class="container">
    <div class="content_container bg-white p-3">
        <div class="mn_dh mb-3">
            <div class="d-flex align-items-center">
                <a class="hot" href="/"><strong>Home:</strong></a>
                <h1 class="mb-0 ml-3">
                    Tuviso.COM - RSS
                </h1>
            </div>
        </div>

        <div class="ct_noidung">
            <p>
                <b>RSS là gì ?</b>
            </p>
            <p>
                RSS (Really Simple Syndication) là một chuẩn tựa XML được rút gọn dành cho việc phân tán và khai thác nội dung thông tin Web (ví dụ như các tiêu đề tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các liên kết tin tức, tiêu đề, ảnh và tóm tắt
            </p>
            <p><b>Tử vi số cung cấp những kênh thông tin RSS sau:</b></p>
            <?php if (!empty($allCate)):?>
            <table width="100%" border="1" bordercolor="#ccc" cellpadding="4" style="border-color:#ccc; border-collapse:collapse;">
                <ul class="rss-list">
<!--                    --><?php //$remove = [4,7,6,133355,141657]?>
                    <?php foreach ($allCate as $k=>$cate):?>
<!--                    --><?php //if (in_array($cate->term_id,$remove)) continue?>
                    <li class="my-2 pr-2">
                        <img src="https://bongda24h.vn/images/rss_button.gif" alt="rss">
                        <a href="/rss/<?php echo $cate->slug?>.rss" style="color:#0b679c; font-size:14px; font-weight:bold;">RSS <?php echo $cate->title?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </table>
            <?php endif?>

            <p><b>Các giới hạn sử dụng</b></p>
            <p>Các nguồn kênh tin được cung cấp miễn phí cho các cá nhân và các tổ chức phi lợi nhuận. Chúng tôi yêu cầu bạn cung cấp rõ các thông tin cần thiết khi bạn sử dụng các nguồn kênh tin này từ Tử vi số</p>
            <p>Tử vi số hoàn toàn có quyền yêu cầu bạn ngừng cung cấp và phân tán thông tin dưới dạng này ở bất kỳ thời điểm nào và với bất kỳ lý do nào.</p>
        </div>
    </div>
</div>