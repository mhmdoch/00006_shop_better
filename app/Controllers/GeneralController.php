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

        // $sideBarElements = $req->getModel("Category")->getNavCategories();
        // $menuCategory = $req->getParameters(-2, 1) ?: "";
        //  $req->store["sideBarElements"] = $sideBarElements;
        // $req->store["menuCategory"] = $menuCategory;
        return true;
    }
}
