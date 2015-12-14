<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TeamsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for teams
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Teams', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $teams = Teams::find($parameters);
        if (count($teams) == 0) {
            $this->flash->notice("The search did not find any teams");

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $teams,
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
     * Edits a team
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $team = Teams::findFirstByid($id);
            if (!$team) {
                $this->flash->error("team was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "teams",
                    "action" => "index"
                ));
            }

            $this->view->id = $team->id;

            $this->tag->setDefault("id", $team->id);
            $this->tag->setDefault("name", $team->name);
            $this->tag->setDefault("shorthandle", $team->shorthandle);
            $this->tag->setDefault("flag", $team->flag);
            $this->tag->setDefault("link", $team->link);
            $this->tag->setDefault("season_id", $team->season_id);
            $this->tag->setDefault("created_at", $team->created_at);
            $this->tag->setDefault("updated_at", $team->updated_at);
            
        }
    }

    /**
     * Creates a new team
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "index"
            ));
        }

        $team = new Teams();

        $team->name = $this->request->getPost("name");
        $team->shorthandle = $this->request->getPost("shorthandle");
        $team->flag = $this->request->getPost("flag");
        $team->link = $this->request->getPost("link");
        $team->season_id = $this->request->getPost("season_id");
        $team->created_at = $this->request->getPost("created_at");
        $team->updated_at = $this->request->getPost("updated_at");
        

        if (!$team->save()) {
            foreach ($team->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "new"
            ));
        }

        $this->flash->success("team was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "teams",
            "action" => "index"
        ));
    }

    /**
     * Saves a team edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $team = Teams::findFirstByid($id);
        if (!$team) {
            $this->flash->error("team does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "index"
            ));
        }

        $team->name = $this->request->getPost("name");
        $team->shorthandle = $this->request->getPost("shorthandle");
        $team->flag = $this->request->getPost("flag");
        $team->link = $this->request->getPost("link");
        $team->season_id = $this->request->getPost("season_id");
        $team->created_at = $this->request->getPost("created_at");
        $team->updated_at = $this->request->getPost("updated_at");
        

        if (!$team->save()) {

            foreach ($team->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "edit",
                "params" => array($team->id)
            ));
        }

        $this->flash->success("team was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "teams",
            "action" => "index"
        ));
    }

    /**
     * Deletes a team
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $team = Teams::findFirstByid($id);
        if (!$team) {
            $this->flash->error("team was not found");

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "index"
            ));
        }

        if (!$team->delete()) {

            foreach ($team->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "teams",
                "action" => "search"
            ));
        }

        $this->flash->success("team was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "teams",
            "action" => "index"
        ));
    }

}
