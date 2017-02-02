<?php

class PersonAdmin extends ModelAdmin
{
	private static $managed_models = array('Person');
	private static $url_segment = 'names';
	private static $menu_title = 'Names';

	public function getEditForm($id = null, $fields = null)
    {
		$form = parent::getEditForm($id, $fields);

		$grid = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
		$grid->getConfig()
			->removeComponentsByType('GridFieldPaginator')
			// ->removeComponentsByType('GridFieldExportButton')
			->removeComponentsByType('GridFieldPrintButton')
			->addComponents(
				new GridFieldPaginatorWithShowAll(30)
			);
		return $form;
	}
}
