<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<button type="submit" class="iconbar iconbar-search search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>">
		<i class="fa fa-search fa-2x"></i>
	</button>
	<label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="search" />
	</label>
</form>