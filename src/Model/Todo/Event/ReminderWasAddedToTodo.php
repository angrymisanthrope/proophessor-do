<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\Todo\TodoReminderStatus;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class ReminderWasAddedToTodo
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class ReminderWasAddedToTodo extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var TodoReminder
     */
    private $reminder;

    /**
     * @param TodoId $todoId
     * @param UserId $userId
     * @param TodoReminder $reminder
     * @return ReminderWasAddedToTodo
     */
    public static function byUserToDate(TodoId $todoId, UserId $userId, TodoReminder $reminder)
    {
        $event = self::occur($todoId->toString(), [
            'todo_id' => $todoId->toString(),
            'user_id' => $userId->toString(),
            'reminder' => $reminder->toString(),
        ]);

        $event->todoId = $todoId;
        $event->userId = $userId;
        $event->reminder = $reminder;

        return $event;
    }

    /**
     * @return UserId
     */
    public function todoId()
    {
        if (!$this->todoId) {
            $this->todoId = TodoId::fromString($this->payload['todo_id']);
        }

        return $this->todoId;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        if (!$this->userId) {
            $this->userId = UserId::fromString($this->payload['user_id']);
        }

        return $this->userId;
    }

    /**
     * @return TodoReminder
     */
    public function reminder()
    {
        if (!$this->reminder) {
            $this->reminder = TodoReminder::from($this->payload['reminder'], TodoReminderStatus::OPEN()->getName());
        }

        return $this->reminder;
    }
}
