<?php foreach ($leagues as $league): ?>
    <div style="width: 100%">
        <img style="width: 10%" src="<?=$league->img_src;?>" alt="<?=$league->name;?> Logo">
        <a class="h2"><?=$league->name;?></a>
    </div>
<?php endforeach; ?>