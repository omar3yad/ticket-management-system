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
    'options' => [
        0 => 'Low',
        1 => 'Medium',
        2 => 'High'
    ],
    'empty' => 'Select Priority'
]);
echo $this->Form->control('status', [
    'options' => [
        0 => 'Open',
        1 => 'In Progress',
        2 => 'Closed'
    ],
    'empty' => 'Select Status'
]);
                ?>
<div id="drop-zone" class="drop-zone">
                <span class="drop-zone__prompt">Drop file here or click to upload</span>
                <?= $this->Form->control('attachment_file', [
                    'type' => 'file', 
                    'label' => false, 
                    'class' => 'drop-zone__input',
                    'templates' => ['inputContainer' => '{{content}}']
                ]) ?>
            </div>
            
            <?= $this->Form->hidden('g-recaptcha-response', ['id' => 'g-recaptcha-response']) ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
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

<style>
 .drop-zone {
    max-width: 100%;
    height: 150px;
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    color: #cccccc;
    border: 2px dashed #d33c44;
    border-radius: 10px;
    margin-bottom: 20px;
    transition: background 0.3s, border-color 0.3s;
}

.drop-zone--over {
    border-style: solid;
    background-color: #f8f9fa;
    border-color: #5cb85c;
}

.drop-zone__input {
    display: none;
}

.drop-zone__thumb {
    width: 100%;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
    background-color: #cccccc;
    background-size: cover;
    position: relative;
}

.drop-zone__thumb::after {
    content: attr(data-label);
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 5px 0;
    color: #ffffff;
    background: rgba(0, 0, 0, 0.75);
    font-size: 14px;
    text-align: center;
}
</style>

<script>

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}

</script>