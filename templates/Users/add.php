<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password', [
                        'value' => '', 
                        'required' => ($this->request->getParam('action') === 'add'), 
                        'placeholder' => $user->isNew() ? '' : '*********'
                    ]);
                    echo $this->Form->control('confirm_password', [
                                // 'type' => 'password',
                                'value' => '',
                                'label' => 'Confirm Password',
                                'placeholder' => $user->isNew() ? '' : '*********',
                                'required' => ($this->request->getParam('action') === 'add')
                            ]);                    

                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
