<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Contributor;
use Authorization\IdentityInterface;

/**
 * Contributor policy
 */
class ContributorPolicy
{
    /**
     * Check if $user can add Contributor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Contributor $contributor
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Contributor $contributor)
    {
    }

    /**
     * Check if $user can edit Contributor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Contributor $contributor
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Contributor $contributor)
    {
        if ($user->get('role') === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete Contributor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Contributor $contributor
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Contributor $contributor)
    {
        if ($user->get('role') === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view Contributor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Contributor $contributor
     * @return bool
     */
    public function canView(IdentityInterface $user, Contributor $contributor)
    {
    }
}
