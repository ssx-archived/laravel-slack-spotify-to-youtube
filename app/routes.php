<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::any('/inbound/slack/notshinyunicorn/general', function()
{
    $x = Input::all();

    $strText = str_replace("<http://", "", $x["text"]);
    $strText = str_replace("<https://", "", $strText);

    if (substr($strText, 0, 23) == "open.spotify.com/track/")
    {
        $strText = str_replace("open.spotify.com/track/", "", $strText);
        $strText = str_replace(">", "", $strText);

        $strTest = file_get_contents("https://api.spotify.com/v1/tracks/".$strText);

        $json = ($objJSON = json_decode($strTest));

        $youtube = new \Madcoda\Youtube(array('key' => $_ENV["YOUTUBE_KEY"]));
        $videoList = $youtube->searchVideos($json->artists[0]->name." ".$json->name);

        if (isset($videoList[0]->id->videoId))
        {
            Slack::to('#'.$x["channel_name"])->send("https://www.youtube.com/watch?v=".$videoList[0]->id->videoId);
        } else
        {
            Slack::to('#'.$x["channel_name"])->send("No match found for Spotify track.");
        }
    }
});

