<!-- Limit to 3 Links each side of the current page -->
<?php $pager->setSurroundCount(3)  ?>
<!-- END-->

<div class="row">
    <!-- Pagination -->

    <ul class="pagination-ul clear-fix">
        <?php foreach($pager->links() as $link): ?>
        <li class="pagination-li clear-fix <?= $link['active'] ? 'pagination_active' : '' ?>">
            <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <!-- End of Pagination -->

</div>