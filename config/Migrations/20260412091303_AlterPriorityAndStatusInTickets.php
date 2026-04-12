<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlterPriorityAndStatusInTickets extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
$table = $this->table('tickets');
    $table->changeColumn('priority', 'integer', ['default' => 0, 'limit' => 11])
          ->changeColumn('status', 'integer', ['default' => 0, 'limit' => 11])
          ->update();
    }
}
