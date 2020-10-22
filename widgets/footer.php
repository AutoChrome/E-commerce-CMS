<footer class="grid-x footer">
    <div class="cell large-12">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell large-10 large-offset-1">
                    <ul class="footer-list">
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                            echo "<li><a href='admin/main.php'>Admin panel</a></li>";
                        }
                        ?>
                        <li><a href="privacy-policy.php">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>