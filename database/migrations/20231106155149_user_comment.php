<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserComment extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $comments = $this->table('user_comment');
        $comments
            ->addColumn('message', 'text', ['null' => false])

            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp')

            ->addColumn('account_id', 'integer', ['null' => false])
            ->addColumn('content_id', 'integer', ['null' => false])
            ->addColumn('reply_id', 'integer')

            ->create();
    }
}
