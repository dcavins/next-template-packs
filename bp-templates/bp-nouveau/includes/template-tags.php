<?php
/**
 * Common template tags
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Pagination for loops
 *
 * @since 1.0.0
 */
function bp_pagination( $position = null ) {
	$component = bp_current_component();

	$screen = 'dir';
	if ( bp_is_user() ) {
		$screen = 'user';
	}

	switch( $component ) {

		case 'blogs' :

			/**
			 * bp_get_blogs_pagination_count() doesn't exist in BuddyPress
			 * @see https://buddypress.trac.wordpress.org/ticket/7118
			 *
			 * So we're doing this workaround for now, and will update this part
			 * when/if 7118 is fixed.
			 */
			ob_start();
			bp_blogs_pagination_count();
			$pag_count = ob_get_clean();
			$pag_links = bp_get_blogs_pagination_links();

		break;

		case 'members' :
		case 'friends' :

			$pag_count = bp_get_members_pagination_count();
			$pag_links = bp_get_members_pagination_links();

		break;

		case 'groups' :

			$pag_count = bp_get_groups_pagination_count();
			$pag_links = bp_get_groups_pagination_links();

		break;
	}

	$count_class = sprintf( '%1$s-%2$s-count-%3$s', $component, $screen, $position );
	$links_class = sprintf( '%1$s-%2$s-links-%3$s', $component, $screen, $position );
	?>

	<div class="pagination <?php echo sanitize_html_class( $position ); ?>" data-bp-nav="pagination">

		<?php if ( $pag_count ) : ?>
			<div class="pag-count <?php echo sanitize_html_class( $count_class ); ?>">

				<p class="pag-data">
					<?php echo $pag_count; ?>
				</p>

			</div>
		<?php endif; ?>

		<?php if ( $pag_links ) : ?>
			<div class="pagination-links <?php echo sanitize_html_class( $links_class ); ?>">

				<p class="pag-data">
					<?php echo $pag_links; ?>
				</p>

			</div>
		<?php endif; ?>

	</div>

	<?php
	return;
}

function bp_nouveau_before_activity_post_form() {
	// Enqueue needed script.
	if ( bp_nouveau_current_user_can( 'publish_activity' ) ) {
		wp_enqueue_script( 'bp-nouveau-activity-post-form' );
	}

	do_action( 'bp_before_activity_post_form' );
}

function bp_nouveau_after_activity_post_form() {
	bp_get_template_part( '_accessoires/activity/form' );

	do_action( 'bp_after_activity_post_form' );
}

/**
 * Template tag to wrap all Legacy actions that was used
 * before the blogs directory content
 *
 * @since 1.0.0
 */
function bp_nouveau_before_blogs_directory_content() {
	/**
	 * Fires at the begining of the templates BP injected content.
	 *
	 * @since 2.3.0 (BuddyPress)
	 */
	do_action( 'bp_before_directory_blogs_page' );

	/**
	 * Fires before the display of the blogs.
	 *
	 * @since 1.5.0 (BuddyPress)
	 */
	do_action( 'bp_before_directory_blogs' );

	/**
	 * Fires before the display of the blogs listing content.
	 *
	 * @since 1.1.0 (BuddyPress)
	 */
	do_action( 'bp_before_directory_blogs_content' );

	/**
	 * Fires before the display of the blogs list tabs.
	 *
	 * @since 2.3.0 (BuddyPress)
	 */
	do_action( 'bp_before_directory_blogs_tabs' );
}

/**
 * Template tag to wrap all Legacy actions that was used
 * after the blogs directory content
 *
 * @since 1.0.0
 */
function bp_nouveau_after_blogs_directory_content() {
	/**
	 * Fires inside and displays the blogs content.
	 *
	 * @since 1.1.0 (BuddyPress)
	 */
	do_action( 'bp_directory_blogs_content' );

	/**
	 * Fires after the display of the blogs listing content.
	 *
	 * @since 1.1.0 (BuddyPress)
	 */
	do_action( 'bp_after_directory_blogs_content' );

	/**
	 * Fires at the bottom of the blogs directory template file.
	 *
	 * @since 1.5.0 (BuddyPress)
	 */
	do_action( 'bp_after_directory_blogs' );

	/**
	 * Fires at the bottom of the blogs directory template file.
	 *
	 * @since 2.3.0 (BuddyPress)
	 */
	do_action( 'bp_after_directory_blogs_page' );
}

