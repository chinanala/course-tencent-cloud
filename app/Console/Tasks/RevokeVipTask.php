<?php

namespace App\Console\Tasks;

use App\Models\User as UserModel;
use Phalcon\Cli\Task;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\ResultsetInterface;

class RevokeVipTask extends Task
{

    public function mainAction()
    {
        $users = $this->findUsers();

        if ($users->count() == 0) {
            return;
        }

        foreach ($users as $user) {
            $user->vip = 0;
            $user->update();
        }
    }

    /**
     * 查找待解锁用户
     *
     * @param int $limit
     * @return UserModel[]|Resultset|ResultsetInterface
     */
    protected function findUsers($limit = 1000)
    {
        $time = time();

        $users = UserModel::query()
            ->where('vip = 1')
            ->andWhere('vip_expiry < :time:', ['time' => $time])
            ->limit($limit)
            ->execute();

        return $users;
    }

}