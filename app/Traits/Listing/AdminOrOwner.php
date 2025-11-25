<?php

namespace App\Traits\Listing;

use App\Models\Listing;

trait AdminOrOwner
{
    protected function canModifyListing(Listing $listing): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $listing->user_id === $user->id);
    }

    protected function authorizeListingModification(Listing $listing): void
    {
        if (!$this->canModifyListing($listing)) {
            abort(403);
        }
    }
}
