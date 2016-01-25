<div class="entry-infos">
	<?php $location = get_field('travel_point'); ?>
	<?php if( !empty($location) && !empty($location['lat']) && !empty($location['lng']) ): ?>
		<a class="country popup-gmaps" href="https://maps.google.com/maps?q=<?= $location['address'] ?>" title="Voir sur une carte"><i class="fa fa-map-marker"></i> <?= $location['address'] ?></a>
	<?php endif ?>
	
	<span class="entry-date"><i class="fa fa-calendar"></i> <time class="published" datetime="<?= get_the_time('c'); ?>"><?= get_the_date(); ?></time></span>
	
	<?php $tags_list = false;//get_the_tag_list( '', ', ' ); ?>
	<?php if ( $tags_list) : ?>
		<span class="tags">
			<i class="fa fa-tags"></i> <?php printf( __( '%1$s', 'dw-timeline' ), $tags_list ); ?>
		</span>
	<?php endif; ?>
</div>
