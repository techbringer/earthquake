<?php
use SaltedHerring\Debugger;
class NameFinderPage extends Page
{

}

class NameFinderPage_Controller extends Page_Controller
{
    public function getPeople()
    {
        $people = Person::get();
        return $people;
        $excl = array();
        foreach ($people as $person) {
            if ($person->Found()) {
                $excl[] = $person->ID;
            }
        }

        return $people->exclude('ID', $excl);
    }

    public function index($request)
    {
        if ($request->isPost() && $request->isAjax() && !empty(Member::currentUser())) {
            $pv = $request->postVars();

            $id = $pv['id'];
            $x = $pv['x'];
            $width = $pv['width'];
            $row = $pv['inRow'];

            $person = Person::get()->byID($id);
            $person->x = $x;
            $person->width = $width;
            $person->inRow = $row;
            $person->write();

            return json_encode($person->getRect());
        }
        return $this->renderWith(array('NameFinderPage', 'Page'));
    }
}
