<form role="search"  method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-input-wrapper">
		<span class="screen-reader-text">
		<?php echo _x( 'Search for:', 'label' ); ?>
		</span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
</form>