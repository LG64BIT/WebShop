<?php
include "Header.php";
$count=1;
?>
<div style="margin: 0 10% 0 10%">
    <table class="table" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th style="text-align: center">Username</th>
            <th style="text-align: center">Password hash</th>
            <th style="text-align: center">Privileges</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Remove</th>
        </tr>
        <?php foreach ($vars['users'] as $user): ?>
            <tr>
                <th><?php echo $count++; ?></th>
                <td>
                    <?php echo $user->username; ?>
                </td>
                <td>
                    <?php echo $user->password; ?>
                </td>
                <td>
                    <?php echo $user->isAdmin ? "Admin" : "Customer"; ?>
                </td>
                <td>
                    <a class="btn btn-success" href="editUser?id=<?php echo $user->id; ?>">+</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="removeUser?id=<?php echo $user->id; ?>">-</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
include "Footer.php";
?>