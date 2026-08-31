<footer class="footer">
    <nav>
        <ul>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">T&C</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
    </nav>
</footer>
    <?php if (isset($pageScript)): ?>
    <script src="/yap/public/assets/script/<?= htmlspecialchars($pageScript)?>"></script>
    <?php endif; ?>
    <?php if (isset($imagesScript)): ?>
    <script src="/yap/public/assets/script/<?= htmlspecialchars($imagesScript)?>"></script>
    <?php endif; ?>        

</body>
</html>