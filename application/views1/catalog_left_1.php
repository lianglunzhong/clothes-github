    <?php
    $attributes = DB::select('id', 'label')->from('attributes')->where('id', '>', 3)->execute('slave');
    $attrArr = array();
    foreach($attributes as $attr)
    {
        $attrArr[$attr['label']] = $attr['id'];
    }
    $uri = Request::Instance()->uri;
    $language = Request::Instance()->param('language');
    if($language)
    {
        $uri = substr($uri, strpos($uri, '/') + 1);
    }
    $links = explode('/', $uri);
    if(!isset($links[3]))
        $links[3] = '';
    $catalog_link = $links[0];
    if (!isset($links[1]))
        $links[1] = 'all';
    if (!isset($links[2]))
        $links[2] = 'all';
    $keysorts = 'site_sort/'.$catalog_id;
    $cache = Cache::instance('memcache');
    if (!($sorts = $cache->get($keysorts)))
    {
    $sorts = DB::select('sort', 'attributes')
            ->from('catalog_sorts')
            ->where('catalog_id', '=', $catalog_id)
            ->order_by('sort')
            ->execute('slave')->as_array();
        $cache->set($keysorts, $sorts, 1800);
    }
    $parent_id = DB::select('parent_id')->from('catalogs')->where('id', '=', $catalog_id)->execute('slave')->get('parent_id');
    if (empty($sorts))
    {
        $sorts = DB::select('sort', 'attributes')
                ->from('catalog_sorts')
                ->where('catalog_id', '=', $parent_id)
                ->order_by('sort')
                ->execute('slave')->as_array();
    }
    $filters = array();
    if (isset($links[3]))
    {
        $filter = explode('__', $links[3]);
        foreach ($filter as $f)
        {
            $fil = explode('_', $f);
            if (isset($fil[1]))
            {
                $filters[str_replace('-', ' ', $fil[0])] = str_replace('-', ' ', $fil[1]);
            }
        }
    }
    $limit_link = '';
    $gets = array();
    foreach ($_GET as $name => $val)
    {
        if ($name == 'limit')
            $gets[] = 'limit=' . $val;
        if ($name == 'pick')
            $gets[] = 'pick=' . $val;
        if ($name == 'sort')
            $gets[] = 'sort=' . $val;
    }
    if (!empty($gets))
        $limit_link = '?' . implode('&', $gets);

    $colors = '';
    foreach ($sorts as $key => $sort)
    {
        if ($sort['sort'] == 'Color')
        {
            $colors = $sort['attributes'];
            unset($sort[$key]);
            break;
        }
    }

    $children = array();
    $childrens = array();

/*    if ($catalog_id == 92 OR $parent_id == 92)
    {
        $childrens = array(
            array('Dresses', '/dresses-c-92'),
            array('Maxi Dresses', '/maxi-dresses-c-207'),       
            array('Lace Dresses', '/lace-dresses-c-209'),
            array('Bodycon Dresses', '/bodycon-dresses-c-211'),
            array('Off Shoulder Dresses', '/off-the-shoulder-dresses-c-504'),
            array('Black Dresses', '/black-dresses-c-203'),
            array('White Dresses', '/white-dresses-c-204'),
            array('Backless Dresses', '/backless-dress-c-456'),
            array('Party Dresses', '/party-dresses-c-205')
        );
    }
    else
    {*/
        $children = array();
        $children = DB::select('id', 'name', 'link')->from('catalogs')
                ->where('site_id', '=', 1)
                ->where('visibility', '=', 1)
                ->where('on_menu', '=', 1)
                ->where('parent_id', '=', $catalog_id)
                ->order_by('position', 'desc')
                ->execute()->as_array();
        if (empty($children))
        {
            if ($parent_id == 0)
            {
                $children[] = array(
                    'id' => $catalog_id,
                    'name' => Catalog::instance($catalog_id)->get('name'),
                    'link' => Catalog::instance($catalog_id)->get('link')
                );
            }
            else
            {
                $children = DB::select('id', 'name', 'link')->from('catalogs')
                        ->where('site_id', '=', 1)
                        ->where('visibility', '=', 1)
                        ->where('on_menu', '=', 1)
                        ->where('parent_id', '=', $parent_id)
                        ->order_by('position', 'desc')
                        ->execute()->as_array();
                $parent[] = array(
                    'id' => $parent_id,
                    'name' => Catalog::instance($parent_id)->get('name'),
                    'link' => Catalog::instance($parent_id)->get('link')
                );
                $children = array_merge($parent, $children);
            }
        }
        else
        {
            $parent[] = array(
                'id' => $catalog_id,
                'name' => Catalog::instance($catalog_id)->get('name'),
                'link' => Catalog::instance($catalog_id)->get('link')
            );
            $children = array_merge($parent, $children);
        }
    //}
    $scroll = 1;
    ?>        
