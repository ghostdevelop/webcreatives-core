<div class="livesearch">
	<input type="text" class="autocomplete" data-id="<?php the_ID();?>" placeholder="keresés" data-action="add_slider_object"/>
</div>
<div class="uploader">
	<input type="hidden" name="logo" id="logo_url" value="<?php echo get_option('logo');?>"/>
	<button id="logo_button" class="upload_button button" data-id="<?php the_ID()?>" >Feltölt</button>
</div>

<div class="slider_editor_elements">
<?php $objects = WCSliderAdmin::get_slider_objects(get_the_ID());?>
	<ul id="slider_elements">
		<?php foreach($objects as $object): ?>
			<?php WCSliderAdmin::slider_create_object_html($object) ?>
	    <?php endforeach;?>
	</ul>
</div>
