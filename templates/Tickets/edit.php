<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete Ticket'),
                ['action' => 'delete', $ticket->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->id), 'class' => 'side-nav-item text-danger']
            ) ?>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('View Ticket'), ['action' => 'view', $ticket->id], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets form content">
            <?= $this->Form->create($ticket, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Edit Ticket: #') . h($ticket->id) ?></legend>
                <?php
                    echo $this->Form->control('subject');
                    echo $this->Form->control('customer_name');
                    echo $this->Form->control('customer_email');
                    echo $this->Form->control('message', ['rows' => '5']);
                    
                    echo $this->Form->control('priority', [
                        'options' => ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']
                    ]);
                    echo $this->Form->control('status', [
                        'options' => ['Open' => 'Open', 'In Progress' => 'In Progress', 'Closed' => 'Closed']
                    ]);

                    echo '<div class="attachment-section" style="margin-top: 20px; padding: 10px; border: 1px solid #ddd;">';
                    if (!empty($ticket->attachment)) {
                        echo '<p><strong>Current Attachment:</strong> ' . $this->Html->link(h($ticket->attachment), '/uploads/tickets/' . $ticket->attachment, ['target' => '_blank']) . '</p>';
                    } else {
                        echo '<p><em>No attachment uploaded.</em></p>';
                    }
                    
                    echo $this->Form->control('attachment_file', [
                        'type' => 'file', 
                        'required' => false
                    ]);
                    echo '</div>';
                ?>
            </fieldset>
            <br>
            <?= $this->Form->button(__('Save Changes'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>