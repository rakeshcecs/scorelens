
<?php
    $title = $args['title'] ?? get_the_title();
?>

<nav class="breadcrumb" aria-label="Breadcrumb">
	<a class="breadcrumb-home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		Home
	</a>

	<span class="breadcrumb-sep" aria-hidden="true">
		&rsaquo;
	</span>

	<span class="breadcrumb-current">
		<?php echo esc_html( $title ); ?>
	</span>
</nav>