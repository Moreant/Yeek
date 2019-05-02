<?php
?>
<main>
    <section id="input">
        <div>
            <form method="post" name="checkForm">
                <label>
                    <input type="text" name="name" id="name" placeholder="查询文件名" required="required"/>
                    <input type="submit" name="check" id="check" value="查询"/>
                </label>
            </form>
        </div>
        <div>
            <form method="post" enctype="multipart/form-data">
                <label for="file" id="file_input">
                    <input type="file" name="file" id="file" required="required"/>
                </label>
                <input type="submit" name="update" id="update" value="上传"/>
            </form>
            <br>
        </div>
    </section>
    <br>
    <section>
        <div id="result">
            <?php
            if (isset($_POST['check'])) {
                $result = checkFile($_POST['name']);
                if (count($result) > 0) {
                    showCheck($result);
                } else {
                    echo "<span class='blue'>没有找到“</span>" . $_POST['name'] . "”的相关文件";
                }
            }
            ?>

            <?php
            if (isset($_POST['update'])) {
                $fileInfo = $_FILES['file'];
                $match = false;
                foreach ($suffixs as $suffix) {
                    $fileName = $fileInfo['name'];
                    if ((pathinfo($fileName, PATHINFO_EXTENSION)) == $suffix) {
                        $result = checkFile($fileName);
                        if (count($result) > 0) {
                            showCheck($result);
                            $match = true;
                        } else {
                            showUpload(moveFile($fileInfo));
                            $match = true;
                        }
                    }
                }
                if (!$match) {
                    echo "<span>上传失败</span><br>你上传的文件格式不合法，请查看下面的说明";
                }

            }
            ?>
        </div>
    </section>
    <div id="historical">
        <?php
        if (isset($_COOKIE['sqlwork'])) {
            $historical = $_COOKIE['sqlwork'];
            echo '<p>Cookie说：</p>';
            echo '你上一次在<span class="blue">' . $historical['time'] . "</span>";
            echo '，上传了<span class="blue">' . $historical['name'] . '</span>';
            echo '，大小为<span class="blue">' . $historical['size'] . 'MB</span>的文件</p>';
        }
        ?>
    </div>
    <div id="readme">
        <p>最近校园网上传很慢，请看浏览器左下角的上传进度。</p>
        <p>上课当天上交的请在上课前找我确认</p>
        <br>
        <p>
            <a href="/worklist" target="_blank">作业内容</a>
            <a href="../checkList.php">上交名单</a>
            <a href="https://gitee.com/Moreant/schoolwork">某人答案</a>
        </p>
        <br>
        <p>①仅支持上传和搜索<?php foreach ($suffixs as $item): echo " " . $item . ","; endforeach; ?>后缀的文件</p><br>
        <p>②要替换旧文件在新文件名后面加个“2”就行</p><br>
        <p>③别忘了检查一下文件大小是否一致</p><br>
        <p>④检查不到文件可能是我还没有同步内外网</p><br><br>
        <p><a href="http://<?php echo $domainInfo['domain'] ?>/SQLServer">SQL Server 安装教程与下载</a></p>
    </div>
</main>
