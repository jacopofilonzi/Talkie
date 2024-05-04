<footer class="d-flex flex-wrap justify-content-between align-items-center py-3">
    <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>
        <span class="mb-3 mb-md-0 text-muted">
            <a class="text-muted brand-font" href="https://www.filonzi.it" target="_blank">Filonzi</a>
            • 
            <?php
                if (isset($currentUser)) {
                    echo "Logged in as " . $currentUser->getSurname() . " " . $currentUser->getName() . ".";
                } else 
                    echo "Not logged in.";
            ?>
        </span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="mx-3"><a class="text-white" href="https://github.com/jacopofilonzi/talkie" target="_blank"><i class="bi bi-github"></i></a></li>
    </ul>
</footer>