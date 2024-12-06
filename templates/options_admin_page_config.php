<h1 class="wp-heading-inline"><?php _e('Remax Properties', 'remax-properties'); ?></h1>
<hr class="wp-header-end">

<div class="wrap">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2><span><?php esc_attr_e('Settings', 'remax-properties'); ?></span></h2>
                        <div class="inside">
                            <form id="config" action="<?= get_option('home') ?>/wp-admin/admin.php?page=remax-properties-plugin" method="post">
                                <input type="hidden" name="submit" value="Y" />
                                <input type="text" name="token" value="<?= $token ? $token : ''; ?>" class="regular-text code" style="margin-bottom: 10px;" />
                                <span class="description"><?php esc_attr_e('Place your token here.', 'remax-properties'); ?></span><br>

                                <input type="url" name="details_page" value="<?= $details_page ? $details_page : ''; ?>" class="regular-text code" style="margin-bottom: 10px;"  />
                                <span class="description"><?php esc_attr_e('Put property page url to redirect sliders and properties.', 'remax-properties'); ?></span><br>

                                <fieldset>
                                    <label for="agency_properties">
                                        <input name="agency_properties" type="checkbox" id="agency_properties" <?= $agency_properties ? "value='true' checked" : "value='false'"; ?> />
                                        <span><?php esc_attr_e( "Show all my agency's properties", 'remax-properties' ); ?></span>
                                    </label>
                                </fieldset><br>

                                <fieldset>
                                    <label for="api_status">
                                        <input name="api_status" type="checkbox" id="api_status" <?= $api_status ? "value='yes' checked" : "value='no'"; ?> />
                                        <span><?php esc_attr_e( 'Enable development version', 'remax-properties' ); ?></span>
                                    </label>
                                </fieldset><br><br>


                                <h2 style="padding-left: 0;"><span><strong><?php esc_attr_e('Featured Properties', 'remax-properties'); ?></strong></span></h2>
                                <span><?php esc_attr_e( 'Add the code for the featured properties', 'remax-properties' ); ?></span><br><br>
                                <?php foreach($featured_properties as $key => $featured_property): ?>
                                    <input type="number" name="featured_<?= $key + 1 ?>" class="all-options" value="<?= $featured_property ?>" /><br><br>
                                <?php endforeach; ?>
                                
                            </form>
                            <br>
                            <button form="config" class="button-primary" type="submit" style="margin-bottom: 20px;"><?php esc_attr_e('Save'); ?></button>
                        </div>
                        <!-- .inside -->
                    </div>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->

            <!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Use the Short Code:', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
                            <p style="margin-bottom: 10px;"><code style="background: #191E23;color: #fff;">[remax-properties-page]</code> to generate the list of properties.</p>
                            <p style="margin-bottom: 10px;"><code style="background: #191E23;color: #fff;">[remax-properties-slider]</code> to generate the slider.</p>
                            <p style="margin-bottom: 10px;"><code style="background: #191E23;color: #fff;">[remax-properties-search]</code> to generate the search engine.</p>
                            <p style="margin-bottom: 50px;"><code style="background: #191E23;color: #fff;">[remax-properties-featured]</code> to generate the featured properties.</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->
        </div>
        <!-- #post-body .metabox-holder .columns-2 -->
        <br class="clear">
    </div>
    <!-- #poststuff -->
</div> <!-- .wrap -->


<script>
    jQuery(document).ready(function(){
        jQuery("#api_status").on("change", function(){
            if(this.checked) {
                jQuery(this).val('yes');
            } else {
                jQuery(this).val('no');
            }
        });
    });
</script>