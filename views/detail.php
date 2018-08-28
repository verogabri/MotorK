<!DOCTYPE html>
<html lang="it-IT" prefix="og: http://ogp.me/ns#">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex,nofollow">
    <title>MK Dealer:detail</title>

    <link rel="stylesheet" href="/assets/multimodel.style.css" type="text/css" media="all">
</head>

<body>

<main role="main" class="multimodel step-first">
    <header class="multimodel__masthead">
        <div class="multimodel__header">
            <a href="http://localhost:8888/"><h1>MK Cars</h1></a>
        </div>
    </header>
    
    <div id="multimodel__wrapper" class="multimodel__wrapper">
    	
        <section class="multimodel__slider">
            <div class="grid">
                <div class="grid__item u-12/12--medium u-6/12--large u-4/12--large">
                    <article class="" data-id="<?=$car->data->attrs->carId?>">
                        <figure class="card__picture">
                            <div class="card__image">
                                <img src="<?=$car->data->attrs->img?>">
                            </div>
                        </figure>
                        <footer class="card__info">
                        	<span class="make u-text--center"><?=$car->data->attrs->make?></span>
                            <span class="model u-text--center"><?=$car->data->attrs->model?></span>
                            <br>
                            <span class="make u-text--center"><?=$car->data->attrs->submodel?></span>
                            <span class="make u-text--center">Year: <?=$car->data->attrs->year?></span>
                        </footer>
                        
                        <footer class="card__info">
                        	<ul>
                        	<? if(isset($tags['Segment'])) { ?>
                        		<li><span class="make">Segment: <?=$tags['Segment']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Internal space'])) { ?>
                        		<li><span class="make">Internal space: <?=$tags['Internal space']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Traction'])) { ?>
                        		<li><span class="make">Traction: <?=$tags['Traction']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Roof'])) { ?>
                        		<li><span class="make">Roof: <?=$tags['Roof']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Fuel type'])) { ?>
                        		<li><span class="make">Fuel type: <?=$tags['Fuel type']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Look'])) { ?>
                        		<li><span class="make">Look: <?=$tags['Look']?></span></li>
                        	<? } ?>
                        	<? if(isset($tags['Accessibility'])) { ?>
                        		<li><span class="make">Accessibility: <?=$tags['Accessibility']?></span></li>
                        	<? } ?>
                        	</ul>
                        </footer>
                        
                    </article>
                </div>
            </div>
        </section>

		<section class="multimodel__content">
			
			<?php if(isset($resultRequest) && $resultRequest===true) { ?>
				
				<div>
					<p>Thank you for your request, we answer as soon as possible</p>
				</div>
				
			<?php } else {?>
		
				<?php if(isset($resultRequest) && $resultRequest===false) { ?>
				<p><b>Sorry, it's seem like there was an error,<br> please try again later</b></p>
				<?php } ?>
	
                <div class="dk-forms">
                    <form method="post" id="leadform">
                    	<input type="hidden" id="idcar"
                               name="idcar"
                               value="<?=$car->data->attrs->carId?>">
                                           
                        <div class="landing-form-fields">
                            <span class="field field__name">
                                <label for="name" class="gui-label">Nome</label>
                                <input type="text" id="name"
                                       name="name"
                                       value="<?=$dataRequest['name']?>"
                                       required="required" class="gui-input">
                            </span>
                            <span class="field field__surname">
                                <label for="surname" class="gui-label">Cognome</label>
                                <input type="text" id="surname"
                                       name="surname"
                                       value="<?=$dataRequest['surname']?>"
                                       required="required" class="gui-input">
                            </span>
                            <span class="field field__email">
                                <label for="email" class="gui-label">Email</label>
                                <input type="email" id="email"
                                       name="email"
                                       value="<?=$dataRequest['email']?>"
                                       required="required"
                                       class="gui-input">
                            </span>
                            <div class="input-group-tel-zipcode">
                                <span class="field field__telephone">
                                    <label for="phone" class="gui-label">Telefono</label>
                                    <input
                                            type="tel" id="phone" placeholder="Telefono"
                                            name="phone"
                                            value="<?=$dataRequest['phone']?>"
                                            inputmode="numeric"
                                            required="required" class="gui-input">
                                </span>

                                <span class="field field__cap">
                                    <label for="zip" class="gui-label">CAP</label>
                                    <input type="tel" id="zip"
                                           name="zip"
                                           value="<?=$dataRequest['zip']?>"
                                           required="required" class="gui-input">
                                </span>
                            </div>
                        </div>
                        <div class="option-group field field__privacy">
                            <input type="checkbox"
                                   name="privacy"
                                   id="privacy"
                                   value="Y"
                                   required="required"
                                   class="gui-checkbox">

                            <label for="privacy" class="option gui-label">
                                <span class="gui-label-text">
                                    Ho letto e accetto <a href="/privacy" target="_blank"> la privacy policy</a>
                                </span>
                            </label>
                        </div>
                        <footer class="multimodel__leadform-cta">
                            <button type="submit" class="leadform__submit cta-primary cta--wide has-transform-active" disabled="disabled">
                                Request quote
                            </button>
                        </footer>
                    </form>
                </div>
                
                <?php } ?>
        </section>
    </div>
    
    
    <?php include CONFIG_VIEWS_DIR . '/inc/similar_cars.php'; ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

	// click on privacy flag to change buttob status
	$('#privacy').on('change',function(){
		if($(this).prop("checked")) {
			$('button[type="submit"]').prop('disabled',false);
		} else {
			$('button[type="submit"]').prop('disabled',true);
		}
	});

	// on sending request
	$('#leadform').on('submit',function(e){
		e.preventDefault();
		e.stopPropagation();

		var form = $(this);
		var dd={};
		var errore = false;
		
		var actionButton = form.find("button[type='submit']");
		actionButton.prop('disabled',true);

		// collect any input value
		var _inputs = form.find("input");
		_inputs.each(function(idx){
			var item = $(this);
			var name = item.attr('name');
			dd[name] = item.val();

		});

		// collect any textarea value
		var _inputs = form.find("textarea");
		_inputs.each(function(idx){
			var item = $(this);
			var name = item.attr('name');
			dd[name] = item.val();

		});

		// collect any select value
		var _selects = form.find("select");
		_selects.each(function(idx){
			var item = $(this);
			var name = item.attr('name');
			dd[name] = item.val();

		});

		// at last any checkbox
		var _checkbox = form.find("input[type='checkbox']");
		_checkbox.each(function(idx){
			var item = $(this);
			var name = item.attr('name');
			if(item.prop('checked')) dd[name] = item.val();

		});

		// TODO: more check on data
		
		dd.response = "json";
		var _link = "http://localhost:8888/saveform";

		if(!errore){
			
			$.ajax({
				url: _link,
				type: "POST",
				data: dd,
				cache: false,
				dataType: 'json',
				success: function(result) {

					if(typeof result.error != "undefined"){

						if(result.error==0) {
							alert('Request was send');

							// TODO: reset all value or something else
						} else {
							alert('There was an error, please try again later');
						}
						
					} else {

						alert("Impossible to send your request");
					}
					
					actionButton.removeAttr('disabled');				
				
				}
			});

		} 

		return false;
	});


});
</script>
</main>
</html>