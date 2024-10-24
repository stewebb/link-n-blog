<?php
function page_lnb_list(): void
{
    ?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Link List</h1>
        <hr class="wp-header-end">

        <table class="widefat fixed striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">URL</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Example Link</td>
                <td><a href="#">https://example.com</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Another Link</td>
                <td><a href="#">https://another.com</a></td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php
}