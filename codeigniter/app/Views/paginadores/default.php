<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
       
    <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true">Primero ««  </span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true">Anterior ««  </span>
                </a>
            </li>
        <?php endif ?>
        

        <?php
        $the_page =  (isset($_GET['page'])) ?  $_GET['page'] : 1;
        $index_page = 1;
        foreach ($pager->links() as $link) :

        ?>

            <li <?= $link['active'] ?  "class='btn btn-secondary'" : "class='btn btn-primary'" ?>>
                <a onclick="act_grilla(event)" class=" text-light" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>


        

        
        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true"> Siguiente »»</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true"> Último »» </span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>