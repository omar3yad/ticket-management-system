<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support tickets Description</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Cake</span>PHP</a>
        </div>
        <div class="top-nav-links">
            <a target="_blank" rel="noopener" href="https://book.cakephp.org/5/">Documentation</a>
            <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a>
        </div>
    </nav> -->
<nav class="main-nav">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="<?= $this->Url->build('/tickets') ?>">
                <strong>Ticketing</strong><span>System</span>
            </a>
        </div>
        
        <input type="checkbox" id="nav-check">
        <div class="nav-btn">
            <label for="nav-check">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
        
        <div class="nav-links">
            <?= $this->Html->link(__('Tickets'), ['controller' => 'Tickets', 'action' => 'index']) ?>
            <?= $this->Html->link(__('New Ticket'), ['controller' => 'Tickets', 'action' => 'add']) ?>
            
            <?php if ($this->request->getAttribute('identity')): ?>
                <span class="user-name">👤 <?= h($this->request->getAttribute('identity')->get('username')) ?></span>
                <?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'logout-btn']) ?>
            <?php else: ?>
                <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?>
            <?php endif; ?>
        </div>
    </div>
</nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <?= $this->fetch('script') ?>
</body>
</html>
