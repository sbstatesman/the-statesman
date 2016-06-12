<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="search" />
	</label>
  <button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>">GO</button>
</form>