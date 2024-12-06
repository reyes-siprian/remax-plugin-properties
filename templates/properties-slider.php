<div class="properties-slider">
    <?php if($properties->message != 'Server Error'): ?>
        <div class="properties-slider__desktop">
    
            <?php foreach ($properties->data as $key => $property) : ?>
                <div class="card"><a href="<?= get_option('remax_properties_page_url') . "/?code={$property->id}" ?>" title="<?= $property->realstate_type ?> en Alquiler en <?= $property->sector ?>, <?= $property->city ?>" id="article" class="card--property ">
                        <div class="card__thumbnail" style="background-image: url(&quot;<?= $property->main_picture->small ?>&quot;);">
    
                            <!-- <img class="card__thumbnail__exclusive" src="https://remaxrd.com/assets/img/exclusiva.png" style="position: absolute; right: 0px; top: 0px;"> -->
    
                            <!-- <img src="/assets/img/master_broker.png" style="position: absolute; right: 0px; top: 0px;"> -->
                        </div>
                        <div class="card__content">
                            <div class="card__description">
                                <p class="card__description__title"><?= $property->realstate_type ?></p>
                                <p class="card__description__address__mansory"><span><?= $property->sector . ', ' . $property->city ?></span></p>
                                <div>
                                    <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Código</p>
                                    <p class="card__description__title mb-10"><span><?= $property->id ?></span></p>
    
                                    <?php if (isset($property->price) && $property->price > 0) : ?>
                                        <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;"><?= $property->business_type ?></p>
                                        <p class="card__description__price mb-10"><span><?= $property->currency->iso ?>$ <span><?= number_format($property->price, 0, '.', ','); ?></span></p>
                                    <?php endif; ?>
    
                                    <?php if (isset($property->alternate_price) && $property->alternate_price > 0) : ?>
                                        <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Alquiler</p>
                                        <p class="card__description__price mb-10"><span><?= $property->alternative_currency->iso ?>$ <span><?= number_format($property->alternate_price, 0, '.', ','); ?></span></p>
                                    <?php endif; ?>
    
                                    <?php if (isset($property->project->minimum_price) && $property->project->minimum_price > 0) : ?>
                                        <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Venta</p>
                                        <p class="card__description__price mb-10"><span><?= $property->currency->iso ?>$ <span><?= number_format($property->project->minimum_price, 0, '.', ','); ?> - <?= number_format($property->project->maximum_price, 0, '.', ','); ?></span></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card__footer">
                                <div class="card__divider"></div>
                                <div class="card__details">
                                    <ul>
                                        <?php if ($property->bedrooms != NULL) : ?>
                                            <li><span class="rooms"><i class="icon icon-remax-bed"></i> <?= $property->bedrooms ?></span></li>
                                        <?php endif; ?>
    
                                        <?php if ($property->bathrooms != NULL) : ?>
                                            <li><span class="bathrooms"><i class="icon icon-remax-bathroom"></i> <?= $property->bathrooms ?></span></li>
                                        <?php endif; ?>
    
                                        <?php if ($property->sqm_construction != NULL) : ?>
                                            <li><span class="sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $property->sqm_construction ?></span>mt</span></li>
                                        <?php elseif ($property->sqm_land != NULL) : ?>
                                            <li><span class="sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $property->sqm_land ?></span>mt</span></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a></div>
    
                    <?php if($key == 7 ) break; ?>
            <?php endforeach; ?>
    
        </div>
    
        <div class="properties-slider__movil">
            <!-- Slider main container -->
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    
                    <?php foreach ($properties->data as $key => $property) : ?>
                        <div class="swiper-slide swiper-lazy">
        
                            <div class="card"><a href="<?= get_option('remax_properties_page_url') . "/?code={$property->id}" ?>" title="<?= $property->business_type ?> en Alquiler en <?= $property->sector ?>, <?= $property->city ?>" id="article" class="card--property ">
                                <div class="card__thumbnail" style="background-image: url(&quot;<?= $property->main_picture->small ?>&quot;);">
        
                                    <!-- <img class="card__thumbnail__exclusive" src="https://remaxrd.com/assets/img/exclusiva.png" style="position: absolute; right: 0px; top: 0px;"> -->
        
                                    <!-- <img src="/assets/img/master_broker.png" style="position: absolute; right: 0px; top: 0px;"> -->
                                </div>
                                <div class="card__content">
                                    <div class="card__description">
                                        <p class="card__description__title"><?= $property->business_type ?></p>
                                        <p class="card__description__address__mansory"><span><?= $property->sector . ', ' . $property->city ?></span></p>
                                        <div>
                                            <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Código</p>
                                            <p class="card__description__title mb-10"><span><?= $property->id ?></span></p>
        
                                            <?php if (isset($property->price) && $property->price > 0) : ?>
                                                <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;"><?= $property->business_type ?></p>
                                                <p class="card__description__price mb-10"><span><?= $property->currency->iso ?>$ <span><?= number_format($property->price, 0, '.', ','); ?></span></p>
                                            <?php endif; ?>
        
                                            <?php if (isset($property->alternate_price) && $property->alternate_price > 0) : ?>
                                                <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Alquiler</p>
                                                <p class="card__description__price mb-10"><span><?= $property->alternative_currency->iso ?>$ <span><?= number_format($property->alternate_price, 0, '.', ','); ?></span></p>
                                            <?php endif; ?>
        
                                            <?php if (isset($property->project->minimum_price) && $property->project->minimum_price > 0) : ?>
                                                <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Venta</p>
                                                <p class="card__description__price mb-10"><span><?= $property->currency->iso ?>$ <span><?= number_format($property->project->minimum_price, 0, '.', ','); ?> - <?= number_format($property->project->maximum_price, 0, '.', ','); ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card__footer">
                                        <div class="card__divider"></div>
                                        <div class="card__details">
                                            <ul>
                                                <?php if ($property->bedrooms != NULL) : ?>
                                                    <li><span class="rooms"><i class="icon icon-remax-bed"></i> <?= $property->bedrooms ?></span></li>
                                                <?php endif; ?>
        
                                                <?php if ($property->bathrooms != NULL) : ?>
                                                    <li><span class="bathrooms"><i class="icon icon-remax-bathroom"></i> <?= $property->bathrooms ?></span></li>
                                                <?php endif; ?>
        
                                                <?php if ($property->sqm_construction != NULL) : ?>
                                                    <li><span class="sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $property->sqm_construction ?></span>mt</span></li>
                                                <?php elseif ($property->sqm_land != NULL) : ?>
                                                    <li><span class="sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $property->sqm_land ?></span>mt</span></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </a></div>
                        </div>
    
                        <?php if($key == 7 ) break; ?>
                    <?php endforeach; ?>
                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    <?php else: ?>
        <h2 style='text-align: center; width: 100%;'>Error al cargar los datos</h2>
    <?php endif; ?>
</div>