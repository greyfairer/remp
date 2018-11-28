<?php

namespace Remp\MailerModule\Repository;

use DateTime;
use Remp\MailerModule\Repository;

class MailTypeStatsRepository extends Repository
{
    protected $tableName = 'mail_type_stats';

    public function add(
        int $mailTypeId,
        int $subscribersCount
    ) {
        return $this->getTable()->insert([
            'mail_type_id' => $mailTypeId,
            'created_at' => new DateTime(),
            'subscribers_count' => $subscribersCount,
        ]);
    }

    public function getDashboardDataGroupedByTypes(DateTime $from, DateTime $to)
    {
        return $this->getTable()
            ->select('mail_type_id, subscribers_count AS count, DATE(created_at) AS created_date')
            ->where('created_at >= ?', $from)
            ->where('created_at <= ?', $to)
            ->where('id IN (SELECT id FROM mail_type_stats GROUP BY DATE(created_at), mail_type_id)')
            ->group('created_date, mail_type_id')
            ->order('created_date ASC')
            ->fetchAll();
    }

    public function getDashboardDetailData($id, DateTime $from, DateTime $to)
    {
        return $this->getTable()
            ->select('mail_type_id, subscribers_count AS count, DATE(created_at) AS created_date')
            ->where('created_at >= ?', $from)
            ->where('created_at <= ?', $to)
            ->where('mail_type_id = ?', $id)
            ->group('created_date, mail_type_id')
            ->order('created_date ASC')
            ->fetchAll();
    }
}
