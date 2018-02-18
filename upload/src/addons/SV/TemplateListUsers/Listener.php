<?php


namespace SV\TemplateListUsers;

use XF\Searcher\User;
use XF\Template\Templater;

class Listener
{
    public static function templater_macro_pre_render(
        /** @noinspection PhpUnusedParameterInspection */
        Templater $templater,
        &$type,
        &$template,
        &$name,
        array &$arguments,
        array &$globalVars
    )
    {
        /** @var User $searcher */
        $searcher = \XF::app()->searcher('XF:User');

        $search = array_intersect_key($arguments, array_flip(['secondary_group_ids', 'not_secondary_group_ids', 'user_id']));
        if ($search)
        {
            $searcher->setCriteria($search);
            $arguments['users'] = $searcher->getFinder()->fetch();
        }
        else
        {
            $arguments['users'] = [];
        }
    }
}
