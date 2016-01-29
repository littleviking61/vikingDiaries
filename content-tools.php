<div class="tools">
	<ul>
    <li class="hide-on-single">
			<button title="Close (ESC)" type="button" class="close"><i class="fa fa-close"></i></button>
		</li>
		<li>
			<?= getPostLikeLink( get_the_ID() ) ?>
		</li>
		<li>
			<share-button data-url="<?php the_permalink(); ?>" data-title="<?php the_title() ?>"></share-button></li>
		</li>
		<li>
			<a href="#comment" title="<?= __('Commenter') ?>" type="button" class="comment"><i class="fa fa-commenting"></i><span><?php comments_number( "", "%", "%" ); ?> </span></a>
		</li>
		<?php $location = get_field('travel_point'); ?>
		<?php if( !empty($location) && !empty($location['lat']) && !empty($location['lng']) ): ?>
			<li>
				<a class="country popup-gmaps" href="https://maps.google.com/maps?z=5&q=<?= $location['address'] ?>" title="<?= __('Voir sur une carte') ?>"><i class="fa fa-map-marker"></i></a>
			</li>
		<?php endif ?>
	</ul>
</div>