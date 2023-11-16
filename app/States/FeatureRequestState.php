<?php

namespace App\States;

use App\Enums\Status;
use Thunk\Verbs\State;

class FeatureRequestState extends State
{
    public Status $status;
}
