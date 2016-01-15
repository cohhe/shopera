<?php
	$categoryimg1 = get_template_directory_uri().'/demo-content/images/category1.png';
	$categoryimg2 = get_template_directory_uri().'/demo-content/images/category2.png';
	$categoryimg3 = get_template_directory_uri().'/demo-content/images/category3.png';
?>

<div class="woo-category-container three">
	<div class="woo-category-item">
		<div class="woo-category-image" style="background-image:url(<?php echo $categoryimg1; ?>)"></div>
		<a href="#" class="woo-category-inner">
			<span class="woo-category-title">Summer</span>
			<span class="woo-category-excerpt">-Collection-</span>
		</a>
	</div>
	<div class="woo-category-item">
		<div class="woo-category-image" style="background-image:url(<?php echo $categoryimg2; ?>)"></div>
		<a href="#" class="woo-category-inner">
			<span class="woo-category-title">Bathroom</span>
			<span class="woo-category-excerpt">-Essentials-</span>
		</a>
	</div>
	<div class="woo-category-item">
		<div class="woo-category-image" style="background-image:url(<?php echo $categoryimg3; ?>)"></div>
			<a href="#" class="woo-category-inner">
				<span class="woo-category-title">Winter</span>
				<span class="woo-category-excerpt">-Clothing-</span>
			</a>
	</div>
	<div class="clearfix"></div>
</div>