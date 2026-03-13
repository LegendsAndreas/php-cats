<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Cat;
use Authorization\IdentityInterface;

/**
 * Cat policy
 */
class CatPolicy
{
    /**
     * Check if $user can add Cat
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Cat $cat
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Cat $cat): bool
    {
        if ($user->get('role') === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit Cat
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Cat $cat
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Cat $cat)
    {
        if ($user->get('role') === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete Cat
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Cat $cat
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Cat $cat)
    {
    }

    /**
     * Check if $user can view Cat
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Cat $cat
     * @return bool
     */
    public function canView(IdentityInterface $user, Cat $cat)
    {
    }
}
