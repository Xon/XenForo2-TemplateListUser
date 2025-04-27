<?php

namespace SV\TemplateListUsers;

use XF\Searcher\User as UserSearcher;
use XF\Template\Templater;

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

        /** @var UserSearcher $searcher */
        $searcher = \XF::app()->searcher('XF:User'); // todo with XF2.3 only, use UserSearcher::class
        $searcher->setCriteria($criteria);
        $arguments['users'] = $searcher->getFinder()->fetch();
    }
}
