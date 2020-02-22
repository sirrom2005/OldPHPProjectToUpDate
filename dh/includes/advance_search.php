<div id="products" class="contenPage">
    <div class="bg">
        <h2>Advance Search</h2>
		<form name="advs" action="<?php echo DOMAIN;?>search.php" method="post">
			<fieldset><legend>Title</legend>
			<ul class="table">
				<li class="title">Whit this exact word</li><li><input class="inputbox" type="text" name="search_text"/></li>
				<li class="title">Matching text in title</li><li><input class="inputbox" type="text" name="search_text_any"/></li>
  			</ul>
			</fieldset>
			<fieldset><legend>Other</legend>
			<ul class="table">
				<li class="title">Category</li>
				<li>
			    <select class="tb" name="search_cat" onchange="loadSub(this)">
				<option value="">Category</option>
				<?php foreach($category as $row){ ?>
					<option value="<?php echo $row['ceo_url_category'];?>"><?php echo $row['category'];?></option>;
				<?php } ?>
				</select>
				<div id="subcategory"></div>
				</li>
				<li class="title">Price</li>
				<li>$<input type="text" size="6" maxlength="7" name="sprice" value="0"/> to $<input type="text" size="6" maxlength="7" name="eprice" value="1000"/></li>
				<li class="title">No price limit</li>
				<li><input type="checkbox" id="pricelimit" name="pricelimit" onclick="priceLimit(this)" value="1" /></li>
				<li class="title">Any size file size</li>
				<li>
					<select name="filesize">
						<option value="">Any file size</option>
						<option value="0 and 10">0 - 10mgs</option>
						<option value="11 and 20">11mgs - 20ms</option>
						<option value="21 and 40">21mgs - 40mgs</option>
						<option value="41 and 60">41mgs - 60mgs</option>
						<option value="61 and 80">61mgs - 80mgs</option>
						<option value="81 and 100">81mgs - 100mgs</option>
						<option value="101 and 200">101mgs - 200mgs</option>
						<option value="201 and 500">201mgs - 500mgs</option>
						<option value="501 and 999">501mgs - 999mgs</option>
						<option value="1000 and 1000000000">1gigs and over</option>
					</select>
				</li>
			</ul>
			</fieldset>
            <fieldset><legend>Search By Keyword</legend>
			<ul class="table">
				<li class="title">Keyword</li><li><input class="inputbox" type="text" name="keyword"/></li>
  			</ul>
			</fieldset>
			<input type="submit" value="Submit" />
		  </form>
		<div class="clear"></div>
    </div>
</div>

<script>
function priceLimit(ele)
{
	document.advs.sprice.disabled = ele.checked;
	document.advs.eprice.disabled = ele.checked;
}

function loadSub(ele)
{ 
	$("#subcategory").load("includes/ajax_sub_cat.php?id=" + ele.value );
}

</script>