<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property string $subject
 * @property string $customer_name
 * @property string $customer_email
 * @property string $message
 * @property string|null $priority
 * @property string|null $status
 * @property string|null $attachment
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Note[] $notes
 */
class Ticket extends Entity
{
    public const PRIORITY_LOW = 0;
    public const PRIORITY_MEDIUM = 1;
    public const PRIORITY_HIGH = 2;

    public const STATUS_OPEN = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_CLOSED = 2;

    public function getStatusLabel(): string
    {
        return match($this->status) {
            self::STATUS_OPEN => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_CLOSED => 'Closed',
            default => 'Unknown',
        };
    }
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'subject' => true,
        'customer_name' => true,
        'customer_email' => true,
        'message' => true,
        'priority' => true,
        'status' => true,
        'attachment' => true,
        'created' => true,
        'modified' => true,
        'notes' => true,
    ];
}
