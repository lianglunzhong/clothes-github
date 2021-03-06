<style>
.order-list{margin-top:38px;}
.order-list table th,.order-list table td{ padding:10px; text-align:center; border:#e4e4e4 1px solid;text-transform:capitalize;}
.order-list table th{padding:8px;}
.order-list table td:second-child{text-decoration:underline;}
.order-list-btn{color:#fff; text-transform:uppercase; text-align:center; display:inline-block; cursor:pointer; background:#D8271C;padding:3px 12px;}
.order-list-btn:hover{ color:#fff;background:#ed7971;text-decoration:none;}
.recently-viewed{margin-top:40px; overflow:hidden;}
#personal-recs {
    width: 100%;
}
#personal-recs img {
    width: 157px;
}
.w_tit {
    border-bottom: 2px solid #000;
    margin-bottom: 20px;
    text-align: center;
}
.w_tit h2 {
    background-color: #fff;
    color: #000;
    display: inline-block;
    font-size: 18px;
    font-weight: normal;
    padding: 0 15px;
    position: relative;
    text-transform:capitalize;
    top: 8px;
}
.hide1{display:none;}
.hide-box1_0 li p b, .hide-box1_1 li p b, .hide-box1_2 li p b, .hide-box1_3 li p b{color: #000}
.box-current1{width:100%;height:30px;}
.box-current1 ul{margin-left:365px;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  SOMMAIRE DE COMPTE</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <dl class="box1">
                <dt>Bonjour, <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> . Bienvenue sur Choies.</dt>
                <?php
                $points = $customer->points();
                if ($customer->is_celebrity()):
                    ?>
                    <dd>Points Totaux:<span class="red"><?php echo $points; ?></span></dd>
                    <?php
                elseif (!$customer->get('vip_level')):
                    ?>
                    <dd>Points Totaux:<strong class="red mr10"><?php echo $points ? $points : 0; ?></strong>Total d'achat: <strong class="red">0</strong></dd>
                    <dd>Votre niveau: { Non VIP }</dd>
                    <dd>Dépenser plus de 1€, vous deviendrez un membre VIP.</dd>
                    <?php
                else:
                    $vip_level = $customer->get('vip_level');
                    $vip = DB::select()->from('vip_types')->where('level', '=', $vip_level)->execute()->current();
                    $called = array(
                        1 => '',
                        2 => 'Bronze',
                        3 => 'Silver',
                        4 => 'Gold',
                        5 => 'Diamond'
                    );
                    ?>
                    <dd>Points Totaux: <strong class="red mr10"><?php echo $points; ?></strong></dd>
                    <dd>Votre niveau: { <?php echo $called[$vip_level]; ?> VIP }</dd>
                    <?php
                    if ($vip_level < 5):
                        $vip_called = $called[$vip_level + 1];
                        $vip_called = str_replace(array('Bronze','Silver','Gold','Diamond'), array('de Bronze','d\'Argent','d\'Or','de Diamant'), $vip_called);
                        ?>
                        <dd>Verbringen Sie mehr als <?php echo Site::instance()->price($vip['condition'], 'code_view'); ?>, werden Sie {<?php echo $vip_called; ?> VIP werden}.</dd>
                        <?php
                    endif;
                    ?>
                <?php
                endif;
                $customer_id = $customer->get('id');
                $country = $customer->get('country');
                if (!$country)
                {
                    $country = DB::select('shipping_country')
                            ->from('orders')
                            ->where('customer_id', '=', $customer_id)
                            ->where('payment_status', '=', 'verify_pass')
                            ->execute()->get('shipping_country');
                    if($country)
                        DB::update('customers')->set(array('country' => $country))->where('id', '=', $customer_id)->execute();
                }
                if ($country)
                {
                    $country_customers = DB::select('id')->from('customers')->where('country', '=', $country)->execute()->as_array();
                    $find = array('id' => $customer_id);
                    $array_keys = array_keys($country_customers, $find);
                    $rank = $array_keys[0];
                    $country_name = DB::select('name')->from('countries')->where('isocode', '=', $country)->execute()->get('name');
                    $count_counrty = count($country_customers);
                    if($count_counrty > 50);
                    {
                        $rank += 50;
                        if($rank > $count_counrty)
                            $rank = $count_counrty;
                    }
                    ?>
                    <dd>Il y a déjà <?php echo $count_counrty; ?> membres de Choies dans votre pay <?php echo $country_name; ?>, votre rang est #<?php echo $rank; ?></dd>
                    <?php
                }
                $order_total = $customer->get('order_total');
                $vip_level = $customer->get('vip_level');
                $vip_amount = array();
                $vips = DB::select('level', 'condition')->from('vip_types')->execute()->as_array();
                foreach($vips as $v)
                {
                    $vip_amount[$v['level']] = $v['condition'];
                }
                $margin_right = 0;
                if ($vip_level == 0)
                {
                    $vip_left = 0;
                    $vip_width = 0;
                    $margin_right = 48;
                }
                elseif ($vip_level == 1)
                {
                    $extra = ($order_total - $vip_amount[0]) / ($vip_amount[1] - $vip_amount[0]);
                    $vip_left = 130 + floor($extra * 148);
                    $vip_width = 182 + floor($extra * 148);
                }
                elseif ($vip_level == 5)
                {
                    $vip_left = 705;
                    $vip_width = 745;
                }
                else
                {
                    $extra = ($order_total - $vip_amount[$vip_level - 1]) / ($vip_amount[$vip_level] - $vip_amount[$vip_level - 1]);
                    $vip_left = 130 + ($vip_level - 1) * 148 + floor($extra * 148);
                    $vip_width = 185 + ($vip_level - 1) * 148 + floor($extra * 148);
                }

                if ($vip_left > 668)
                {
                    $margin_right = 668 - $vip_left - 23;
                    $vip_left = 668;
                }
                ?>
            </dl>
            <div class="user_vip">
                <div class="user_vip_cursor" style="left:<?php echo $vip_left; ?>px;">
                    <span>Total de Commande:<?php echo Site::instance()->price($order_total, 'code_view', 'USD', array('name'=>'USD','code'=>'$','rate'=>1)); ?></span>
                    <em style="margin-right:<?php echo $margin_right; ?>px;"></em>
                </div>
                <div class="user_vip_b"></div>
                <div class="user_vip_t" style="width:<?php echo $vip_width; ?>px;"></div>
                <div class="user_vipname">
                    <span class="first">NON VIP</span>
                    <span>VIP</span>
                    <span>VIP Bronze</span>
                    <span>VIP Argent</span>
                    <span>VIP Or</span>
                    <span class="last">VIP Diamant</span>
                </div>
            </div>
            <p class="center"><a class="view_btn btn26 btn40 JS_click">VOIR LA POLITIQUE VIP</a></p>
            <!-- vip -->
            <div class="vip JS_clickcon hide">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Privilèges</div>
                    <div>Niveau VIP</div>
                    </th>
                    <th width="20%">Montant accumulé  de transaction</th>
                    <th width="16%">Rabais supplémentaires sur articles</th>
                    <th width="16%">Autorisation de l'utilisation des points</th>
                    <th width="15%">Points de récompense de commande</th>
                    <th width="18%">D'autres privilèges</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>Vous pouvez utiliser les points équivalant à seulement 10% de la valeur de votre commande.</div></td>
                        <td rowspan="6">$1 = 1 point</td>
                        <td>Bon de réduction de 15%</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="Diamond VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Obtenir des points doubles d'achat pendant les grandes fêtes.<br/>
                            Cadeau d'anniversaire<br/>
                            Et plus...</div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="Bronze VIP"></span><strong>VIP Bronze</strong></td>
                        <td>$199 - $399</td>
                        <td>5% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="Silver VIP"></span><strong>VIP Argent</strong></td>
                        <td>$399 - $599</td>
                        <td>8% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="Gold VIP"></span><strong>VIP Or</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="Diamond VIP"></span><strong>VIP Diamant</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% de réduction</td>
                    </tr>
                </table>
            </div>
            <!--order-list-->
            <?php if(!empty($orders)){ ?>
            <div class="order-list fix">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr bgcolor="#e4e4e4">
                    <th width="20%"><strong>Date De Commande</strong></th>
                    <th width="20%"><strong>No. De Commande</strong></th>
                    <th width="15%"><strong>Total</strong></th>
                    <th width="15%"><strong>Livraison</strong></th>
                    <th width="15%"><strong>Statut De Commande</strong></th>
                    <th width="15%"><strong>Action</strong></th>
                  </tr>
                  <?php foreach($orders as $order){ 
                    $currency = Site::instance()->currencies($order['currency']);
                    ?>
                  <tr>
                    <td><?php echo date('n/j/Y H:i:s', $order['created']); ?></td>
                    <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></td>
                    <td><?php echo $currency['code'] . round($order['amount'], 2); ?></td>
                    <td><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                    <td>
                    <?php
                        if($order['refund_status'])
                        {
                            $status = $order['refund_status'];
                        }else{
                            if($order['shipping_status']=="new_s" OR $order['shipping_status']=="pre_o")
                            {
                                $status=$order['payment_status'];
                            }else{
                                $status=$order['shipping_status'];
                            }
                        }
                        if ($status == 'new'){ $status = 'Impayé'; }
                        elseif ($status == 'failed'){ $status = 'Échoué'; }
                        elseif ($status == 'success'){ $status = 'Succès'; }
                        elseif ($status == 'pending'){ $status = 'En attendant'; }
                        elseif ($status == 'partial_paid'){ $status = 'Payé partiellement'; }
                        elseif ($status == 'processing'){ $status = 'Traitement'; }
                        elseif ($status == 'shipped'){ $status = 'Expédié'; }
                        elseif ($status == 'partial_shipped'){ $status = 'Expédié partiellement'; }
                        elseif ($status == 'delivered'){ $status = 'Délivré'; }
                        elseif ($status == 'prepare_refund'){ $status = 'Préparer remboursement'; }
                        elseif ($status == 'partial_refund'){ $status = 'Remboursé partiellement'; }
                        elseif ($status == 'refund'){ $status = 'Remboursé'; }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="/track/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">SUIVRE</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass'){ ?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Détails De Commande</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="order-list-btn">Payer</a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Détails De Commande</a>
                    <?php } ?>
                        
                    <?php }?>
                    </td>
                  </tr>
                  <?php } ?>
            </table>
          </div>
          <?php } ?>
        <?php 
            if(!empty($view_history)){
            $i=0; 
            $count=count($view_history);
            $num=ceil($count/5);
        ?>
          <div class="recently-viewed"> 
            <div class="w_tit">
                <h2>Consultés récemment</h2>
            </div>
            <div id="personal-recs">
                <?php foreach($view_history as $id){
                if($i==0){ ?>
                <div class="hide-box1_0">
                <ul>
                <?php }elseif($i%5==0){ ?>
                <div class="hide-box1_<?php echo ceil($i/5); ?> hide1">
                <ul>
                <?php } ?>
                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
                <?php
                $i++;
                if($i%5==0){
                    echo "</ul></div>";
                }
                } ?>
           </div>
       </div>
        <div class="box-current1">
          <ul>
            <li class="on"></li>
            <?php for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
          </ul>
        </div>
        
        <?php }else{ ?>
            <div class="recently-viewed"> 
            <div class="w_tit">
                <h2>Meilleures Ventes</h2>
            </div>
            <div id="personal-recs">
                <?php 
                $i=0;
                $top_seller = Catalog::instance(32)->products();
                foreach($top_seller as $id){
                    if($i>9)break;
                     $stock = Product::instance($id)->get('stock');
                     if ($stock == 0)
                                continue;
                            elseif ($stock == -1)
                            {
                                $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                ->from('product_stocks')
                                                ->where('product_id', '=', $id)
                                                ->where('attributes', '<>', '')
                                                ->execute()->get('sum');
                                if (!$stocks)
                                    continue;
                            }
                if($i==0){ ?>
                <div class="hide-box1_0">
                <ul>
                <?php }elseif($i%5==0){ ?>
                <div class="hide-box1_<?php echo ceil($i/5); ?> hide1">
                <ul>
                <?php } ?>
                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
                <?php
                $i++;
                if($i%5==0){
                    echo "</ul></div>";
                }
                } ?>
           </div>
       </div>
        <div class="box-current1">
          <ul>
            <li class="on"></li>
            <?php 
            $num=ceil($i/5);
            for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
          </ul>
        </div>
        
        <?php } ?>     
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>
<script type="text/javascript">
var f=0;
var t1;
var tc1;
$(function(){
$(".box-current1 li").hover(function(){
$(this).addClass("on").siblings().removeClass("on");
var c=$(".box-current1 li").index(this);
$(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
$(".hide-box1_"+c).fadeIn(150);
f=c;
})
})
</script>