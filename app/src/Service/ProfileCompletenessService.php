<?php

namespace App\Service;

use App\Entity\Profile\Profile;

class ProfileCompletenessService
{

    public function isProfileComplete(?Profile $profile): bool
    {
        if (!$profile) {
            return false;
        }

        // Tech Lead döntés: Ezek a mezők NEM lehetnek üresek
        return !empty($profile->getFirstName()) &&
               !empty($profile->getLastName()) &&
               !empty($profile->getPhoneNumber()) &&
               !empty($profile->getCity()) &&
               !empty($profile->getAddress()) &&
               $profile->getHousingType() !== null;
    }
}