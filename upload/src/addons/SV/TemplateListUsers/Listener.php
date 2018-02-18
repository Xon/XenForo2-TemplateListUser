<?php


namespace SV\TemplateListUsers;


use XF\Searcher\User;

class Listener {
	public static function templater_macro_pre_render (
		\XF\Template\Templater $templater,
		&$type,
		&$template,
		&$name,
		array &$arguments,
		array &$globalVars
	){
		/** @var User $searcher */
		$searcher = \XF::app()->searcher('XF:User');
		$searcher->setCriteria(array_intersect_key($arguments, array_flip(['secondary_group_ids', 'not_secondary_group_ids'])));
		$arguments['users'] = $searcher->getFinder()->fetch();
	}
}