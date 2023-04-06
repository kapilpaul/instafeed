<?php
/**
 * Render Feeds.
 *
 * @since 1.0.0
 *
 * @package InstaFeed
 */

$i         = 0;
$column    = isset( $settings['column'] ) ? (int) $settings['column'] : 3;
$column    = $column > 4 ? 4 : $column;
$show_link = filter_var( $settings['show_link'], FILTER_VALIDATE_BOOLEAN );

if ( $show_link ) {
	$profile_link = 'https://www.instagram.com/' . iaf_get_instagram_username();
}

$instagram_feeds_container_id = 'instagram-feeds-container-' . wp_rand( 0, 100 );

?>

<!--adding style in here for not using inline style-->
<style>
	#<?php echo esc_attr( $instagram_feeds_container_id ); ?> .single-feed {
		flex-basis: calc( 100% / <?php echo esc_attr( $column ); ?> );
	}

	<?php if ( $settings['text_color'] ) : ?>
	#<?php echo esc_attr( $instagram_feeds_container_id ); ?> .instagram-feed-title,
	#<?php echo esc_attr( $instagram_feeds_container_id ); ?> .instagram-profile__link {
		color: <?php echo esc_attr( $settings['text_color'] ); ?>;
	}
	<?php endif; ?>

	<?php if ( $settings['background_color'] ) : ?>
	#<?php echo esc_attr( $instagram_feeds_container_id ); ?> .instagram-profile__link {
		background: <?php echo esc_attr( $settings['background_color'] ); ?>;
	}
	<?php endif; ?>
</style>
<!-- style end -->

<div class="instagram-feeds-container" id="<?php echo esc_attr( $instagram_feeds_container_id ); ?>">

	<h2 class="widget-title subheading heading-size-3 instagram-feed-title">
		<?php echo wp_kses_post( $settings['title'] ); ?>
	</h2>

	<?php if ( is_array( $feeds['data'] ) ) : ?>

		<?php foreach ( $feeds['data'] as $key => $feed ) : ?>

			<?php if ( 0 === $i ) : // add row wrapper div. ?>
				<div class="row">
			<?php endif; ?>

			<a class="single-feed" href="<?php echo esc_url( $feed['media_url'] ); ?>">
				<img
					src="<?php echo esc_url( $feed['media_url'] ); ?>"
					alt="<?php echo ! empty( $feed['caption'] ) ? esc_html( $feed['caption'] ) : esc_html__( 'Instagram feed image', 'insta-api-feed' ); ?>"
					title="<?php echo ! empty( $feed['caption'] ) ? esc_html( $feed['caption'] ) : esc_html__( 'Instagram feed image', 'insta-api-feed' ); ?>"
				>
			</a>

			<?php
			// Increasing count.
			$i++;

			// end row wrapper div if the last number of feed or matches the column no.
			if ( $i === $column || count( $feeds['data'] ) === ( $key + 1 ) ) :
				// making the $i count to 0 again for re-render the row wrapper.
				$i = 0;
				?>
				</div>
			<?php endif; ?>

			<?php endforeach; ?>

	<?php endif; ?>

	<?php if ( $show_link ) : ?>
		<div class="instagram-profile">
			<a class="instagram-profile__link" target="_blank" href="<?php echo esc_url( $profile_link ); ?>"><?php echo esc_html( $settings['link_text'] ); ?></a>
		</div>
	<?php endif; ?>

</div> <!-- end of instagram-feeds-container div -->
