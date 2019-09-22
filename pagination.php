<!-- pagination -->
<div class="pagination">
	<?php if (!empty(get_search_query())): ?>
			<?php if (!is_null(get_previous_posts_link())): ?>				
				<span class="more-link"><?php previous_posts_link( __('Load precedent Results', 'html5blank') ); ?></span>
			<?php endif ?>
			<?php if (!is_null(get_next_posts_link())): ?>				
				<span class="more-link"><?php next_posts_link( __('Load previous Results', 'html5blank') ); ?></span>
			<?php endif ?>
	<?php else: ?>	
		<span class="more next">
			<?= __('Load previous Posts', 'html5blank') ?>
		</span>
		<div class="pagination-links">
			<?php html5wp_pagination(); ?>
		</div>
	<?php endif ?>
</div>
<!-- /pagination -->
