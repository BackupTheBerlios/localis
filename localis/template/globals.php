<?
$g_layermenu =<<<_END_
<div class="tool%s" onclick="document.f.%s.checked=!document.f.%s.checked;">
<input type="checkbox" id="%s" name="layers[]" value="%s" %s onclick="this.checked=!this.checked;"> %s</div>
_END_;
$g_list =<<<_END_
<div class="dashed" style="margin-top:15px;padding:5px;">
%s
</div>
_END_;
$g_listitem =<<<_END_
<div class="list"><a href="localis.php?drawlayer=%s&showid=%s%s">
<img src="images/mapzoom.png" width="8" height="8" hspace="2" vspace="0" border="0" alt="look " align="baseline">
%s : %s
</a></div>
_END_;
$g_maplocations =<<<_END_
<area href="#" name="%s" id="%s" shape="rect" coords="%s,%s,%s,%s" onmouseover="return overlib('%s', WIDTH, 150);"
onmouseout="return nd();" onclick="return overlib('%s',STICKY, CLOSECLICK, CAPTION, '%s', WIDTH, 150);">
_END_;
?>
