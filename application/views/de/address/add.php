<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Adresse Erstellen</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Adresse Erstellen</h2></div>
            <form action="#" method="post" class="form user_share_form user_form mlr70" name="add">
                <ul class="add_showcon_boxcon">
                    <li class="fix">
                        <label><span>*</span> Vorname:</label>
                        <div class="right_box">
                            <input type="text" value="" name="firstname" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Nachname:</label>
                        <div class="right_box">
                            <input type="text" value="" name="lastname" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Adresse:</label>
                        <div class="right_box">
                            <textarea id="address" class="textarea_long" name="address" onchange="ace2()"></textarea><label class="a1 error" style="display:none;"  generated="true" id="guo_con">Please choose your country.</label>
                        </div>
                    </li>
                    <li class="fix">
                        <label for="country"><span class="strong1">*</span> Land :</label>
                        <div class="right_box">
                        <select name="country" id="country" class="select_style selected304" onchange="changeSelectCountry();$('#country').val($(this).val());">
                            <option value="">EIN LAND WÄHLEN</option>
                            <?php if (is_array($countries_top)): ?>
                                <?php foreach ($countries_top as $country_top): ?>
                                    <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                                <?php endforeach; ?>
                                <option disabled="disabled">———————————</option>
                            <?php endif; ?>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </li>
                    <li class="fix states">
                        <?php
                        $stateCalled = Kohana::config('state.called');
                        foreach ($stateCalled as $name => $called)
                        {
                            $called = str_replace(array('County', 'Province'), array('Bundesland', 'Provinz'), $called);
                            ?>
                            <div class="call" id="call_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                            </div>
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
                            <div class="all JS_drop" id="all_<?php echo $country; ?>" style="display:none;">
                                <select name="" class="select_style selected304" onblur="$('#state').val($(this).val());" onchange="acecoun()">
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
                            <?php
                        }
                        ?>
                        <div class="right_box all" id="all_default">
                            <input type="text" name="state" id="state" class="text text_long" value="" maxlength="320" onblur="$('#shipping_state').val($(this).val());" onchange="acecoun()"   />
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
                    <li class="fix">
                        <label><span>*</span> Stadt / Ort:</label>
                        <div class="right_box">
                            <input type="text" id="city" value="" name="city" class="text text_long"onchange="acedoun()"  />
							<label class="error a4" style="display:none;"  generated="true" id="guo_eon">Please choose your country.</label>
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> PLZ:</label>
                        <div class="right_box">
                            <input type="text" id="zip" value="" name="zip" class="text text_long" onchange="ace()" />
							<label class="error" style="display:none;" generated="true" id="guo_fon">Please choose your country.</label>            
							<em style="display:block;">Bitte geben Sie Ihre Postleitzahl ein (oder 0000, wenn keine Postleitzahl in Ihrem Land erforderlich ist). </em>
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Telefon:</label>
                        <div class="right_box">
                            <input type="text" id="phone" value="" name="phone" class="text text_long" />
                            <em style="display:block;">Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für 
                                pünktliche Lieferung von Postbote.</em>
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <input type="checkbox" name="default" value="1" class="radio" id="default" /> 
                        <label for="default" style="float:none;width: 60%;">Machen Sie dies als Ihre Standard Lieferadresse.</label>
                    </li>

                </ul>
                <div class="center">
                    <input type="submit" id="submitAdd" value="SPEICHERN & NEUE HINZUFÜGEN" class="view_btn btn26" style="width: 300px;" />
                    <input type="reset" value="ABBRECHEN" class="view_btn btn26" />
                </div>
            </form>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
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
            $("#guo111").html('請輸入中文地址(Please enter the address in Chinese.)');
        }else{
            $("#guo111").hide();
        }   
}
function acecoun(){
    var s = $("#state").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('Bundesland / Provinz mit Ziffern? Bitte überprüfen Sie es noch einmal');
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