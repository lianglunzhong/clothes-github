<?php
$url = URL::current(0);
$lists = array(
    'Мои Заказы' => array(
        array(
            'name' => 'История заказов',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Неоплаченные Заказы',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Избранное',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Отслеживать заказ',
            'link' => LANGPATH . '/track/track_order'
        ),
    ),
    'МОЙ ПРОФИЛЬ' => array(
        array(
            'name' => 'Настройка профиля',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Изменение пароля',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Адресная книга',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Создать адрес',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'Мои Купоны и баллы' => array(
        array(
            'name' => 'История баллов',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Мои купоны',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['МОЙ ПРОФИЛЬ'][] = array(
        'name' => 'Мое шоу блога',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="fll">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user_home">Личный кабинет</a>
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