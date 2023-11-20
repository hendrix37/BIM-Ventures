<?php

namespace App\Enums;

use Essa\APIToolKit\Enum\Enum;

class StatusType extends Enum
{
    /**
     *  public const PAID = 'Paid';
     *  When the transaction is fully paid     *
     *
     *  public const OUTSTANDING = 'Outstanding';
     *  When transaction is not fully paid and part and due on date has not passed today’s date
     *
     *  public const OVERDUE = 'Overdue';
     *  The transaction is overdue if it is not fully paid and the due on date has passed today’s day     *
     */
    public const PAID = 'Paid';

    public const OUTSTANDING = 'Outstanding';

    public const OVERDUE = 'Overdue';
}
