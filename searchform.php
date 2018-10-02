<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<form method="get" id="searchform" action="<?php get_search_link(); ?>">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" class="form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search for', 'searchfor' ); ?>" />
                <span class="input-group-append">
                    <button class="submit" name="submit" id="searchsubmit" type="submit" value="<?php esc_attr_e( 'Submit', 'searchfor' ); ?>">
                        <span class="fa fa-search"></span>
                    </button> 
                </span>
            </div>
        </div>
	</form>