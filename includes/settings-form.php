<div class="wrap scnb">
	
	<h2><?php _e('LinkBlog by Lucy', 'lbbylu'); ?></h2>
	
	<div id="alert"></div>
	
	<form method="post" action="options.php">
				
		<?php settings_fields( 'lbbylu_settings_group' ); ?>

		<div class="lbbylu-block">
							
			<p class="default XL">
				<input id="lbbylu_settings[not_override_permalink]" 
						name="lbbylu_settings[not_override_permalink]" 
						type="checkbox" 
						value="1"
						<?php if( isset($options['not_override_permalink']) ) checked( $options['not_override_permalink'], 1, true ); ?> />

				<label class="description" for="lbbylu_settings[not_override_permalink]"><b><?php _e('Do not override Post Permalink by default.', 'lbbylu'); ?></b></label>					
			</p>

		</div>	<!--block-->	
					
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Options', 'lbbylu'); ?>" />
		</p>

	<h2><?php _e('Documentation', 'lbbylu'); ?></h2>	

		<div class="lbbylu-docs">
			<?php
			_e('<p>This plugin by default will override the post permalink to replace it with the LinkBlog External Link if it exists for the post.</p>
			<p>But you may want to be able to get the actual permalink of the post for some other reasons. Maybe to add an aditional link to your post page.</p>
			<p>To do this you only need to check the option "Do not override Post Permalink by default" in this form.<br/>
			You can access manualy with code to the LinkBlog External Link with <pre>get_post_meta($post->ID, \'linkblog_external_link\', true);</pre></p>

			<p>For example, you can place this in your theme loop:</p>', 'lbbylu');
			?>
			<pre>

<?php  
$str = 'if( $url = get_post_meta($post->ID, \'linkblog_external_link\', true) ) {
	
	$before = sprintf( \'<h1 class="entry-title"><a href="%s" rel="bookmark">\', esc_url( $url ) );
	$after  = sprintf( \'</a> <a href="%s">#</a></h1>\', esc_url( get_permalink() ) );
				
} else {

	$before = sprintf( \'<h1 class="entry-title"><a href="%s" rel="bookmark">\', esc_url( get_permalink() ) );
	$after  = \'</a></h1>\';
}

the_title( $before, $after);';
echo htmlentities($str);
?>

</pre>
<p>The result of this code would be:</p>
<h2><?php _e('My Post Title') ?> #</h2>
<p>Where <b>"My Post Title"</b> would be a link to the external site, and <b>"#"</b> would be a link to my post single page.</p>
			</pre>
		</div>

		
			
	</form>	
</div>