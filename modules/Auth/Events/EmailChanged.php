<?php

namespace Modules\Auth\Events;

use App\Events\BaseEvent;
use Modules\Auth\Entities\Auth;

class EmailChanged extends BaseEvent
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle()
    {
        $this->trigger("email-changed", $this->auth);
    }
}
