<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class InitialStructure extends BaseMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-up-method
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('notes')
            ->addColumn('ticket_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('note_text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('ticket_id')
                    ->setName('ticket_id')
            )
            ->create();

        $this->table('tickets')
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('customer_name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('customer_email', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('priority', 'string', [
                'default' => 'Medium',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'Open',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('attachment', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('notes')
            ->addForeignKey(
                $this->foreignKey('ticket_id')
                    ->setReferencedTable('tickets')
                    ->setReferencedColumns('id')
                    ->setDelete('CASCADE')
                    ->setUpdate('RESTRICT')
                    ->setName('notes_ibfk_1')
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-down-method
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('notes')
            ->dropForeignKey(
                'ticket_id'
            )->save();

        $this->table('notes')->drop()->save();
        $this->table('tickets')->drop()->save();
        $this->table('users')->drop()->save();
    }
}