<?php

namespace SV\TemplateListUsers;

use XF\Searcher\User;
use XF\Template\Templater;

abstract class Listener
{
    /** @noinspection PhpUnusedParameterInspection */
    public static function templater_macro_pre_render(Templater $templater, string &$type, string &$template, string &$name, array &$arguments, array &$globalVars): void
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
