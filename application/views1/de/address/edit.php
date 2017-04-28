<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary"> > KONTOÜBERSICHT</a> > ADRESSE EDITIEREN
			</div>
			<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;</div><?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
		<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>ADRESSE EDITIEREN</h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form class="user-form user-share-form col-sm-8 col-xs-12" id="addAddress" method="post" name="addAddress" action="">
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> Vorname:
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12 allInput" type="text" id="firstname" name="firstname" value="<?php echo $address['firstname']; ?>">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> Nachname:
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12 allInput" type="text" id="lastname" name="lastname" value="<?php echo $address['lastname']; ?>">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> Adresse:
								</label>
								<div class="col-sm-9 col-xs-12">
									<textarea id="address" class="textarea-long col-sm-12 col-xs-12 allInput" name="address" onchange="ace2()" ><?php echo $address['address']; ?></textarea><label class="a1 error" style="display:none;"  generated="true" id="guo_con">Please choose your country.</label>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span> Land:</label>
								<div class="col-sm-9 col-xs-12">
									<div class="wdrop">
										<select  name="country" id="country" class="selected-option col-sm-12 col-xs-12" onchange="changeSelectCountry();$('#country').val($(this).val());">
											<option value="">EIN LAND WÄHLEN</option>
                    <?php 
                    if(isset($countries_top))
                    {
                        if (is_array($countries_top)): ?>
                        <?php foreach ($countries_top as $country_top): ?>
                            <option value="<?php echo $country_top['isocode']; ?>" <?php echo $address['country'] == $country['isocode'] ? 'selected' : ''; ?>><?php echo $country_top['name']; ?></option>
                        <?php endforeach; ?>
                        <option disabled="disabled">———————————</option>
                    <?php endif;
                    }
                    ?>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['isocode']; ?>" <?php echo $address['country'] == $country['isocode'] ? 'selected' : ''; ?> ><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
                </select>
									</div>
								</div>
							</li>
				<li class="states">
        <?php
        $stateCalled = Kohana::config('state.called');
        foreach ($stateCalled as $name => $called)
        {
            $called = str_replace(array('County', 'Province'), array('Bundesland', 'Provinz'), $called);
            ?>
					<label class="call col-sm-3 col-xs-12" id="call_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>><span>*</span> <?php echo $called; ?></label>
            <?php
        }
        $stateArr = Kohana::config('state.states');
        foreach ($stateArr as $country => $states)
        {
            if($country == "US")
            {
                $enter_title = 'Einen Bundesstaat Eingeben';
            }
            else
            {
                $enter_title = ' Ein(e) Bundesland/Provinz Wählen';
            }
            ?>
					<div class="col-sm-9 col-xs-12">
						<div class="wdrop all" id="all_<?php echo $country; ?>" style="display:none;">
							<select  name="" class="selected-option col-sm-12  col-xs-12 select_style selected304"  onblur="$('#state').val($(this).val());" onchange="acecoun()">
                                <option value="" class="state_enter">[<?php echo $enter_title; ?>]</option>
								<?php
                   foreach ($states as $coun => $state)
                    {
                        if (is_array($state))
                        {
                            echo '<optgroup label="' . $coun . '">';
                            foreach ($state as $s)
                            {
                                ?>
                                <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                <?php
                            }
                            echo '</optgroup>';
                        }
                        else
                        {
                            ?>
                            <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                            <?php
                        }
                    }
                    ?>
							</select>
						</div>
					</div>
            <?php
        }
        ?>
											<div class="col-sm-9 col-xs-12 all"  id="all_default">
						<input type="text" name="state" id="state" class="text text-long col-sm-12 col-xs-12" value="<?php echo $address['state']; ?>" maxlength="320"  onblur="$('#shipping_state').val($(this).val());"  onchange="acecoun()" />
            <div class="errorInfo"></div>
            <label class="error a3" style="display:none;"  generated="true" id="guo_don">Please choose your country.</label>
					</div>
        <script>
            function changeSelectCountry(){
                        var select = document.getElementById("country");
                        var countryCode = select.options[select.selectedIndex].value;
                        var c_name = 'call_' + countryCode;
                        $(".states .call").hide();
                        if(document.getElementById(c_name))
                        {
                            $(".states #"+c_name).show();
		                    var ooo = $("#guo_con");
						    ooo.hide();
                        }
						else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
						{   
							$(".states #call_Default").show();                        
							var ooo = $("#guo_con");
							ooo.show();
							ooo.html('請輸入中文地址(Bitte geben Sie die Adresse auf Chinesisch ein.)');
						}
                        else
                        { 
                            $(".states #call_Default").show();
				            var ooo = $("#guo_con");
                            ooo.hide();
                        }
                        var s_name = 'all_' + countryCode;
                        $(".states .all").hide();
                        if(document.getElementById(s_name))
                        {
                            $(".states #"+s_name).show();
                        }
                        else
                        {
                            $(".states #all_default").show();
                        }
                        $(function(){
                            $(".states .all select").change(function(){
                                var val = $(this).val();
                                $("#state").val(val);
                            })
                        })
            }
        </script>
				</li>
							<li>

								<label class="col-sm-3 col-xs-12">
									<span>*</span> Stadt / Ort:
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12"  id="city" type="text" name="city" value="<?php echo $address['state']; ?>" onchange="acedoun()">
					<label class="error a4" style="display:none;"  generated="true" id="guo_eon">Stadt / Ort mit Ziffern? Bitte überprüfen Sie es noch einmal.</label>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> PLZ:
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="zip" name="zip" value="<?php echo $address['zip']; ?>" onchange="ace()">
				<label class="error" style="display:none;" generated="true" id="guo_fon">Es scheint, dass es keine Ziffern in der PLZ gibt, überprüfen Sie sie bitte erneut.</label>
        <em style="display:block;">Bitte geben Sie Ihre Postleitzahl ein (oder 0000, wenn keine Postleitzahl in Ihrem Land erforderlich ist).</em>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> Telefon:
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="phone" name="phone" value="<?php echo $address['phone']; ?>">
									<p class="phone-tips col-sm-12 col-xs-12">Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für pünktliche Lieferung von Postbote.</p>
								</div>
							</li>
							<li>
								<label class="col-sm-3 xs-hidden">&nbsp; </label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input id="default" class="radio" type="checkbox" value="1" name="default">
									<span for="default">Machen Sie dies als Ihre Standard Lieferadresse.</span>
								</div>
							</li>
							<li>
								<label class="col-sm-3 xs-hidden">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input class="btn btn-primary btn-sm" type="submit" value="SPEICHERN & NEUE HINZUFÜGEN">
									<input class="btn btn-default btn-sm" type="reset" value="ABBRECHEN">
								</div>
							</li>
						</ul>
					</form>
					<div class="col-sm-2 hidden-xs"></div>
				</div>
			</article>
	
	</div>
