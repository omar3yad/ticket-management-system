<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets form content">
            <script src="https://www.google.com/recaptcha/api.js?render=6LdrsaYsAAAAAJsNyfRvKUCHRvJP1yyRkqHKMlUw"></script>

            <?= $this->Form->create($ticket, ['type' => 'file', 'id' => 'ticket-form']) ?>
            <fieldset>
                <legend><?= __('Add Ticket') ?></legend>
                <?php
                    echo $this->Form->control('subject');
                    echo $this->Form->control('customer_name');
                    echo $this->Form->control('customer_email');
                    echo $this->Form->control('message');
                    echo $this->Form->control('priority', [
                        'options' => ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']
                    ]);
                    echo $this->Form->control('status', [
                        'options' => ['Open' => 'Open', 'In Progress' => 'In Progress', 'Closed' => 'Closed']
                    ]);
                ?>
                <?php
                    echo $this->Form->control('attachment_file', ['type' => 'file', 'label' => 'Upload Attachment']);                ?>
                <?= $this->Form->hidden('g-recaptcha-response', ['id' => 'g-recaptcha-response']) ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('ticket-form').addEventListener('submit', function(e) {
        var form = this;
        e.preventDefault(); 
        grecaptcha.ready(function() {
            grecaptcha.execute('6LdrsaYsAAAAAJsNyfRvKUCHRvJP1yyRkqHKMlUw', {action: 'submit'})
            .then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
                form.submit();
            });
        });
    });
</script>