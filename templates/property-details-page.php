<div class="rp-container">
    <div class="property <?= $card_container_class ?>">
        <div class="property__cover-container">
            <!-- Slider main container -->
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <?php foreach ($property_details->pictures as $picture) : ?>
                        <div class="swiper-slide swiper-lazy" style="background-image: url('<?= $picture->pictures ?>')"></div>
                    <?php endforeach; ?>
                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <div class="property-entry">
            <div class="property-entry--code-container">
                <div class="realestate-code-container">
                    <div class="realestate-code realestate-badge">Código: <strong id="realestateCodeValue"><?= $property_code ?></strong></div>
                    <!-- <div class="realestate-code-icon clipboard-copy" data-copy="realestateCodeValue"><img src="https://remaxrd.com/assets/img/icons/ic_paper.svg"></div> -->
                </div>
            </div>
            <h1 class="realestate-title property-title"><?= $property_details->realstate_type . ' en ' . $property_details->sector ?></h1><span class="realestate-subtitle"><?= $property_details->sector . ', ' . $property_details->city ?></span>
            <hr class="horizontal-rule">
            <div class="realestate-prices">
                <?php if (intval($property_details->price, 10) > 0) : ?>
                    <div class="realestate-price"><label class="price-label"><?= $property_details->business_type ?></label>
                        <h3 class="price-value"><?= $property_details->currency->iso . '$ ' . number_format($property_details->price, 0, '.', ','); ?></h3>
                    </div>
                <?php endif; ?>

                <?php if (intval($property_details->alternate_price, 10) > 0) : ?>
                    <div class="realestate-price"><label class="price-label">Alquiler</label>
                        <h3 class="price-value"><?= $property_details->alternative_currency->iso . '$ ' . number_format($property_details->alternate_price, 0, '.', ','); ?></h3>
                    </div>
                <?php endif; ?>

                <?php if (isset($property_details->project->minimum_price) && $property_details->project->minimum_price > 0 ) : ?>
                    <div class="realestate-price"><label class="price-label">Venta</label>
                        <h3 class="price-value"><?= $property_details->currency->iso . '$ ' . number_format($property_details->project->minimum_price, 0, '.', ',') . ' - ' . $property_details->currency->iso . '$ ' . number_format($property_details->project->maximum_price, 0, '.', ','); ?></h3>
                    </div>
                <?php endif; ?>
            </div>
            <hr class="horizontal-rule">
            <div class="realestate-features">
                <?php if ($property_details->bedrooms != NULL) : ?>
                    <div class="realestate-badge realestate-feature rooms"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_bedroom_dark.svg"> <?= $property_details->bedrooms ?> <span>Habitación(es)</span></div>
                <?php endif; ?>

                <?php if ($property_details->bathrooms != NULL) : ?>
                    <div class="realestate-badge realestate-feature bathrooms"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_bathroom_dark.svg"> <?= $property_details->bathrooms ?> <span>Baño(s)</span></div>
                <?php endif; ?>

                <?php if ($property_details->sqm_land != NULL) : ?>
                    <div class="realestate-badge realestate-feature meters"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_solar_dark.svg"> <?= number_format($property_details->sqm_land, 0, '.', ',') ?> <span>m<sup>2</sup> de terreno</span></div>
                <?php endif; ?>

                <?php if ($property_details->sqm_construction != NULL) : ?>
                    <div class="realestate-badge realestate-feature meters"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_solar_dark.svg"> <?= number_format($property_details->sqm_construction, 0, '.', ',') ?> <span>m<sup>2</sup></span></div>
                <?php endif; ?>

                <?php if ($property_details->parking_spots != NULL) : ?>
                    <div class="realestate-badge realestate-feature parking"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_garage_dark.svg"> <?= $property_details->parking_spots ?> <span>Parqueo(s)</span></div>
                <?php endif; ?>

                <?php if ($property_details->floor_level != NULL) : ?>
                    <div class="realestate-badge realestate-feature floor"><img src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_apartamento_dark.svg"> <?= $property_details->floor_level ?> <span>Piso</span></div>
                <?php endif; ?>
            </div>
            <hr class="horizontal-rule">
            <div class="realestate-description">
                <h4 class="realestate-description-title">Descripción</h4>
                <div class="realestate-description-content" style="overflow-wrap: break-word;">
                    <div>
                        <p><?= $property_details->description ?></p>
                    </div>
                </div>
            </div>
            <div class="realestate-improvements">
                <?php if($property_details->full_improvements): ?>
                    <h5 class="realestates-imrpovements-header">Características</h5>
                    <div class="row">
                        <?php
                        $features_techo = '';
                        $features_casa = '';
                        $features_latest = '';
                        $features_modes = '';
                        $icon_check = PLUGIN_REMAXRD_PROPERTIES_URL . "/assets/images/ic_check.svg";
    
                        foreach ($property_details->full_improvements as $improvement) {
                            switch ($improvement->name) {
                                case 'Mejoras':
                                    $features_modes .= "<div class='realestate-improvement-value realestate-badge'><img src='{$icon_check}'><span>{$improvement->value}</span></div>";
                                    break;
                                case 'Techo':
                                    $features_techo .= "<div class='realestate-improvement-group col-md-6'><h5 class='realestate-improvement-title'>{$improvement->name}</h5><div class='realestate-improvement-value realestate-badge'><img src='{$icon_check}'><span>{$improvement->value}</span></div><hr class='h   orizontal-rule'></div>";
                                    break;
                                case 'Casa':
                                    $features_casa .= "<div class='realestate-improvement-group col-md-6'><h5 class='realestate-improvement-title'>{$improvement->name}</h5><div class='realestate-improvement-value realestate-badge'><img src='{$icon_check}'><span>{$improvement->value}</span></div><hr class='horizontal-rule'></div>";
                                    break;
                                default:
                                    $features_latest .= "<div class='realestate-improvement-group col-md-6'><h5 class='realestate-improvement-title'>{$improvement->name}</h5><div class='realestate-improvement-value realestate-badge'><img src='{$icon_check}'><span>{$improvement->value}</span></div><hr class='horizontal-rule'></div>";
                                    break;
                            }
                        }
                        ?>
    
                        <?= $features_techo . $features_casa ?>
    
                        <?php if($features_modes != ''): ?>
                            <div class="realestate-improvement-group col-md-12">
                                <h5 class="realestate-improvement-title">Mejoras</h5>
                                <?= $features_modes ?>
                            </div>
                        <?php endif; ?>
    
                        <?= $features_latest ?>
    
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if(is_active_sidebar('rpd_sidebar') || isset($property_details->agents)): ?>
        <div class="rpd-sidebar">
            <?php if(isset($property_details->agents)): ?>
                <div class="rpd-consultants">
                    <h3 class="rpd-consultants__title" >¿Estás Interesado(a)? ¡Solicita Asesoría!</h3>
                    <?php foreach($property_details->agents as $agent): ?>
                        <div class="rpd-consultant">
                            <div class="rpd-consultant__info">
                                <div class="rpd-consultant__profile-picture" style="background-image: url(<?= $agent->picture ? $agent->picture : PLUGIN_REMAXRD_PROPERTIES_URL . "/assets/images/ic_user_profile.png" ?>);" title="<?= $agent->name ?>">
                                </div>
                                <div class="rpd-consultant__details">
                                    <p class="rpd-consultant__name">
                                        <?= $agent->name ?>
                                    </p>
                                    <p class="rpd-consultant__group">
                                        <?php //echo "<pre>"; var_dump($agent); echo "</pre>"; ?>
                                        <?= $agent->agency_name ? $agent->agency_name : '' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
        
                        <div class="rpd-consultant__contacts">
                            <?php if($agent->phone): ?>
                                <div class="rpd-consultant__contact">
                                    <h4 class="rpd-consultant__contact__title"><img class="rpd-consultant__contact__icon" src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_phone.svg" alt="Icono de tel&eacute;fono" title="Icono de tel&eacute;fono" > Tel&eacute;fono</h4>
                                    <a href="tel:+1<?= $agent->phone ?>" class="rpd-consultant__contact__info"><?= preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $agent->phone,  $matches ) ? "({$matches[1]}) {$matches[2]}-{$matches[3]}" : $agent->phone ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if($agent->phone2): ?>
                                <div class="rpd-consultant__contact">
                                    <h4 class="rpd-consultant__contact__title"><img class="rpd-consultant__contact__icon" src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_phone.svg" alt="Icono de tel&eacute;fono" title="Icono de tel&eacute;fono" > Tel&eacute;fono</h4>
                                    <a href="tel:+1<?= $agent->phone2 ?>" class="rpd-consultant__contact__info"><?= preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $agent->phone2,  $matches ) ? "({$matches[1]}) {$matches[2]}-{$matches[3]}" : $agent->phone2 ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if($agent->mobile): ?>
                                <div class="rpd-consultant__contact">
                                    <h4 class="rpd-consultant__contact__title"><img class="rpd-consultant__contact__icon" src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_whatsapp.svg" alt="Icono de whatsapp" title="Icono de whatsapp" > WhatsApp</h4>
                                    <a href="https://wa.me/+1<?= $agent->mobile ?>?text=Me+interesa+conocer+acerca+de+esta+propiedad.<?= $page_url . "?code={$property_details->id}" ?>" class="rpd-consultant__contact__info"><?= preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $agent->mobile,  $matches ) ? "({$matches[1]}) {$matches[2]}-{$matches[3]}" : $agent->mobile ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if($agent->email): ?>
                                <div class="rpd-consultant__contact rpd-consultant__contact--email">
                                    <h4 class="rpd-consultant__contact__title"><img class="rpd-consultant__contact__icon" src="<?= PLUGIN_REMAXRD_PROPERTIES_URL ?>/assets/images/ic_mail.svg" alt="Icono de email" title="Icono de email" > Email</h4>
                                    <a href="mailto:<?= $agent->email ?>" class="rpd-consultant__contact__info"><?= $agent->email ?></a>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <?php 
                if(is_active_sidebar('rpd_sidebar')) {
                    dynamic_sidebar('rpd_sidebar'); 
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('rp_footerbar')) : ?>
        <div class="rp-footerbar">
            <?php dynamic_sidebar('rp_footerbar'); ?>
        </div>
    <?php endif; ?>
</div>