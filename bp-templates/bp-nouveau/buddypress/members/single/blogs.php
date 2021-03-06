<?php
/**
 * BuddyPress - Users Blogs
 *
 * @since  1.0.0
 *
 * @package BP Nouveau
 */

?>

<nav class="bp-navs bp-subnavs user-subnav" id="subnav" role="navigation" aria-label="<?php esc_attr_e( 'Sites menu', 'buddypress' ); ?>">
	<ul class="subnav">

		<?php bp_get_template_part( 'members/single/parts/item-subnav' ); ?>

	</ul>
</nav><!-- .bp-navs -->

<?php bp_get_template_part( 'common/search-&-filters-bar' ); ?>

<?php
switch ( bp_current_action() ) :

	// Home/My Blogs
	case 'my-sites' :

		bp_nouveau_member_hook( 'before', 'blogs_content' ); ?>

		<div class="blogs myblogs" data-bp-list="blogs">

			<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'member-blogs-loading' ) ;?></div>

		</div><!-- .blogs.myblogs -->

		<?php bp_nouveau_member_hook( 'after', 'blogs_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
