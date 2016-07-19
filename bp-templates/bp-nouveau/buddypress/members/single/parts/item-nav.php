<?php
/**
 * BuddyPress Single Members item Navigation
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */
?>

	<div class="item-list-tabs no-ajax single-screen-navs vertical" id="object-nav" role="navigation">

		<?php if ( bp_nouveau_has_nav( array( 'type' => 'primary' ) ) ) : ?>

			<ul>

				<?php while ( bp_nouveau_nav_items() ) : bp_nouveau_nav_item(); ?>

					<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
						<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
							<?php bp_nouveau_nav_link_text(); ?>

							<?php if ( bp_nouveau_nav_has_count() ) : ?>
								<span><?php bp_nouveau_nav_count(); ?></span>
							<?php endif; ?>
						</a>
					</li>

				<?php endwhile; ?>

				<?php bp_nouveau_member_hook( '', 'options_nav' ) ;?>

			</ul>

		<?php endif ; ?>

	</div>
