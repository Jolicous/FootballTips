<table class="table">
    <tr>
        <th></th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Punkte</th>
    </tr>
<?php
$i = 1;
?>
<?php foreach ($bestlist as $user): ?>
    <tr>
        <td><?=$i?></td>
        <td><?=$user->firstName;?></td>
        <td><?=$user->lastName;?></td>
        <td><?=$user->punkte;?> Pkt.</td>
    </tr>   
    <?php $i++; ?> 
<?php endforeach; ?>
</table>