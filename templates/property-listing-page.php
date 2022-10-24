<?= do_shortcode('[remax-properties-search]'); ?>

<div class="rp-container">
    <div class="card-container <?= $card_container_class ?>">

        <?php foreach ($properties->data as $property) : ?>
            <div class="card"><a href="<?= $page_url . "?code={$property->id}" ?>" title="<?= $property->realestate_type_language->description ?> en Alquiler en <?= $property->sector->description ?>, <?= $property->city->description ?>" id="article" class="card--property ">
                    <div class="card__thumbnail" style="background-image: url(&quot;https://images.remaxrd.com/media/pictures/small/<?= $property->pictures[0]->path ?>&quot;);">

                        <!-- <img class="card__thumbnail__exclusive" src="https://remaxrd.com/assets/img/exclusiva.png" style="position: absolute; right: 0px; top: 0px;"> -->

                        <!-- <img src="/assets/img/master_broker.png" style="position: absolute; right: 0px; top: 0px;"> -->
                    </div>
                    <div class="card__content">
                        <div class="card__description">
                            <p class="card__description__title"><?= $property->realestate_type_language->description ?></p>
                            <p class="card__description__address__mansory"><span><?= $property->sector->description . ', ' . $property->city->description ?></span></p>
                            <div>
                                <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Código</p>
                                <p class="card__description__title mb-10"><span><?= $property->id ?></span></p>

                                <?php if (isset($property->price) && $property->price > 0) : ?>
                                    <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;"><?= $property->businesstype_language->description ?></p>
                                    <p class="card__description__price mb-10"><span><?= $property->currency->nostd_iso ?>$ <span><?= number_format($property->price, 0, '.', ','); ?></span></p>
                                <?php endif; ?>
                                
                                <?php if (isset($property->alternate_price) && $property->alternate_price > 0) : ?>
                                    <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Alquiler</p>
                                    <p class="card__description__price mb-10"><span><?= isset($property->alt_currency->nostd_iso) ? $property->alt_currency->nostd_iso : $property->currency->nostd_iso ?>$ <span><?= number_format($property->alternate_price, 0, '.', ','); ?></span></p>
                                <?php endif; ?>

                                <?php if (isset($property->project[0]->minimum_price) && $property->project[0]->minimum_price > 0) : ?>
                                    <p class="card__description__title--small" style="font-family: unset; font-size: 12.5px;">Venta</p>
                                    <p class="card__description__price mb-10"><span><?= $property->currency->nostd_iso ?>$ <span><?= number_format($property->project[0]->minimum_price, 0, '.', ','); ?> - <?= number_format($property->project[0]->maximum_price, 0, '.', ','); ?></span></p>
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
        <?php endforeach; ?>

    </div>

    <?php if (is_active_sidebar('rpl_sidebar')) : ?>
        <div class="rpl-sidebar">
            <?php dynamic_sidebar('rpl_sidebar'); ?>
        </div>
    <?php endif; ?>

    <?php if ($properties->last_page > 1) : ?>
        <section class="paginacion">
            <ul>
                <?php
                $paginations = [];
                if(isset($_GET['pag'])) {
                    if(isset($_GET['property-status'])) {
                        $request_uri = str_replace("&pag={$_GET['pag']}", "", $_SERVER['REQUEST_URI']);
                        $pagination_url = get_option('home') . $request_uri . '&';
                    } else {
                        $request_uri = str_replace("?pag={$_GET['pag']}", "", $_SERVER['REQUEST_URI']);
                        $pagination_url = get_option('home') . $request_uri . '?';
                    }
                } else {
                    if(isset($_GET['property-status'])) {
                        $pagination_url = get_option('home') . $_SERVER['REQUEST_URI'] . '&';
                    } else {
                        $pagination_url = get_option('home') . $_SERVER['REQUEST_URI'] . '?';
                    }
                }

                foreach ($properties->links as $post => $link) {
                    if ($link->url != NULl && $post == 0) {
                        $p = strpos($link->url, '=');
                        $text = substr($link->url, $p, strlen($link->url));
                        $prev = "<li><a href='{$pagination_url}pag{$text}'>&laquo;</a></li>";
                    } elseif ($link->url != NULl && $post == count($properties->links) - 1) {
                        $p = strpos($link->url, '=');
                        $text = substr($link->url, $p, strlen($link->url));
                        $next = "<li><a href='{$pagination_url}pag{$text}'>&raquo;</a></li>";
                    } elseif ($link->url != NULl) {
                        if ($link->active == false) {
                            array_push($paginations, "<li><a href='{$pagination_url}pag={$link->label}'>{$link->label}</a></li>");
                        } else {
                            $active_post = $post - 1;
                            array_push($paginations, "<li><a href='{$pagination_url}pag={$link->label}' class='active'>{$link->label}</a></li>");
                        }
                    }
                }

                if (isset($prev)) {
                    echo $prev;
                }
                foreach ($paginations as $post => $pagination) {
                    if ($active_post > 2) {
                        if ($post <= $active_post + 2 && ($post >= $active_post - 2 || ($post >= count($paginations) - 5 && $post <= count($paginations)))) {
                            echo $pagination;
                        }
                    } else {
                        echo $pagination;
                        if ($post >= 4) {
                            break;
                        }
                    }
                }

                if (isset($next)) {
                    echo $next;
                }

                ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (is_active_sidebar('rp_footerbar')) : ?>
        <div class="rp-footerbar">
            <?php dynamic_sidebar('rp_footerbar'); ?>
        </div>
    <?php endif; ?>
</div>