<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Ticket> $tickets
 */
?>
<div class="search-form content" style="margin:15px 0 20px 0;">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <div style="display: flex; gap: 10px; align-items: flex-end;overflow-x: auto;">
        <?= $this->Form->control('search', ['label' => 'Search', 'value' => $this->request->getQuery('search'), 'placeholder' => 'Subject or Name...']) ?>
        
        <?= $this->Form->control('status', [
            'options' => ['' => 'All Statuses', 'Open' => 'Open', 'In Progress' => 'In Progress', 'Closed' => 'Closed'],
            'value' => $this->request->getQuery('status')
        ]) ?>

        <?= $this->Form->control('priority', [
            'options' => ['' => 'All Priorities', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'],
            'value' => $this->request->getQuery('priority')
        ]) ?>

        <?= $this->Form->button(__('Filter'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'button button-outline']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<div class="tickets index content">
    
    <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tickets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('customer_name') ?></th>
                    <th><?= $this->Paginator->sort('customer_email') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
<tbody>
    <?php foreach ($tickets as $ticket): 
        $rowClass = '';
        if ($ticket->priority === 'High') $rowClass = 'priority-high';
        if ($ticket->status === 'Closed') $rowClass = 'status-closed';
    ?>
    <tr class="<?= $rowClass ?>">
        <td><?= $this->Number->format($ticket->id) ?></td>
        <td><strong><?= h($ticket->subject) ?></strong></td>
        <td><?= h($ticket->customer_name) ?></td>
        <td><?= h($ticket->customer_email) ?></td>
        
        <td>
            <span class="badge-priority <?= strtolower($ticket->priority) ?>">
                <?= h($ticket->priority) ?>
            </span>
        </td>

        <td><?= h($ticket->status) ?></td>
        <td><?= h($ticket->created->format('Y-m-d')) ?></td>
        
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $ticket->id], ['class' => 'btn-view']) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ticket->id], ['class' => 'btn-edit']) ?>
            
            <?php if ($ticket->status !== 'Closed'): ?>
                <?= $this->Form->postLink(__('Close'), ['action' => 'edit', $ticket->id], [
                    'data' => ['status' => 'Closed'],
                    'confirm' => __('هل أنت متأكد من إغلاق التذكرة رقم {0}؟', $ticket->id),
                    'style' => 'color: green; font-weight: bold;'
                ]) ?>
            <?php endif; ?>

            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ticket->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->id), 'class' => 'btn-delete']
            ) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<style>
    .priority-high {
        background-color: #fff5f5 !important;
        border-left: 4px solid #ff4d4d;
    }

    .status-closed {
        background-color: #f9f9f9 !important;
        color: #999;
    }

    .badge-priority {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }
    .high { background: #ff4d4d; color: white; }
    .medium { background: #ffcc00; color: black; }
    .low { background: #2ecc71; color: white; }

    .actions a, .actions form {
        margin-right: 5px;
        display: inline-block;
    }
</style>