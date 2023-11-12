<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserAccount extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'Hornchoose'
            ],
            [
                'username' => 'Hewnobserve'
            ],
            [
                'username' => 'Wenchbenefit'
            ],
            [
                'username' => 'Gillresigned'
            ],
            [
                'username' => 'Trevilletcloser'
            ],
        ];

        $account = $this->table('user_account');
        $account->insert($data)
            ->saveData();
    }
}
