<?php if($featured_properties->data): ?>
    <div class="rpd-featured">
        <?php foreach($featured_properties->data as $featured_property) : ?>
            <?php
                // var_dump($featured_property->id);
                // die;
            ?>
            <div class="rpd-featured__card"><a href="<?= $page_url . "?code={$featured_property->id}" ?>" title="<?= $featured_property->realestate_type_language->description ?> en Alquiler en <?= $featured_property->sector->description ?>, <?= $featured_property->city->description ?>" id="article" class="rpd-featured__card--property ">
                    <div class="rpd-featured__card__thumbnail" style="background-image: url(&quot;https://images.remaxrd.com/media/pictures/small/<?= $featured_property->pictures[0]->path ?>&quot;);">
                            <!-- <img class="rpd-featured__card__thumbnail__exclusive" src="https://remaxrd.com/assets/img/exclusiva.png" style="position: absolute; right: 0px; top: 0px;"> -->
                            <!-- <img src="/assets/img/master_broker.png" style="position: absolute; right: 0px; top: 0px;"> -->
                    </div>
                    
                    <div class="rpd-featured__card__content">
                        <div class="rpd-featured__card__description">
                            <p class="rpd-featured__card__description__title"><?= $featured_property->realestate_type_language->description ?></p>
                            <p class="card__description__address__mansory"><span><?= $featured_property->sector->description . ', ' . $featured_property->city->description ?></span></p>
                            <div>
                                <p class="rpd-featured__card__description__title--small" style="font-family: unset; font-size: 12.5px;">Código</p>
                                <p class="rpd-featured__card__description__title mb-10"><span><?= $featured_property->id ?></span></p>
                                <?php if (isset($featured_property->price) && $featured_property->price > 0) : ?>
                                    <p class="rpd-featured__card__description__title--small" style="font-family: unset; font-size: 12.5px;"><?= $featured_property->businesstype_language->description ?></p>
                                    <p class="rpd-featured__card__description__price mb-10"><span><?= $featured_property->currency->nostd_iso ?>$ <span><?= number_format($featured_property->price, 0, '.', ','); ?></span></p>
                                <?php endif; ?>

                                <?php if (isset($featured_property->alternate_price) && $featured_property->alternate_price > 0) : ?>
                                    <p class="rpd-featured__card__description__title--small" style="font-family: unset; font-size: 12.5px;">Alquiler</p>
                                    <p class="rpd-featured__card__description__price mb-10"><span><?= isset($property->alt_currency->nostd_iso) ? $property->alt_currency->nostd_iso : $property->currency->nostd_iso ?>$ <span><?= number_format($featured_property->alternate_price, 0, '.', ','); ?></span></p>
                                <?php endif; ?>

                                <?php if (isset($featured_property->project[0]->minimum_price) && $featured_property->project[0]->minimum_price > 0) : ?>
                                    <p class="rpd-featured__card__description__title--small" style="font-family: unset; font-size: 12.5px;">Venta</p>
                                    <p class="rpd-featured__card__description__price mb-10"><span><?= $featured_property->currency->nostd_iso ?>$ <span><?= number_format($featured_property->project[0]->minimum_price, 0, '.', ','); ?> - <?= number_format($featured_property->project[0]->maximum_price, 0, '.', ','); ?></span></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="rpd-featured__card__footer">
                            <div class="rpd-featured__card__divider"></div>
                            <div class="rpd-featured__card__details">
                                <ul>
                                    <?php if ($featured_property->bedrooms != NULL) : ?>
                                        <li><span class="rpd-featured__rooms"><i class="icon icon-remax-bed"></i> <?= $featured_property->bedrooms ?></span></li>
                                    <?php endif; ?>
                                        <?php if ($featured_property->bathrooms != NULL) : ?>
                                        <li><span class="rpd-featured__bathrooms"><i class="icon icon-remax-bathroom"></i> <?= $featured_property->bathrooms ?></span></li>
                                    <?php endif; ?>
                                        <?php if ($featured_property->sqm_construction != NULL) : ?>
                                        <li><span class="rpd-featured__sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $featured_property->sqm_construction ?></span>mt</span></li>
                                    <?php elseif ($featured_property->sqm_land != NULL) : ?>
                                        <li><span class="rpd-featured__sqm-construction"><i class="icon icon-remax-meters"></i> <span><?= $featured_property->sqm_land ?></span>mt</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </a></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>