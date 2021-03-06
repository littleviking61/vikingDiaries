<div class="entry-infos">
	<?php $location = get_field('travel_point'); ?>
	<?php if( !empty($location) && !empty($location['lat']) && !empty($location['lng']) ): ?>
		<a class="country popup-gmaps" href="https://maps.google.com/maps?z=5&q=<?= $location['address'] ?>" title="<?= __('See on the map') ?>"><i class="fa fa-map-marker"></i> <?= $location['address'] ?></a>
	<?php endif ?>
	
	<?php if(!get_field('hide_date')) :?>
		<span class="entry-date"><i class="fa fa-calendar"></i> <time class="published" datetime="<?= get_the_time('c'); ?>"><?= get_the_date(); ?></time></span>
	<?php endif ?>
	
	<?php $tags_list = false;//get_the_tag_list( '', ', ' ); ?>
	<?php if ( $tags_list) : ?>
		<span class="tags">
			<i class="fa fa-tags"></i> <?php printf( __( '%1$s', 'html5blank' ), $tags_list ); ?>
		</span>
	<?php endif; ?>
</div>
