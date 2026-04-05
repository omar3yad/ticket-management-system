<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ticket'), ['action' => 'edit', $ticket->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ticket'), ['action' => 'delete', $ticket->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets view content">
            <h3><?= h($ticket->subject) ?></h3>
            <table>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($ticket->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Name') ?></th>
                    <td><?= h($ticket->customer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Email') ?></th>
                    <td><?= h($ticket->customer_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= h($ticket->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($ticket->status) ?></td>
                </tr>
<?php if ($ticket->attachment): ?>
    <tr>
        <th><?= __('Attachment') ?></th>
        <td><?= $this->Html->link(__('Download File'), '/uploads/tickets/' . $ticket->attachment, ['target' => '_blank']) ?></td>
    </tr>
<?php endif; ?>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($ticket->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($ticket->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($ticket->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($ticket->message)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Notes') ?></h4>
                <?php if (!empty($ticket->notes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Note Text') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($ticket->notes as $note) : ?>
                        <tr>
                            <td><?= h($note->id) ?></td>
                            <td><?= h($note->note_text) ?></td>
                            <td><?= h($note->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Notes', 'action' => 'view', $note->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Notes', 'action' => 'edit', $note->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Notes', 'action' => 'delete', $note->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $note->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="notes-form content" style="margin-top: 20px; padding: 20px; border: 1px solid #ddd;">
    <h4><?= __('Add Internal Note') ?></h4>
    <?= $this->Form->create(null, ['id' => 'note-form']) ?>
        <?= $this->Form->hidden('ticket_id', ['value' => $ticket->id]) ?>
        <?= $this->Form->control('note_text', ['type' => 'textarea', 'label' => 'Note Content', 'required' => true]) ?>
        <button type="submit" class="button">Save Note via AJAX</button>
    <?= $this->Form->end() ?>
</div>
    </div>
    
</div>


<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function() {
    $('#note-form').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var targetUrl = "<?= $this->Url->build(['controller' => 'Notes', 'action' => 'add']) ?>";

        $.ajax({
            url: targetUrl,
            type: "POST",
            data: formData,
            dataType: "json",
            beforeSend: function(xhr) { ////for CSRF
                xhr.setRequestHeader('X-CSRF-Token', <?= json_encode($this->request->getAttribute('csrfToken')) ?>);
            },
            success: function(response) {
                if (response.status === 'success') {
                    var newRow = '<tr>' +
                        '<td>' + response.data.id + '</td>' +
                        '<td>' + response.data.text + '</td>' +
                        '<td>' + response.data.created + '</td>' +
                        '<td>Just added</td>' +
                        '</tr>';
                    
                    $('.related table').append(newRow); 
                    $('#note-text').val('');
                    alert('Note added successfully!');
                }
            },
            error: function() {
                alert('Error adding note. Please try again.');
            }
        });
    });
});
<?php $this->Html->scriptEnd(); ?>