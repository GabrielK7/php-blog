<?php if($userLoggedIn): ?>
    <h2>Vitaj, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>Si prihlásený a môžeš používať aplikáciu.</p>
<?php else: ?>
    <h2>Vitaj na blogu!</h2>
    <p>Prosím, prihlás sa alebo zaregistruj, aby si mohol pokračovať.</p>
<?php endif; ?>

