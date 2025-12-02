<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService
{

    public function checkAndGiveBadges(User $user): array
    {
        $awarded = [];

        if ($user->posts()->count() === 1) { 
            $badge = $this->award($user, 'Cherry Blossom');
            if ($badge) {
                $awarded[] = $badge;
            }
        }

        $prefectureCount = $user->posts()->pluck('prefecture_id')->unique()->count();

        $prefectureBadges = [
            3 => 'Karesansui',
            5 => 'Sumo',
            10 => 'Onsen hot spring',
            15 => 'Japanese Castle',
            20 => 'Lucky Cat ',
            30 => 'Ninja',
            40 => 'Maiko-san',
            47 => 'Mt.Fuji',
        ];

        if (isset($prefectureBadges[$prefectureCount])) {
            $badge = $this->award($user, $prefectureBadges[$prefectureCount]);
            if ($badge) {
                $awarded[] = $badge;
            }
        }

        return $awarded;
    }

    
    public function award(User $user, string $badgeKey)
    {
        $badge = Badge::where('key', $badgeKey)->first();

        if (! $badge) {
            return null;
        }

        if ($user->badges()->where('badge_id', $badge->id)->exists()) {
            return null;
        }

        $user->badges()->attach($badge->id, ['awarded_at' => now()]);

        return $badge;
    }
}
