<div class="fix">
        <span class="pr-nums fll"><?php echo $total_items; ?> 
        <?php if($total_items==1){ 
                        echo "запись"; 
                }elseif($total_items>=2&&$total_items<=4){
                        echo "записи";
                }else{
                        echo "записей";
                }?> Найдено</span>
        <div class="page flr">
                Страницы: 
                <?php if ($previous_page !== FALSE): ?>
                        <span class="prev_btn1"><a href="<?php echo $page->url($previous_page); ?>" rel="nofollow">Предыдущая</a></span>
                <?php endif; ?>
                <?php
                if ($total_pages < 8)
                {
                        for ($i = 1;
                                $i <= $total_pages;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow">' . $i . '</a>';
                                }
                                else
                                {
                                        //echo '<a href="'.$page->url($i).'">'.$i.'</a>';
                                        echo '<a class="on">' . $i . '</a>';
                                }
                        }
                }
                elseif ($current_page < 4)
                {
                        for ($i = 1;
                                $i <= 5;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow">' . $i . '</a>';
                                }
                                else
                                {
                                        //echo '<a href="'.$page->url($i).'">'.$i.'</a>';
                                        echo '<a class="on">' . $i . '</a>';
                                }
                        }
                        echo '<span>&nbsp;&hellip;</span>';
                        echo '<a href="' . $page->url($total_pages - 1) . '" rel="nofollow">' . ($total_pages - 1) . '</a>';
                        echo '<a href="' . $page->url($total_pages) . '" rel="nofollow">' . $total_pages . '</a>';
                }
                elseif ($current_page > $total_pages - 4)
                {
                        echo '<a href="' . $page->url(1) . '" rel="nofollow">1</a>';
                        echo '<a href="' . $page->url(2) . '" rel="nofollow">2</a>';
                        echo '<span>&nbsp;&hellip;</span>';
                        for ($i = $total_pages - 5;
                                $i <= $total_pages;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow">' . $i . '</a>';
                                }
                                else
                                {
                                        //echo '<a href="'.$page->url($i).'">'.$i.'</a>';
                                        echo '<a class="on">' . $i . '</a>';
                                }
                        }
                }
                else
                {
                        echo '<a href="' . $page->url(1) . '" rel="nofollow">1</a>';
                        echo '<a href="' . $page->url(2) . '" rel="nofollow">2</a>';
                        echo '<span>&nbsp;&hellip;</span>';
                        for ($i = $current_page - 1;
                                $i <= $current_page + 2;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow">' . $i . '</a>';
                                }
                                else
                                {
                                        //echo '<a href="'.$page->url($i).'">'.$i.'</a>';
                                        echo '<a class="on">' . $i . '</a>';
                                }
                        }
                        echo '<span>&nbsp;&hellip;</span>';
                        echo '<a href="' . $page->url($total_pages - 1) . '" rel="nofollow">' . ($total_pages - 1) . '</a>';
                        echo '<a href="' . $page->url($total_pages) . '" rel="nofollow">' . $total_pages . '</a>';
                }
                ?>
                <?php if ($next_page !== FALSE): ?>
                        <span class="next_btn1"><a href="<?php echo $page->url($next_page); ?>" rel="nofollow">Следующая</a></span>
                <?php endif; ?>
        </div>

</div>
