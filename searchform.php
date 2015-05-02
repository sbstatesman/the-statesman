<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<input type="image" class="iconbar iconbar-search search-submit" src="<?php bloginfo( 'template_url' ); ?>/images/search.png" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" width="10" />
	<label>
		<input type="search" class="search search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="search" />
	</label>
</form>