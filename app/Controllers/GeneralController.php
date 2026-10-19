<?php

class GeneralController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        $catalogs = $req->getModel("Catalog")->getCatalogsForSlide();
        $championCatalogs = $req->getModel("Catalog")->getBestRatedCatalogsForSlide();

        return $res->render("general/index",[
            "catalogs" => $catalogs,
            "championCatalogs" => $championCatalogs,
        ]);
    }


    public function sidebar(Request $req, Response $res)
    {
        new App\Helper\AppHelper();

        return true;
    }

    // CSRF protection: a POST that comes from another site is rejected.
    // Browsers always send the Origin header on cross-site POSTs.
    public function sameOriginOnly(Request $req, Response $res)
    {
        $method = $_SERVER["REQUEST_METHOD"] ?? "GET";
        $origin = $_SERVER["HTTP_ORIGIN"] ?? null;

        if (in_array($method, ["GET", "HEAD", "OPTIONS"], true) || $origin === null) return true;

        $parts = parse_url($origin);
        $originHost = ($parts["host"] ?? "") . (isset($parts["port"]) ? ":" . $parts["port"] : "");

        if (strcasecmp($originHost, $_SERVER["HTTP_HOST"] ?? "") === 0) return true;

        http_response_code(403);
        echo "Anfrage von einer fremden Seite abgelehnt.";
        return false;
    }

    public function shoppingCardCookie(Request $req, Response $res)
    {
        $shoppingCartIdentifier = $req->getCookie("shoppingCardId");

        // Make sure a cookie is set
        if(empty($shoppingCartIdentifier)) {
            $shoppingCartIdentifier = bin2hex(random_bytes(32));
            $res->setCookie(
                "shoppingCardId",
                $shoppingCartIdentifier,
                time() + TIMESPAN_DAY_7, "/",
            );
            $req->input->COOKIE["shoppingCardId"] = $shoppingCartIdentifier;
        }

        return true;
    }

}
