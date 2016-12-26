<?php
use SaltedHerring\Debugger;
use SaltedHerring\SaltedCache;
use SaltedHerring\Utilities;

class NameSearchController extends Page_Controller
{
    public function index($request)
    {
        if ($request->isAjax() && $request->isPost()) {
            $search = $request->postVar('search');
            
            if(strlen($search) != mb_strlen($search, 'utf-8')) {
                $utf = $this->to_utf($search);
                $utf = str_replace('&#', '_', $utf);
                $key = '_' . str_replace('-', '_', Utilities::sanitise($utf));
            } else {
                $key = '_' . str_replace('-', '_', Utilities::sanitise($search));
            }

            if ($result = SaltedCache::read('Person', $key)) {
                $result = $result->limit(5);
                return json_encode($result->format());
            }

            $result = Person::get()->filterAny(
                array(
                    'English:PartialMatch'       =>  $search,
                    'EthnicScript:PartialMatch'  =>  $search
                )
            );

            //Debugger::inspect($result->first());
            SaltedCache::save('Person', $key, $result);
            $result = $result->limit(5);

            return json_encode($result->format());
        }
        return $this->httpError(404);
    }

    public function to_utf($kanji_chars)
    {
        //split word
        preg_match_all('/./u', $kanji_chars, $matches);

        $c = "";
        foreach($matches[0] as $m){
                $c .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
        }
        return $c;
    }
}
