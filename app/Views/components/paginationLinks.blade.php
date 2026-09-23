@props(["opt", "location"])


<nav aria-label="Page navigation example">
    <ul class="pagination  justify-content-center">
        <li class="page-item">
            <a class="page-link" href='<?php echo $location . $path ?>/1' aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php for ($i = $opt["pagination"]["pageCurrent"] - $opt["pagination"]["pageNeighboorsLeft"]; $i < $opt["pagination"]["pageCurrent"]; $i++): ?>
            <li class="page-item"><a class="page-link" href='<?php echo $location . $path ?>/<?= $i ?>'><?= $i ?></a></li>
        <?php endfor; ?>

        <li class="page-item active"><span class="page-link" deactivated href='<?php echo $location . $path ?>/<?= $opt["pagination"]["pageCurrent"] ?>'><strong><?= $opt["pagination"]["pageCurrent"] ?></strong></span></li>

        <?php for ($i = $opt["pagination"]["pageCurrent"] + 1; $i <= $opt["pagination"]["pageCurrent"] + $opt["pagination"]["pageNeighboorsRight"]; $i++): ?>
            <li class="page-item"><a class="page-link" href="<?php echo $location . $path ?>/<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>

        <li class="page-item">
            <a class="page-link" href='<?php echo $location . $path ?>/<?= $opt["pagination"]["pageLast"] ?>' aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>
