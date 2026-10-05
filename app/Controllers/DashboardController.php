<?php

    class DashboardController extends z_controller {

        public function action_index(Request $req, Response $res) {

            return $res->render("example/dashboard");
        }

    }

?>