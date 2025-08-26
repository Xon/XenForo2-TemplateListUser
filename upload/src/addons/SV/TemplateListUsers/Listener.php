<?php

namespace SV\TemplateListUsers;

use Doctrine\Common\Cache\CacheProvider;
use SV\StandardLib\Helper;
use XF\Entity\User as UserEntity;
use XF\Searcher\User as UserSearcher;
use XF\Template\Templater;
use function count;
use function is_array;
use function json_encode;
use function md5;

abstract class Listener
{
    /** @noinspection PhpUnusedParameterInspection */
    public static function templater_macro_pre_render(Templater $templater, string &$type, string &$template, string &$name, array &$arguments, array &$globalVars): void
    {
        $criteria = $arguments['criteria'] ?? [];
        if (count($criteria) === 0)
        {
            return;
        }
        $app = \XF::app();

        $cacheKey = 'svTemplateListUsers.' . md5(json_encode($criteria));
        /** @var CacheProvider|null $cache */
        $cache = $app->cache();
        $userIds = $cache !== null ? $cache->fetch($cacheKey) : null;
        if (!is_array($userIds))
        {
            /** @var UserSearcher $searcher */
            $searcher = $app->searcher('XF:User'); // todo with XF2.3 only, use UserSearcher::class
            $searcher->setCriteria($criteria);
            $query = $searcher->getFinder()->getQuery(['fetchOnly' => ['user_id']]);
            $userIds = \XF::db()->fetchAllColumn($query);

            $cache->save($cacheKey, $userIds, 3600);
        }

        if (count($userIds) === 0)
        {
            $arguments['users'] = [];

            return;
        }

        $arguments['users'] = Helper::findByIds(UserEntity::class, $userIds)
                                    ->sortByList($userIds)
                                    ->toArray();
    }
}
