<?php $pager->setSurroundCount(3)  ?>

<ul class="pagination" style="justify-content: flex-end">
    <?php foreach($pager->links() as $link): ?>
        <li class="paginate_button page-item <?= $link['active'] ? 'active' : '' ?>"><a href="<?= $link['uri'] ?>" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link"><?= $link['title'] ?></a></li>
    <?php endforeach; ?>
</ul>

