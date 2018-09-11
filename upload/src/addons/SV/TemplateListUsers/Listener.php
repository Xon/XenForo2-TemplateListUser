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

        if (isset($arguments['criteria']))
        {
            $searcher->setCriteria($arguments['criteria']);
            $arguments['users'] = $searcher->getFinder()->fetch();
        }
        else
        {
            $arguments['users'] = [];
        }
    }
}