<div class="list-main">
    <div class="loading hidden-xs hide"></div>
    <aside class="filter-left hidden-xs">
        <?php
        if(!$is_mobile)
        {
        ?>
        <div class="category-list">
            <div class="leftlist">
            <?php
            if(count($children) > 1 OR count($childrens) > 1)
            {
            ?>
                <p class="down "><span class="list-detail-title">Category</span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu sub-menu" style="display: block; overflow: hidden;" id="catalog_ul">
                </ul>
            <?php
            }
            ?>
                <h3>REFINE BY:</h3>
                <ul class="bar-l" id="bar">
                </ul>
                <p class="down no-line"><span class="list-detail-title">Size</span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide double" id="size_ul" style="display: block;">
                </ul>
                <p class="down "><span class="list-detail-title">Color</a></span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide double" id="color_ul" style="display: block;">
                </ul>
                <p class="down "><span class="list-detail-title">Price</span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide" id="price_ul" style="display: block;">
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
    </aside>
    <div class="filter-right">
        <div class="filter-bar">
            <?php
            $has = 0;
            $gets1 = $gets;
            if (!empty($gets1))
            {
                foreach ($gets1 as $key => $get)
                {
                    if (strpos($get, 'pick') !== FALSE)
                    {
                        $has = 1;
                        $gets1[$key] = 'pick=1';
                        break;
                    }
                }
                if (!$has)
                    $gets1[] = 'pick=1';
            }
            else
                $gets1[] = 'pick=1';
            ?>
            <ul class="bar-r">
                <li class=" item-r pick <?php if($has) echo 'pick-on'; ?>">
                    <a href="<?php echo '?' . implode('&', $gets1); ?>" class=""> Icon's Pick</a>
                </li>
                <li class=" drop-down cs-show">
                    <span class="fll">Sort By:&nbsp;</span>
                    <div class="drop-down-hd">
                            <?php
                                $getsort = '';
                                if(isset($_GET['sort']))
                                {
                                    $getsort = $_GET['sort'];                    
                                }

                                if(array_key_exists($getsort, $sort_by))
                                {
                                    echo isset($getsort) ? $sort_by[$getsort]['name'] : 'Default';
                                }
                                else
                                {
                                    echo 'Default';
                                }
                              ?>
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <ul class="drop-down-list cs-list" style="width:110%;">
                        <?php
                        foreach($gets1 as $k => $g)
                        {
                            if (strpos($g, 'sort') !== FALSE || strpos($g, 'pick') !== FALSE)
                                unset($gets1[$k]);
                        }
                        foreach ($sort_by as $key => $sort)
                        {
                            $link = empty($gets1) ? '' : '?' . implode('&', $gets1);
                            if($link == "")
                            {
                                $tolink = $link . '?sort=' . $key;
                            }
                            else
                            {
                                $tolink = $link . '&sort=' . $key;
                            }
                            ?>
                            <li class="drop-down-option">
                                <a href="<?php echo $tolink; ?>"><?php echo $sort['name']; ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <div class="flr hidden-xs pagination_div"></div>
        </div>
        <ul class="drop-down-list JS-toggle-box filterall" style="width: 580px; left: -342px; top: 28px; display: none;">
            <div class="JS-filterClose fa-2x flr mr5 mt5"><i class="close-btn3"></i></div>
            <div class="clearfix"></div>
            <div class="filter-list flr">
                <!-- category    -->
                <?php
                $phone_childrens = array();
                if(count($children) > 1 OR count($childrens) > 1)
                {
                ?>
                    <li class="item choice cs-show">
                        <div class="choice-hd">
                            Category <i class="fa fa-chevron-down"></i>
                        </div>
                        <ul class="choice-list cs-list" id="catalog_choice">
                            <?php
                            if ($catalog_id == 92 OR $parent_id == 92)
                            {
                                $url = '/' . $uri;
                                foreach ($children as $key => $c)
                                {
                                    $on = 0;
                                    if ($c['id'] == $catalog_id)
                                        $on = 1;
                                    $phone_childrens[] = array('name' => $c['name'], 'link' => '/'.$c['link'].'-c-'.$c['id'], 'on' => $on);
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="/<?php echo $c['link'].'-c-'.$c['id']; ?>">
                                            <?php echo $c['name']; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            else
                            {
                                foreach ($children as $catalog)
                                {
                                    $on = 0;
                                    if ($catalog['id'] == $catalog_id)
                                        $on = 1;
                                    $clink = LANGPATH . '/' . $catalog['link'] . '-c-' . $catalog['id'] . '/' . $links[1] . '/' . $links[2] . '/' . $links[3];
                                    $phone_childrens[] = array('name' => ucfirst($catalog['name']), 'link' => $clink, 'on' => $on);
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo $clink ; ?>">
                                            <?php echo ucfirst($catalog['name']); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>

                <?php
                }
                ?>
                
            </div>
        </ul>


<script type="text/javascript">
    $(function(){
        $("#catalog_ul").html($("#catalog_choice").html());
        $(".filter_checkbox").live('click', function(){
            var link = $(this).attr('attr-value');
            location.href = link;
        })
    })
</script>

<?php
if($is_mobile)
{
?>
<div class="category-sidebar sidebar">
    <div class="category-sidebar-container">
        <div class="sidebar-nav ">
            <h5 class="sort-nav-toggle JS-toggle">
                <span><b class="visible-phone">SORT &amp;</b> REFINE<i class="fa fa-caret-down"></i></span>
            </h5>
            <ul class="bar-l" id="bar"></ul>
            <div class="sort-nav-section JS-toggle-box hide" id="phone_filter" style="overflow: hidden; display: none;">
                <div class="accordion category-list">
                <?php
                if(!empty($phone_childrens))
                {
                ?>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Category<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled">
                                <?php
                                foreach($phone_childrens as $key => $pcatalog)
                                {
                                    if($key == 0)
                                    {
                                        $view_all = $pcatalog;
                                        continue;
                                    }
                                ?>
                                    <li class="selector" ><a href="<?php echo $pcatalog['link']; ?>"><?php echo $pcatalog['name']; ?></a></li>
                                <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Size<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="size_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Price<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="price_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle" href="javascript:void(0);">Color<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="color_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<div id="bar1" class="hide">Clear All</div>

