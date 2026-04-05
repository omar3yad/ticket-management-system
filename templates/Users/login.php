<div class="users form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('الرجاء إدخال بيانات الدخول') ?></legend>
        <?= $this->Form->control('username', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>