<?php

/**
 * Stage controller contains all stages pages
 */
class Stage extends Controller
{
    /**
     * Load artist details page by ID
     * Or set fallback
     */
    public function details($id)
    {
        $stage = StageModel::getStage($id);

        if ($stage) {
            $data['stage'] = $stage;
            $data['performances'] = PerformanceModel::getPerformancesByStage($id);

            $this->loadView('stage/details', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Load new stage page
     */
    public function add()
    {
        $this->loadView('stage/add');
    }

    /**
     * Get data from post and save in to database using stage model
     */
    public function addPOST()
    {
        if (!empty($_POST)) {
            $data = array(
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $result = StageModel::addStage($data);

            if ($result) {
                header('location: ' . URL . '&feedback=success');exit;
            }
        }

        header('location: ' . URL . 'stage/add&feedback=error');exit;
    }

    /**
     * Load stage edit page by ID
     * Or set fallback
     */
    public function edit($id)
    {
        $stage = StageModel::getStage($id);

        if ($stage) {
            $data['stage'] = $stage;
            $data['performances'] = PerformanceModel::getPerformancesByStage($id);

            $this->loadView('stage/edit', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from post and save in to database using stage model
     */
    public function editPOST()
    {
        if (!empty($_POST)) {
            $data = array(
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $result = StageModel::editStage($data);

            if ($result) {
                header('location: ' . URL . 'stage/details/' . $data['id'] . '&feedback=success');exit;
            }
        }

        header('location: ' . URL . 'stage/edit/' . $data['id'] . '&feedback=error');exit;
    }

    /**
     * Load stage delete page by ID
     * Or set fallback
     */
    public function delete($id)
    {
        $stage = StageModel::getStage($id);

        if ($stage) {
            $data['stage'] = $stage;

            $this->loadView('stage/delete', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from url and save in to database using stage model
     */
    public function deleteGET($id = null)
    {
        $result = StageModel::deleteStage($id);

        if ($result) {
            header('location: ' . URL . '&feedback=success');exit;
        }

        header('location: ' . URL . 'stage/details/' . $id . '&feedback=error');exit;
    }

}
