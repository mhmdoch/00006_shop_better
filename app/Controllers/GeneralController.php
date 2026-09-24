<?php

class GeneralController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        $examples = $req->getModel("Example")->getExamples();

        return $res->render("general/index", [
            "examples" => $examples,
        ]);
    }


    public function sidebar(Request $req, Response $res)
    {
        new App\Helper\AppHelper();

        return true;
    }

    public function shoppingCardCookie(Request $req, Response $res)
    {
        $shoppingCartIdentifier = $req->getCookie("shoppingCardId");

        // Make sure a cookie is set
        if(empty($shoppingCartIdentifier)) {
            $shoppingCartIdentifier = uniqid(true);
            $res->setCookie(
                "shoppingCardId",
                $shoppingCartIdentifier,
                time() + TIMESPAN_DAY_7, "/",
            );
        }

        return true;
    }

}
