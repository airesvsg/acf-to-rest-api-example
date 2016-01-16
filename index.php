<?php 
	
	get_header();

	$edit = true;
	
	if ( $edit ) {
		global $post;

		$post_id = 1;
		$url     = site_url( 'wp-json/acf/v2/post/' ) . $post_id;
		$post    = get_post( $post_id );
		
		setup_postdata( $post );
	} else {
		$url = site_url( 'wp-json/wp/v2/posts' );
	}

?>

	<a href="https://github.com/airesvsg/acf-to-rest-api" target="_blank" id="ribbon"><img src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>

	<div class="container">
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation"><a href="http://github.com/airesvsg/acf-to-rest-api" target="_blank">Plugin</a></li>
					<li role="presentation"><a href="http://github.com/airesvsg/acf-to-rest-api-examples" target="_blank">Example</a></li>
				</ul>
			</nav>
			<a href="http://github.com/airesvsg/acf-to-rest-api" target="_blank"><h3 class="text-muted">ACF to REST API</h3></a>
		</div>

		<div class="row">

   			<div class="col-lg-12">
				<div class="input-group">
					<span class="input-group-addon">Endpoint</span>
					<input type="text" class="form-control" value="<?php echo esc_url( $url ); ?>" readonly>
				</div>
   			</div>

			<div class="col-lg-12">	           	
				
				<form action="<?php echo esc_url( $url ); ?>" method="POST">

					<?php if( ! $edit ) : ?>
						<div class="form-group">
							<label for="acf-title">Title</label>
							<input type="text" name="fields[title]" class="form-control" id="acf-title">
						</div>

						<div class="form-group">
							<label for="acf-content">Content</label>
							<textarea name="content" class="form-control" rows="3"  id="acf-content"></textarea>
						</div>
					<?php endif; ?>
					
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#cnt-basic" aria-controls="basic" role="tab" data-toggle="tab">Basic</a></li>
						<li role="presentation"><a href="#cnt-content" aria-controls="content" role="tab" data-toggle="tab">Content</a></li>
						<li role="presentation"><a href="#cnt-choice" aria-controls="choice" role="tab" data-toggle="tab">Choice</a></li>
						<li role="presentation"><a href="#cnt-relational" aria-controls="relational" role="tab" data-toggle="tab">Relational</a></li>
						<li role="presentation"><a href="#cnt-jquery" aria-controls="jquery" role="tab" data-toggle="tab">jQuery</a></li>
						<li role="presentation"><a href="#cnt-repeater" aria-controls="repeater" role="tab" data-toggle="tab">Repeater</a></li>
					</ul>
					
					<div class="tab-content">

						<div role="tabpanel" class="tab-pane active" id="cnt-basic">

							<!-- text -->
							<div class="form-group">
								<label for="acf-text">Text</label>
								<input type="text" name="fields[ag_text]" value="<?php echo get_field( 'ag_text' ); ?>" class="form-control" id="acf-text">
							</div>

							<!-- text area -->
							<div class="form-group">
								<label for="acf-textarea">Text Area</label>								
								<textarea name="fields[ag_text_area]" class="form-control" rows="3"  id="acf-textarea"><?php echo get_field( 'ag_text_area' ); ?></textarea>
							</div>
							
							<!-- number -->
							<div class="form-group">
								<label for="acf-number">Number</label>
								<input type="number" name="fields[ag_number]" value="<?php echo get_field( 'ag_number' ); ?>" class="form-control" id="acf-number">
							</div>
							
							<!-- email -->
							<div class="form-group">
								<label for="acf-email">Email</label>
								<input type="email" name="fields[ag_email]" value="<?php echo get_field( 'ag_email' ); ?>" class="form-control" id="acf-email" value="teste@teste.com">
							</div>
							
							<!-- password -->
							<div class="form-group">
								<label for="acf-password">Password</label>
								<input type="password" name="fields[ag_password]" value="<?php echo get_field( 'ag_password' ); ?>" class="form-control" id="acf-password">
							</div>

						</div><!-- tab-pane -->

						<div role="tabpanel" class="tab-pane" id="cnt-content">

							<!-- wysiwyg editor -->
							<div class="form-group">
								<label for="acf-wysiwyg-editor">Wysiwyg Editor</label>
								<?php wp_editor( get_field( 'ag_wysiwyg_editor' ), 'ag_wysiwyg_editor' ); ?>
							</div>
							
							<!-- image -->
							<?php 
								$image_id     = get_field( 'ag_image' );
								$source_image = wp_get_attachment_image_src( $image_id, 'full'  );
							?>
							<div class="form-group">
								<label for="acf-image">Image</label>								
								<input type="hidden" name="fields[ag_image]" value="<?php echo absint( $image_id ); ?>" class="form-control" id="acf-image">
								<div class="row">
									<div class="col-md-5">
										<a href="#" class="thumbnail" id="acf-image-thumb">
											<span class="btn btn-success">Edit</span>
											<?php if ( $source_image ) : ?>
												<img src="<?php echo $source_image[0]; ?>" width="171">
											<?php else: ?>
												<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUyMjdkZDk5NjQgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTIyN2RkOTk2NCI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2MSIgeT0iOTQuNSI+MTcxeDE4MDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==">
											<?php endif; ?>
										</a>
									</div>	
								</div>
							</div>

							<!-- file -->
							<?php 
								$file_id  = get_field( 'ag_file' );								
								$file_url = wp_get_attachment_url( $file_id );
							?>
							<div class="form-group">
								<label for="acf-file-url">File URL</label>
								<input type="hidden" name="fields[ag_file]" id="acf-file-url-id" value="<?php echo absint( $file_id ); ?>">
								<div class="input-group">
									<input type="text" class="form-control" id="acf-file-url" value="<?php echo esc_url( $file_url ); ?>" readonly>
									<span class="input-group-btn">
										<button type="button" class="btn btn-danger<?php if( ! $file_id ): ?> hide<?php endif; ?>" id="acf-file-url-remove-btn">&times;</button>
										<button type="button" class="btn btn-primary" id="acf-file-url-btn">Select file</button>
									</span>
								</div>
							</div>
						
						</div><!-- tab-pane -->

						<div role="tabpanel" class="tab-pane" id="cnt-choice">
							
							<!-- select -->
							<?php $selected = get_field( 'ag_select' ); ?>
							<div class="form-group">
								<label for="acf-select">Select</label>								
								<select class="form-control input-sm" id="acf-select" name="fields[ag_select]">
									<option value="">-- select --</option>
									<option value="blue"<?php selected( $selected, 'blue' ); ?>>Blue</option>
									<option value="red"<?php selected( $selected, 'red' ); ?>>Red</option>
								</select>								
							</div>
							
							<!-- checkbox -->
							<?php $checked = get_field( 'ag_checkbox' ); ?>
							<label>Checkbox</label>
							<div class="checkbox-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_checkbox]" value="" class="check hide"><span class="btn-link">check all</span>
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_checkbox]" value="" class="uncheck hide"><span class="btn-link">uncheck all</span>
								</label>								
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_checkbox][]" value="blue"<?php _checked( $checked, 'blue' ); ?>> Blue
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_checkbox][]" value="red"<?php _checked( $checked, 'red' ); ?>> Red
								</label>
							</div>
							
							<!-- radio button -->
							<?php $checked = get_field( 'ag_radio_button' ); ?>
							<label>Radio</label>
							<div class="form-group">
								<label class="radio-inline">
									<input type="radio" name="fields[ag_radio_button]" value="blue"<?php checked( $checked, 'blue' ); ?>> Blue
								</label>
								<label class="checkbox-inline">
									<input type="radio" name="fields[ag_radio_button]" value="red"<?php checked( $checked, 'red' ); ?>> Red
								</label>
							</div>
							
							<!-- true / false -->
							<?php $checked = get_field( 'ag_true_false' ); ?>
							<label>True / False</label>
							<div class="form-group">
								<label class="radio-inline">
									<input type="radio" name="fields[ag_true_false]" value="1"<?php checked( $checked, true ); ?>> True
								</label>
								<label class="radio-inline">
									<input type="radio" name="fields[ag_true_false]" value="0"<?php checked( $checked, false ); ?>> False
								</label>
							</div>

						</div><!-- tab-pane -->
						
						<div role="tabpanel" class="tab-pane" id="cnt-relational">
							
							<!-- page link -->
							<?php $page_link = get_field( 'ag_page_link' ); ?>
							<div class="form-group">
								<label for="acf-page-link">Page Link</label>								
								<select class="form-control input-sm" id="acf-page-link" name="fields[ag_page_link]">
									<option value="">-- select --</option>
									<?php foreach ( (array) get_pages() as $p ) : ?>
										<option value="<?php echo $p->ID; ?>"<?php selected( $page_link, get_permalink( $p->ID ) ); ?>><?php echo $p->post_title; ?></option>
									<?php endforeach; ?>
								</select>								
							</div>

							<!-- post object -->
							<?php $post_object = get_field( 'ag_post_object' ); ?>
							<div class="form-group">
								<label for="acf-post-object">Post Object</label>
								<select class="form-control input-sm" id="acf-post-object" name="fields[ag_post_object]">
									<option value="">-- select --</option>
									<?php 
										foreach ( (array) get_posts() as $p ) :
											if ( isset( $post_object->ID ) ) {
												$selected = selected( $post_object->ID, $p->ID, false );
											} else {
												$selected = '';
											}
									?>
										<option value="<?php echo $p->ID; ?>"<?php echo esc_attr( $selected ); ?>><?php echo $p->post_title; ?></option>
									<?php endforeach; ?>
								</select>								
							</div>

							<!-- relationship -->
							<?php $relationship = get_field( 'ag_relationship' ); ?>
							<label>Relationship</label>
							<div class="checkbox-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_relationship]" value="" class="check hide"><span class="btn-link">check all</span>
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_relationship]" value="" class="uncheck hide"><span class="btn-link">uncheck all</span>
								</label>
							</div>
							<div class="form-group">
								<?php foreach ( (array) get_posts( 'post' ) as $p ) : ?>
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_relationship][]" value="<?php echo $p->ID; ?>"<?php _checked( $relationship, $p->ID ); ?>> <?php echo $p->post_title; ?>
								</label>
								<?php endforeach; ?>
							</div>
							
							<!-- taxonomy -->
							<?php $taxonomy = get_field( 'ag_taxonomy' ); ?>
							<label>Taxonomy</label>
							<div class="checkbox-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_taxonomy]" value="" class="check hide"><span class="btn-link">check all</span>
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="fields[ag_taxonomy]" value="" class="uncheck hide"><span class="btn-link">uncheck all</span>
								</label>
							</div>
							<div class="form-group">
								<?php foreach ( (array) get_terms( 'category' ) as $t ) : ?>
									<label class="checkbox-inline">
										<input type="checkbox" name="fields[ag_taxonomy][]" value="<?php echo $t->term_id; ?>"<?php _checked( $taxonomy, $t->term_id ); ?>> <?php echo $t->name; ?>
									</label>
								<?php endforeach; ?>
							</div>

							<!-- user -->
							<?php $user = get_field( 'ag_user' ); ?>
							<div class="form-group">
								<label for="acf-user">User</label>
								<select class="form-control input-sm" id="acf-user" name="fields[ag_user]">
									<option value="">-- select --</option>
									<?php 
										foreach ( (array) get_users() as $u ) : 
											if ( isset( $user['ID'] ) ) {
												$selected = selected( $user['ID'], $u->ID, false );
											} else {
												$selected = '';
											}
									?>
										<option value="<?php echo $u->ID; ?>"<?php echo esc_attr( $selected ); ?>><?php echo $u->display_name; ?></option>
									<?php endforeach; ?>
								</select>				
							</div>

						</div><!-- tab-pane -->

						<div role="tabpanel" class="tab-pane" id="cnt-jquery">
							
							<!-- date picker -->
							<div class="form-group">
								<label for="acf-date-picker">Date Picker</label>
								<input type="text" name="fields[ag_date_picker]" value="<?php echo get_field( 'ag_date_picker' ); ?>" class="form-control datepicker" id="acf-date-picker">
							</div>

							<!-- color picker -->
							<?php $color_picker = get_field( 'ag_color_picker' ); ?>
							<div class="form-group">
								<label for="acf-color-picker">Color Picker</label>
								<input type="text" name="fields[ag_color_picker]" value="<?php echo $color_picker; ?>" class="form-control color-picker" id="acf-color-picker" style="background-color:<?php echo $color_picker; ?>">
							</div>

							<!-- google maps -->
							<?php 
								$google_map = get_field( 'ag_google_map' );
								if ( ! $google_map ) {
									$google_map = array(
										'address' => '',
										'lat'     => '',
										'lng'     => '',
									);
								}
							?>
							<div class="google-map" data-lat="<?php echo esc_attr( $google_map['lat'] ); ?>" data-lng="<?php echo esc_attr( $google_map['lng'] ); ?>">
								<div class="form-group">
									<label for="acf-google-map-search">Google Map</label>
									<input type="text" name="fields[ag_google_map][address]" value="<?php echo esc_attr( $google_map['address'] ); ?>" placeholder="<?php _e( "Search for address..." ); ?>" class="form-control google-map-search" id="acf-google-map-search" />
									<input type="hidden" name="fields[ag_google_map][lat]" value="<?php echo esc_attr( $google_map['lat'] ); ?>" id="lat" class="form-control google-map-lat" value="<?php echo $google_maps['lat']; ?>" readonly>
									<input type="hidden" name="fields[ag_google_map][lng]" value="<?php echo esc_attr( $google_map['lng'] ); ?>" id="lng" class="form-control google-map-lng" value="<?php echo $google_maps['lat']; ?>" readonly>
								</div>
								<div class="map"></div>
							</div>

						</div><!-- tab-pane -->
						
						<div role="tabpanel" class="tab-pane" id="cnt-repeater">
							<p class="bg-warning">You need to have the plugin <a href="http://www.advancedcustomfields.com/add-ons/repeater-field/" target="_blank">ACF Repeater Field</a>.</p>
							<!-- repeater -->
							<?php 
								$repeater = get_field( 'ag_repeater' );
								if ( ! $repeater ) {
									$repeater = array(
										array(
											'ag_first_name' => '',
											'ag_last_name'  => '',
										)
									);
								}
							?>
							<div class="repeater">
								<?php foreach ( $repeater as $k => $v ) : ?>
								<div class="item">
									<div class="form-group">
										<label>First name</label>
										<input type="text" name="fields[ag_repeater][<?php echo absint( $k ); ?>][ag_first_name]" class="form-control" value="<?php echo esc_attr( $v['ag_first_name'] ); ?>">
									</div>
									<div class="form-group">
										<label>Last name</label>
										<input type="text" name="fields[ag_repeater][<?php echo absint( $k ); ?>][ag_last_name]" class="form-control" value="<?php echo esc_attr( $v['ag_last_name'] ); ?>">
									</div>
									<button type="button" class="btn btn-danger remove-row">remove</button>
									<hr>
								</div>
								<?php endforeach; ?>
								<button type="button" class="btn btn-primary add-row">add row</button>
							</div>
														
						</div><!-- tab-pane -->

					</div><!-- /tab-content -->

	           		<button type="submit" class="btn btn-success">Save</button>
				</form>
			</div><!-- /col-lg-12 -->
		</div>
		
		<footer class="footer">
			<p><a href="http://github.com/airesvsg" target="_blank">Aires Gonçalves</a></p>
		</footer>
	</div> <!-- /container -->
	
	<div class="modal fade" id="modalResponse" tabindex="-1" role="dialog" aria-labelledby="modalResponseLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalResponseLabel">Response</h4>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>