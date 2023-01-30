
<?php if(!empty($listvd)): 
?>
<textarea type="text" id="myInput_<?php echo $typevd; ?>"></textarea>
<div class="tooltip">
    <button onclick="myFunction_<?php echo $typevd; ?>()" onmouseout="outFunc_<?php echo $typevd; ?>()">
      <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
      Copy text
    </button>
</div>
<div id="copy_<?php echo $typevd; ?>">
<div class="list-video section-video">
      <div class="table-responsive">

<?php
if(!empty($linklist)):
?>
 <div class="iframe_video">
      <iframe class="embed-responsive-item video-iframe" src="<?php echo $linklist; ?>" allowfullscreen=""></iframe>
  </div> 
<?php endif;?>
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
                    <?php 
                    $temp = 0; 

                    foreach($listvd as $item){
                    $temp++;
                    ?>
                    <tr>
                        <td><?php echo $temp; ?></td>
                        <td><h3><?php echo $item['name']; ?></h3></td>
                        
                        <td class="load_video_pdusoft" data-video="<?php echo $item['id']; ?>"><h4><a href="<?php echo $item['id']; ?>" title="<?php echo $item['name']; ?>">Xem ngay</a></h4></td>
                        
                        <td class="downloadpdu" data-downloadpdu="<?php echo $item['id']; ?>"><a href="#downloadpdu_<?php echo $item['id']; ?>" title="<?php echo $item['name']; ?>">Download</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
var str = document.getElementById("copy_<?php echo $typevd; ?>").innerHTML;
 document.getElementById("myInput_<?php echo $typevd; ?>").value = str;

function myFunction_<?php echo $typevd; ?>() {
  var copyText = document.getElementById("myInput_<?php echo $typevd; ?>");
  copyText.select();
  copyText.setSelectionRange(0, 999999);
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: success";
}

function outFunc_<?php echo $typevd; ?>() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}
</script>
<style>
.tooltip {
  position: relative;
  display: inline-block;
  margin-bottom: 15px;
opacity: 1;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
.tooltip button {
    background: #0ed8ce;
    padding: 15px;
    border-radius: 6px;
    color: #fff;
    transition: all ease 0.6s;
}

.tooltip button:hover {
    background: #1b9892;
}
textarea#myInput {
    opacity: 0;
    min-height: 0;
    width: 0;
    height: 0;
}
</style>
 <?php else:?>
đéo có data
 <?php endif; ?>
