
    <?php if(isset($similarCars) && is_array($similarCars)) { ?>
    
    <div id="multimodel__wrapper" class="multimodel__wrapper">
        <section class="multimodel__editorial u-hidden-till--small u-margin-top--l">
            <article class="editorial">
                <div class="editorial__content">
                    <p class="editorial__text t1 u-text--center">
                        <strong>Maybe you also like</strong>
                    </p>
                </div>
            </article>
        </section>
        <section class="multimodel__slider">           
            <div class="grid">
            	
                    <?php foreach ($similarCars as $car) { ?>
                    	<?php 
                    	if(isset($car->distance) && $car->distance > 5) break;
                    	?>
                        <div class="grid__item u-12/12--medium u-6/12--large u-4/12--large-x" >
                        <a href="http://localhost:8888/detail/<?=$car->attrs->carId?>">
                            <article class="card" data-id="<?=$car->attrs->carId?>" title="<?=$car->attrs->make; ?> <?=$car->attrs->model; ?>">
                                <figure class="card__picture">
                                    <div class="card__image">
                                        <img src="<?=$car->attrs->img; ?>">
                                    </div>
                                </figure>
                                <footer class="card__info">
                                    <span class="make u-text--center"><?=$car->attrs->make; ?></span>
                                    <span class="model u-text--center"><?=$car->attrs->model; ?></span>
                                    <p class="u-text--center">Car ID: <?=$car->attrs->carId; ?></p>
                                    
                                    
                                    <p class="u-text--center">distance: <?=$car->distance; ?></p>
                                    
                                </footer>
                            </article>
                            </a>
                        </div>
                    <?php } ?>
            </div>
        </section>
    </div>
    
    <?php } else { ?>
    
    <div id="multimodel__wrapper" class="multimodel__wrapper">
        <section class="multimodel__editorial u-hidden-till--small u-margin-top--l">
            <article class="editorial">
                <div class="editorial__content">
                    <p class="editorial__text t1 u-text--center">
                        <strong>There is no similar cars</strong>
                    </p>
                </div>
            </article>
        </section>
	</div>
    <?php } ?>