</section>

<script>
    $(".form").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Bitte geben Sie Ihren Vornamen ein.",
                maxlength:"Ihren Vornamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            lastname: {
                required: "Bitte geben Sie Ihren Nachnamen ein.",
                maxlength:"Ihren Nachnamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            address: {
                required: "Bitte geben Sie Ihren Adresse ein.",
                rangelength: $.validator.format("Bitte geben Sie 3-100 Zeichen ein.")
            },
            zip: {
                required: "Bitte geben Sie Ihre Postleitzahl ein.",
                rangelength: $.validator.format("Bitte geben Sie 3-10 Zeichen ein.")
            },
            city: {
                required: "Bitte geben Sie Ihre Stadt ein.",
                maxlength:"Ihre Stadt überschreitet eine maximale Länge von 50 Zeichen."
            },
            country: {
                required: "Bitte wählen Sie Ihr Land.",
                maxlength:"Ihr Land überschreitet eine maximale Länge von 50 Zeichen."
            },
            state: {
                required: "Bitte geben Sie Ihren Bundesland / Provinz / Staat ein.",
                maxlength:"Ihren Bundesland überschreitet eine maximale Länge von 50 Zeichen."
            },
            phone: {
                required: "Bitte geben Sie Ihre Telefon ein.", 
                rangelength: $.validator.format("Bitte geben Sie eine Telefonnummer innerhalb von 6-20 Ziffern ein.")
            }
        }
    });
	
function ace2(){
   var select = document.getElementById("e_country");
   var countryCode = select.options[select.selectedIndex].value;
        if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
        {   
            $("#guo111").show();
            $("#guo111").html('請輸入中文地址(Bitte geben Sie die Adresse auf Chinesisch ein.)');
        }else{
            $("#guo111").hide();
        }   
}
function acecoun(){
    var s = $("#state").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('Bundesland / Provinz mit Ziffern? Bitte überprüfen Sie es noch einmal.');
        }else{
            $("#guo_don").hide();
        }   
}

function acedoun(){
    var s = $("#city").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html('Stadt / Ort mit Ziffern? Bitte überprüfen Sie es noch einmal.');
        }else{
            $("#guo_eon").hide();
        }   
}

function ace(){
    var s = $("#zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
        if(re.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("Es scheint, dass es keine Ziffern in der PLZ gibt, überprüfen Sie sie bitte erneut.");
    }else{
        $("#guo_fon").hide();
    }
}

function check_address(datas)
{
        var s = datas.zip; 
        var re = /^[a-zA-Z]{3,10}$/;
        var c = datas.state;
        var ct = datas.city;
        var ret = /.*\d+.*/;
    // if(re.test(s)){
        // $("#guo222").show();
        // $("#guo222").html("It seems that there are no digits in your code, please check the accuracy.");
    // }else{
        // $("#guo222").hide();
    // }
    if(!trim(datas.firstname) || !trim(datas.lastname) || !trim(datas.address) || !trim(datas.country) || !trim(datas.state) || !trim(datas.city) || !trim(datas.zip) || !trim(datas.phone) || datas.address.length>100 || datas.address.length<3 || (re.test(s)) || (ret.test(c)) || (ret.test(ct)) || datas.phone.length>20 || datas.phone.length<6 || s.length>10 || s.length<3) 
        return 0;
    else
        return 1;
}

$("form[name='add']").submit(function(){
    var datas = createData(this);
    if(!check_address(datas))
        return false;

})



function createData(formObj){
    var datas = new Object();
    formElement = $(formObj).find("input,select,textarea");
    formElement.each(function(i,n){
        datas[$(n).attr("name")] = $(n).val();
    });
    return datas;
}

function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
</script>
