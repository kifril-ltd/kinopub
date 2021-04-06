<div class="container">
    <form class="d-flex flex-column my-5 mx-5" enctype="multipart/form-data" method="POST">
        <div class="form-inputs d-flex">
            <div class="base-fields">
                <div class="form-group">
                    <label for="movieNameInput">Название фильма</label>
                    <input type="text" class="form-control" id="movieNameInput" name="movieName"
                        placeholder="Название фильма" 
                            <? if (isset($_SESSION['validation'])):?> 
                                value="<? echo $_SESSION['validation']['movieName'] ?>"
                            <? endif ?>>
                </div>
                <div class="form-group my-2 ">
                    <label for="fileLoadControl">Загрузить постер фильма</label>
                    <input type="file" class="form-control-file" name="moviePoster" id="fileLoadControl">
                </div>
                <div class="form-group">
                    <label for="movieTrailerInput">Трейлер фильма</label>
                    <input type="text" class="form-control" id="movieTrailerInput" name="movieTrailer" placeholder="Ссылка на трейлер (youtube.com)" 
                            <? if (isset($_SESSION['validation'])):?> 
                                value="<? echo $_SESSION['validation']['movieTrailer'] ?>"
                            <? endif ?>>
                </div>
            </div>

            <div class="text-field">

            </div>
            <div class="form-group mx-3 w-75">
                <label for="reviewTextArea">Текст обзора</label>
                <textarea rows="20" class="form-control" id="reviewTextArea" name="reviewText" ><? if
                    (isset($_SESSION['validation'])):?> <?= $_SESSION['validation']['reviewText'] ?> <? endif ?></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-success my-3 w-50 mx-auto">Сохранить обзор</button>
    </form>
    <?php if (isset($_SESSION['errors'])): ?>
    <ul>
        <?php foreach ($_SESSION['errors'] as $val): ?>
        <?php if (!empty($val)) : ?>
        <li><?php echo $val ?></li>
        <? endif; ?>
        <?php endforeach; ?>
    </ul>
    <?php unset($_SESSION['errors']) ?>
    <? endif; ?>
</div>