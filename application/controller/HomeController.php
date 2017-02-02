<?php

/**
 * Home controller contain home page
 */
class Home extends Controller
{
    /**
     * Load all artists and stages
     */
    public function index()
    {
        $data['artists'] = ArtistModel::getAllArtists();
        $data['stages'] = StageModel::getAllStages();

        $this->loadView('home/index', $data);
    }
}
