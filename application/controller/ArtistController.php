<?php

/**
 * Artist controller contains all artist pages
 */
class Artist extends Controller
{
    /**
     * Load artist details page by ID
     * Or set fallback
     */
    public function details($id)
    {
        $artist = ArtistModel::getArtist($id);

        if ($artist) {
            $data['artist'] = $artist;
            $data['performances'] = PerformanceModel::getPerformancesByArtist($id);

            $this->loadView('artist/details', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Load new artist page
     */
    public function add()
    {
        $this->loadView('artist/add');
    }

    /**
     * Get data from post and save in to database using artist model
     */
    public function addPOST()
    {
        if (!empty($_POST)) {
            $data = array(
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $result = ArtistModel::addArtist($data);

            if ($result) {
                header('location: ' . URL . '&feedback=success');exit;
            }
        }

        header('location: ' . URL . 'artist/add&feedback=error');exit;
    }

    /**
     * Load artist edit page by ID
     * Or set fallback
     */
    public function edit($id)
    {
        $artist = ArtistModel::getArtist($id);

        if ($artist) {
            $data['artist'] = $artist;

            $this->loadView('artist/edit', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from post and save in to database using artist model
     */
    public function editPOST()
    {
        if (!empty($_POST)) {
            $data = array(
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $result = ArtistModel::editArtist($data);

            if ($result) {
                header('location: ' . URL . 'artist/details/' . $data['id'] . '&feedback=success');exit;
            }
        }

        header('location: ' . URL . 'artist/edit/' . $data['id'] . '&feedback=error');exit;
    }

    /**
     * Load artist delete page by ID
     * Or set fallback
     */
    public function delete($id)
    {
        $artist = ArtistModel::getArtist($id);

        if ($artist) {
            $data['artist'] = $artist;

            $this->loadView('artist/delete', $data);
        } else {
            header('location: ' . URL . '&feedback=notfound');exit;
        }
    }

    /**
     * Get data from url and save in to database using artist model
     */
    public function deleteGET($id = null)
    {
        $result = ArtistModel::deleteArtist($id);

        if ($result) {
            header('location: ' . URL . '&feedback=success');exit;
        }

        header('location: ' . URL . 'artist/details/' . $id . '&feedback=error');exit;
    }
}
