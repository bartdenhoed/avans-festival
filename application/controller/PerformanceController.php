<?php

/**
 * Performance controller contains all performance pages
 */
class Performance extends Controller
{
    /**
     * Load performance details page by ID
     * Or set fallback
     */
    public function details($id)
    {
        $performance = PerformanceModel::getPerformance($id);

        if ($performance) {
            $data['performance'] = $performance;
            $data['next_performance'] = PerformanceModel::getNextPerformance($id);
            $data['previous_performance'] = PerformanceModel::getPreviousPerformance($id);

            $this->loadView('performance/details', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Load new performance page with optional selector
     */
    public function add($selector = null, $selectorId = null)
    {
        $artists = ArtistModel::getAllArtists();
        $stages = StageModel::getAllStages();

        if ($artists && $stages) {
            $data['artists'] = $artists;
            $data['stages'] = $stages;
            $data['selector'] = $selector;
            $data['selectorId'] = $selectorId;

            $this->loadView('performance/add', $data);
        } else {
            header('location: ' . URL . '&feedback=nodata');exit;
        }
    }

    /**
     * Get data from post and save in to database using performance model
     */
    public function addPOST($selector, $selectorId)
    {
        if (!empty($_POST)) {
            $data = array(
                'artist'     => $_POST['artist'],
                'stage'      => $_POST['stage'],
                'time_start' => $_POST['time_start'],
                'time_stop'  => $_POST['time_stop']
            );
            $result = PerformanceModel::addPerformance($data);

            if ($result) {
                header('location: ' . URL . $selector . '/details/' . $selectorId . '&feedback=success');exit;
            } else {
                header('location: ' . URL . 'performance/add/' . $selector . '/' . $selectorId . '&feedback=adderror');exit;
            }
        }

        header('location: ' . URL . 'performance/add/' . $selector . '/' . $selectorId . '&feedback=error');exit;
    }

    /**
     * Load performance edit page by ID
     * Or set fallback
     */
    public function edit($id)
    {
        $performance = PerformanceModel::getPerformance($id);

        if ($performance) {
            $data['performance'] = $performance;
            $data['artists'] = ArtistModel::getAllArtists();
            $data['stages'] = StageModel::getAllStages();

            $this->loadView('performance/edit', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from post and save in to database using performance model
     */
    public function editPOST()
    {
        if (!empty($_POST)) {
            $data = array(
                'id'         => $_POST['id'],
                'artist'     => $_POST['artist'],
                'stage'      => $_POST['stage'],
                'time_start' => $_POST['time_start'],
                'time_stop'  => $_POST['time_stop']
            );
            $result = PerformanceModel::editPerformance($data);

            if ($result) {
                header('location: ' . URL . 'performance/details/' . $data['id'] . '&feedback=success');exit;
            } else {
                header('location: ' . URL . 'performance/edit/' . $data['id'] . '&feedback=adderror');exit;
            }
        }

        header('location: ' . URL . 'performance/edit/' . $data['id'] . '&feedback=error');exit;
    }

    /**
     * Load performance delete page by ID
     * Or set fallback
     */
    public function delete($id)
    {
        $performance = PerformanceModel::getPerformance($id);

        if ($performance) {
            $data['performance'] = $performance;

            $this->loadView('performance/delete', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from url and save in to database using performance model
     */
    public function deleteGET($id)
    {
        $result = PerformanceModel::deletePerformance($id);

        if ($result) {
            header('location: ' . URL . '&feedback=success');exit;
        }

        header('location: ' . URL . 'performance/delete/' . $id . '&feedback=error');exit;
    }
}