/** Template tags for the Directory navs **************************************/

function bp_nouveau_directory_type_tabs_class() {
	echo bp_nouveau_get_directory_type_tabs_class();
}

	function bp_nouveau_get_directory_type_tabs_class() {
		$class = sprintf( '%s-type-tabs', bp_current_component() );

		return sanitize_html_class( $class );
	}

function bp_nouveau_directory_list_class() {
	echo bp_nouveau_get_directory_list_class();
}

	function bp_nouveau_get_directory_list_class() {
		$class = sprintf( '%s-nav', bp_current_component() );

		return sanitize_html_class( $class );
	}

function bp_nouveau_directory_has_nav() {
	$bp = buddypress();

	$bp->theme_compat->theme->sorted_dir_nav = array_values( $bp->theme_compat->theme->directory_nav->get_primary() );

	if ( 0 === count( $bp->theme_compat->theme->sorted_dir_nav ) ) {
		unset( $bp->theme_compat->theme->sorted_dir_nav );

		return false;
	}

	$bp->theme_compat->theme->current_dir_nav_index = 0;
	return true;
}

function bp_nouveau_directory_nav_items() {
	$bp = buddypress();

	if ( isset( $bp->theme_compat->theme->sorted_dir_nav[ $bp->theme_compat->theme->current_dir_nav_index ] ) ) {
		return true;
	}

	$bp->theme_compat->theme->current_dir_nav_index = 0;
	unset( $bp->theme_compat->theme->current_dir_nav_item );

	return false;
}

function bp_nouveau_directory_nav_item() {
	$bp = buddypress();

	$bp->theme_compat->theme->current_dir_nav_item = $bp->theme_compat->theme->sorted_dir_nav[ $bp->theme_compat->theme->current_dir_nav_index ];
	$bp->theme_compat->theme->current_dir_nav_index += 1;
}

function bp_nouveau_directory_nav_id() {
	echo bp_nouveau_get_directory_nav_id();
}

	function bp_nouveau_get_directory_nav_id() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;
		$id = sprintf( '%1$s-%2$s', $nav_item->component, $nav_item->slug );

		return esc_attr( $id );
	}

function bp_nouveau_directory_nav_classes() {
	echo bp_nouveau_get_directory_nav_classes();
}

	function bp_nouveau_get_directory_nav_classes() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		if ( empty( $nav_item->li_class ) ) {
			return;
		}

		$classes = array_map( 'sanitize_html_class', (array) $nav_item->li_class );

		return join( ' ', $classes );
	}

function bp_nouveau_directory_nav_scope() {
	echo bp_nouveau_get_directory_nav_scope();
}

	function bp_nouveau_get_directory_nav_scope() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_attr( $nav_item->slug );
	}

function bp_nouveau_directory_nav_object() {
	echo bp_nouveau_get_directory_nav_object();
}

	function bp_nouveau_get_directory_nav_object() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_attr( $nav_item->component );
	}

function bp_nouveau_directory_nav_link() {
	echo bp_nouveau_get_directory_nav_link();
}

	function bp_nouveau_get_directory_nav_link() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_url( $nav_item->link );
	}

function bp_nouveau_directory_nav_title() {
	echo bp_nouveau_get_directory_nav_title();
}

	function bp_nouveau_get_directory_nav_title() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_attr( $nav_item->title );
	}

function bp_nouveau_directory_nav_text() {
	echo bp_nouveau_get_directory_nav_text();
}

	function bp_nouveau_get_directory_nav_text() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_html( $nav_item->text );
	}

function bp_nouveau_directory_nav_has_count() {
	$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

	return false !== $nav_item->count;
}

function bp_nouveau_directory_nav_count() {
	echo bp_nouveau_get_directory_nav_count();
}

	function bp_nouveau_get_directory_nav_count() {
		$nav_item = buddypress()->theme_compat->theme->current_dir_nav_item;

		return esc_attr( $nav_item->count );
	}
