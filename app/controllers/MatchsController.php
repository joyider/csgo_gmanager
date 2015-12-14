<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MatchsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for matchs
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Matchs', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $matchs = Matchs::find($parameters);
        if (count($matchs) == 0) {
            $this->flash->notice("The search did not find any matchs");

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $matchs,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a match
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $match = Matchs::findFirstByid($id);
            if (!$match) {
                $this->flash->error("match was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "matchs",
                    "action" => "index"
                ));
            }

            $this->view->id = $match->id;

            $this->tag->setDefault("id", $match->id);
            $this->tag->setDefault("ip", $match->ip);
            $this->tag->setDefault("server_id", $match->server_id);
            $this->tag->setDefault("season_id", $match->season_id);
            $this->tag->setDefault("team_a", $match->team_a);
            $this->tag->setDefault("team_a_flag", $match->team_a_flag);
            $this->tag->setDefault("team_a_name", $match->team_a_name);
            $this->tag->setDefault("team_b", $match->team_b);
            $this->tag->setDefault("team_b_flag", $match->team_b_flag);
            $this->tag->setDefault("team_b_name", $match->team_b_name);
            $this->tag->setDefault("status", $match->status);
            $this->tag->setDefault("score_a", $match->score_a);
            $this->tag->setDefault("score_b", $match->score_b);
            $this->tag->setDefault("max_round", $match->max_round);
            $this->tag->setDefault("rules", $match->rules);
            $this->tag->setDefault("overtime_startmoney", $match->overtime_startmoney);
            $this->tag->setDefault("overtime_max_round", $match->overtime_max_round);
            $this->tag->setDefault("config_full_score", $match->config_full_score);
            $this->tag->setDefault("config_ot", $match->config_ot);
            $this->tag->setDefault("config_streamer", $match->config_streamer);
            $this->tag->setDefault("config_knife_round", $match->config_knife_round);
            $this->tag->setDefault("config_switch_auto", $match->config_switch_auto);
            $this->tag->setDefault("config_auto_change_password", $match->config_auto_change_password);
            $this->tag->setDefault("config_password", $match->config_password);
            $this->tag->setDefault("config_heatmap", $match->config_heatmap);
            $this->tag->setDefault("config_authkey", $match->config_authkey);
            $this->tag->setDefault("enable", $match->enable);
            $this->tag->setDefault("map_selection_mode", $match->map_selection_mode);
            $this->tag->setDefault("ingame_enable", $match->ingame_enable);
            $this->tag->setDefault("current_map", $match->current_map);
            $this->tag->setDefault("force_zoom_match", $match->force_zoom_match);
            $this->tag->setDefault("tv_record_file", $match->tv_record_file);
            $this->tag->setDefault("identifier_id", $match->identifier_id);
            $this->tag->setDefault("created_at", $match->created_at);
            $this->tag->setDefault("updated_at", $match->updated_at);
            $this->tag->setDefault("auto_start", $match->auto_start);
            $this->tag->setDefault("startdate", $match->startdate);
            $this->tag->setDefault("auto_start_time", $match->auto_start_time);
            
        }
    }

    /**
     * Creates a new match
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "index"
            ));
        }

        $match = new Matchs();

        $match->ip = $this->request->getPost("ip");
        $match->server_id = $this->request->getPost("server_id");
        $match->season_id = $this->request->getPost("season_id");
        $match->team_a = $this->request->getPost("team_a");
        $match->team_a_flag = $this->request->getPost("team_a_flag");
        $match->team_a_name = $this->request->getPost("team_a_name");
        $match->team_b = $this->request->getPost("team_b");
        $match->team_b_flag = $this->request->getPost("team_b_flag");
        $match->team_b_name = $this->request->getPost("team_b_name");
        $match->status = $this->request->getPost("status");
        $match->score_a = $this->request->getPost("score_a");
        $match->score_b = $this->request->getPost("score_b");
        $match->max_round = $this->request->getPost("max_round");
        $match->rules = $this->request->getPost("rules");
        $match->overtime_startmoney = $this->request->getPost("overtime_startmoney");
        $match->overtime_max_round = $this->request->getPost("overtime_max_round");
        $match->config_full_score = $this->request->getPost("config_full_score");
        $match->config_ot = $this->request->getPost("config_ot");
        $match->config_streamer = $this->request->getPost("config_streamer");
        $match->config_knife_round = $this->request->getPost("config_knife_round");
        $match->config_switch_auto = $this->request->getPost("config_switch_auto");
        $match->config_auto_change_password = $this->request->getPost("config_auto_change_password");
        $match->config_password = $this->request->getPost("config_password");
        $match->config_heatmap = $this->request->getPost("config_heatmap");
        $match->config_authkey = $this->request->getPost("config_authkey");
        $match->enable = $this->request->getPost("enable");
        $match->map_selection_mode = $this->request->getPost("map_selection_mode");
        $match->ingame_enable = $this->request->getPost("ingame_enable");
        $match->current_map = $this->request->getPost("current_map");
        $match->force_zoom_match = $this->request->getPost("force_zoom_match");
        $match->tv_record_file = $this->request->getPost("tv_record_file");
        $match->identifier_id = $this->request->getPost("identifier_id");
        $match->created_at = $this->request->getPost("created_at");
        $match->updated_at = $this->request->getPost("updated_at");
        $match->auto_start = $this->request->getPost("auto_start");
        $match->startdate = $this->request->getPost("startdate");
        $match->auto_start_time = $this->request->getPost("auto_start_time");
        

        if (!$match->save()) {
            foreach ($match->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "new"
            ));
        }

        $this->flash->success("match was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "matchs",
            "action" => "index"
        ));
    }

    /**
     * Saves a match edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $match = Matchs::findFirstByid($id);
        if (!$match) {
            $this->flash->error("match does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "index"
            ));
        }

        $match->ip = $this->request->getPost("ip");
        $match->server_id = $this->request->getPost("server_id");
        $match->season_id = $this->request->getPost("season_id");
        $match->team_a = $this->request->getPost("team_a");
        $match->team_a_flag = $this->request->getPost("team_a_flag");
        $match->team_a_name = $this->request->getPost("team_a_name");
        $match->team_b = $this->request->getPost("team_b");
        $match->team_b_flag = $this->request->getPost("team_b_flag");
        $match->team_b_name = $this->request->getPost("team_b_name");
        $match->status = $this->request->getPost("status");
        $match->score_a = $this->request->getPost("score_a");
        $match->score_b = $this->request->getPost("score_b");
        $match->max_round = $this->request->getPost("max_round");
        $match->rules = $this->request->getPost("rules");
        $match->overtime_startmoney = $this->request->getPost("overtime_startmoney");
        $match->overtime_max_round = $this->request->getPost("overtime_max_round");
        $match->config_full_score = $this->request->getPost("config_full_score");
        $match->config_ot = $this->request->getPost("config_ot");
        $match->config_streamer = $this->request->getPost("config_streamer");
        $match->config_knife_round = $this->request->getPost("config_knife_round");
        $match->config_switch_auto = $this->request->getPost("config_switch_auto");
        $match->config_auto_change_password = $this->request->getPost("config_auto_change_password");
        $match->config_password = $this->request->getPost("config_password");
        $match->config_heatmap = $this->request->getPost("config_heatmap");
        $match->config_authkey = $this->request->getPost("config_authkey");
        $match->enable = $this->request->getPost("enable");
        $match->map_selection_mode = $this->request->getPost("map_selection_mode");
        $match->ingame_enable = $this->request->getPost("ingame_enable");
        $match->current_map = $this->request->getPost("current_map");
        $match->force_zoom_match = $this->request->getPost("force_zoom_match");
        $match->tv_record_file = $this->request->getPost("tv_record_file");
        $match->identifier_id = $this->request->getPost("identifier_id");
        $match->created_at = $this->request->getPost("created_at");
        $match->updated_at = $this->request->getPost("updated_at");
        $match->auto_start = $this->request->getPost("auto_start");
        $match->startdate = $this->request->getPost("startdate");
        $match->auto_start_time = $this->request->getPost("auto_start_time");
        

        if (!$match->save()) {

            foreach ($match->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "edit",
                "params" => array($match->id)
            ));
        }

        $this->flash->success("match was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "matchs",
            "action" => "index"
        ));
    }

    /**
     * Deletes a match
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $match = Matchs::findFirstByid($id);
        if (!$match) {
            $this->flash->error("match was not found");

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "index"
            ));
        }

        if (!$match->delete()) {

            foreach ($match->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "matchs",
                "action" => "search"
            ));
        }

        $this->flash->success("match was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "matchs",
            "action" => "index"
        ));
    }

}
