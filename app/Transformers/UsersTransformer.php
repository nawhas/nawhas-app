<?php

namespace App\Transformers;

use App\User;

class UsersTransformer extends Transformer
{
    /**
     * @param User $user
     * @return array
     * @internal param Reciter $reciter
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'createdAt' => $user->created_at->toDateTimeString(),
            'updatedAt' => $user->updated_at->toDateTimeString(),
        ];
    }
}
