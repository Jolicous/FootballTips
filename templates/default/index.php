<?php foreach ($leagues as $league): ?>
    <div style="width: 100%; padding-bottom: 2%">
        <a style="color: inherit; text-decoration: inherit;" href="/league/openLeague?id=<?=$league->id;?>">
            <img style="width: 7%" src="<?=$league->img_src;?>" alt="<?=$league->name;?> Logo">
            <span class="h2"><?=$league->name;?></span>
        </a>   
    </div>
<?php endforeach; ?>