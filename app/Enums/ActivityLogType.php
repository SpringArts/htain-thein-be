<?php

namespace App\Enums;

enum ActivityLogType: string
{
    public const USER_CREATE = 'USER_CREATE';

    public const USER_UPDATE = 'USER_UPDATE';

    public const USER_DELETE = 'USER_DELETE';

    public const REPORT_CREATE = 'REPORT_CREATE';

    public const REPORT_UPDATE = 'REPORT_UPDATE';

    public const REPORT_DELETE = 'REPORT_DELETE';

    public const REGULAR_OUTCOME_CREATE = 'REGULAR_OUTCOME_CREATE';

    public const REGULAR_OUTCOME_UPDATE = 'REGULAR_OUTCOME_UPDATE';

    public const REGULAR_OUTCOME_DELETE = 'REGULAR_OUTCOME_DELETE';

    public const ANNOUNCEMENT_CREATE = 'ANNOUNCEMENT_CREATE';

    public const ANNOUNCEMENT_UPDATE = 'ANNOUNCEMENT_UPDATE';

    public const ANNOUNCEMENT_DELETE = 'ANNOUNCEMENT_DELETE';
}
