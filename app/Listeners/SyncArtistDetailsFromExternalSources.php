<?php

namespace App\Listeners;

use App\Events\ArtistCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Artist;
use Jolita\DiscogsApi\SearchParameters;
use Discogs;

class SyncArtistDetailsFromExternalSources implements ShouldQueue
{
    use InteractsWithQueue;


    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArtistCreated $event
     * @return void
     */
    public function handle(ArtistCreated $event)
    {
        // TODO(30 jun 2018) ~ Helge: Should do a search on Discogs and other external services and sync more details about this artist.
        $stage_name = $event->artist->stage_name;
        $searchParameters = new SearchParameters();
        $searchParameters->settype('artist');
        $discogsResult = Discogs::search($stage_name, $searchParameters);
        $result = Discogs::artist($discogsResult->results[0]->id);
        $artist = Artist::findOrFail($event->artist->id);
        if ($result->profile === "") {
        } else {
        $bio = $result->profile;
        $bio = str_replace('[b]', '', $bio);
        $bio = str_replace('[/b]', '', $bio);
        $bio = str_replace('[u]', '', $bio);
        $bio = str_replace('[/u]', '', $bio);
        $bio = str_replace('[i]', '', $bio);
        $bio = str_replace('[/i]', '', $bio);
        $artist->discogs_bio = $bio;
        $artist->discogs_id = $result->id;
        }
        $artist->save();
    }

    public function removeTags($text){

    }
}
