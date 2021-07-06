<?php

namespace App\Repositories;

use App\Models\Key;
use App\Repositories\Contracts\IKeyRepository;

class KeyRepository extends BaseRepository implements IKeyRepository
{
    public function model()
    {
        return Key::class;
    }
}
