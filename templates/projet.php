<pre><?php var_dump($cat) ?>
	
</pre><li class="projet <?= $grand ? 'full' : 'medium' ?> projet">
				<div class="thumbnail"> 
					<?php if( !empty($thumbnail) ): ?>
						<a href="<?= $journal ? get_category_link( $cat ) : the_permalink($presentation); ?>">
							<img src="<?= $thumbnail['sizes']['medium']; ?>" alt="<?= $thumbnail['alt']; ?>" />
						</a>
					<?php endif; ?>
				</div><!--
				--><div class="details">
					<h4>
						<a href="<?= $journal ? get_category_link( $cat ) : the_permalink($presentation); ?>">
							<?= apply_filters('the_title', $cat->name) ?>
						</a>
					</h4>
					<nav>
					    <ul>
						    <?php if ($presentation): ?>
						    	<li><a href="<?= the_permalink($presentation) ?>"><?= __('Presentation', 'html5blank') ?></a></li>
						    <?php endif ?>
						    <?php if ($journal): ?>
						    	<li><a href="/<?= $cat->slug; ?>"><?= __('Dairy', 'html5blank') ?></a></li>
						    <?php else: ?>
						    	<li><a href="<?= the_permalink($presentation) ?>"><?= $avenir ?></a></li>
						    <?php endif ?>
						    <?php if ($carte): ?>
						    	<li><a href="<?= the_permalink($carte) ?>"><?= __('Map', 'html5blank') ?></a></li>
						    <?php endif ?>
					    </ul>
					</nav>
					<div class="content">
						<?=  apply_filters('the_content', $cat->description); ?>
					</div>
				</div>
			</li>