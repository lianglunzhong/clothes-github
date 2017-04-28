<?php
$url = URL::current(0);
$lists = array(
    'MIS PEDIDOS' => array(
        array(
            'name' => 'Historial De Pedidos',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Pedidos Pendientes De Pago',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Lista De Deseos',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Rastrear Pedido',
            'link' => LANGPATH . '/track/track_order'
        ),
    ),
    'MI PERFIL' => array(
        array(
            'name' => 'Configuración de Cuenta',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Cambiar Contraseña',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'La Libreta De Direcciones',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Crear una Dirección ',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'PUNTOS Y CUPONES' => array(
        array(
            'name' => 'Historial De Puntos',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Mis Cupones',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['MI PERFIL'][] = array(
        'name' => 'Mi show del blog',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="fll">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user_home">RESUMEN DE CUENTA</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category_box aside_box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll_list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a rel="nofollow" href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
</aside>