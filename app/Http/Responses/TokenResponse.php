<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class TokenResponse implements Responsable
{
    /**
     * @var User
     */
    private $user;

    /**
     * __construct
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Automatic response
     *
     * @param Request $request
     * @return Request response
     */
    public function toResponse($request)
    {
        return response()->json([
            'status_code' => 200,
            'plain_text_token' => $this->user->createToken(
                $this->user->email,
                $this->user->getAllPermissions()->pluck('name')->toArray()
            )->plainTextToken,
            'slug' => $this->user->slug
        ]);
    }
}
