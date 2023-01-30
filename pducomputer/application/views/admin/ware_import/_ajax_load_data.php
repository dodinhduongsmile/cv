<?php 
if(!empty($listdata)){
    foreach($listdata as $item){
?>

<li class="search_item" data-id="<?php echo $item->id; ?>">
    <img src="<?php echo MEDIA_URL.$item->thumbnail; ?>" alt="<?php echo $item->title; ?>">
    <div>
        <h3><?php echo $item->title; ?></h3>
        <p>giá nhập: <?php echo $item->price; ?></p>
    </div>
    <p>code: <?php echo $item->code; ?></p>
</li>
<?php
    }
}
?>