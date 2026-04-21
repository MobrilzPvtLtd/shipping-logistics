<?php

namespace Illuminate\Contracts\Auth;

interface Guard
{
    /**
     * @return \Modules\User\Models\User|null
     */
    public function user();
}