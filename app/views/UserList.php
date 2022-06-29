<?php
include "Header.php";
$count=1;
?>
<div style="margin: 0 10% 0 10%">
    <table class="table" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th style="text-align: center">First name</th>
            <th style="text-align: center">Last name</th>
            <th style="text-align: center">Email</th>
            <th style="text-align: center">Address</th>
            <th style="text-align: center">Privileges</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Remove</th>
        </tr>
        <?php foreach ($vars['users'] as $user): ?>
            <tr>
                <th><?= $count++ ?></th>
                <td>
                    <?= $user->firstName == '' ? '<b>unset</b>' : $user->firstName ?>
                </td>
                <td>
                    <?= $user->lastName == '' ? '<b>unset</b>' : $user->lastName ?>
                </td>
                <td>
                    <?= $user->email ?>
                </td>
                <td>
                    <?= $user->address == '' ? '<b>unset</b>' : $user->address ?>
                </td>
                <td>
                    <?= $user->isAdmin ? "Admin" : "Customer" ?>
                </td>
                <td>
                    <a class="btn btn-success" href="editUser?id=<?= $user->id ?>">+</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="removeUser?id=<?= $user->id ?>">-</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
include "Footer.php";
?>
